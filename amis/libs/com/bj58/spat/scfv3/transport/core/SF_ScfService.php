<?php
namespace com\bj58\spat\scf\transport\core;

use com\bj58\spat\scf\transport\loadbalancer\SF_RoundRobinBalancer;
use com\bj58\spat\scf\transport\exception\SF_FatalException;
use com\bj58\spat\scf\transport\exception\SF_NormalException;
use com\bj58\spat\scf\client\utility\LogHelper;

class SF_ScfService
{

    public $clientBuilder;

    /**
     * 当前连接保存下来。
     *
     * @var unknown
     */
    public $current_remote_client;

    /**
     * 当前被选中的远程服务节点。
     *
     * @var unknown
     */
    public $current_node;

    function __construct($clientBuilder)
    {
        $this->clientBuilder = $clientBuilder;
    }

    /**
     * 获取当前被选中的远程服务节点
     *
     * @return SF_NodeState
     */
    public function getCurrentNode()
    {
        return $this->current_node;
    }

    /**
     * 调用流程
     * 调用远程接口，如果接口出错，如果出现Exception，则通知SF_ServiceState，
     * 然后根据retry策略，如果不能retry，则抛出异常。否则进行retry
     *
     * @param
     *            $method
     * @param mixed $args
     * @throws SF_ServiceLocationClientException BadMethodCallException
     *         SF_SocketException SF_SocketTimeoutException
     */
    function __call($method, $args)
    {
        $retryTimes = $this->clientBuilder->retryPolicy->times();
        $retryInterval = $this->clientBuilder->retryPolicy->interval();
        $clientFactory = $this->clientBuilder->getClientFactory();

        // reset failed_node for next call
        $this->clientBuilder->loadBalancer->reset();
        for ($i = 0; $i < $retryTimes; $i ++) {
            try {
                if (! $this->current_remote_client) {

                    $this->current_node = SF_ScfServiceState::INSTANCE()->getState($this->clientBuilder);
                    // 从client缓存中检查是否有client，如果没有，则创建一个。
                    $this->current_remote_client = $clientFactory->getClient($this->clientBuilder, $this->current_node->host, $this->current_node->port);
                }
                $result = call_user_func_array(array(
                    $this->current_remote_client,
                    $method
                ), $args);
                if ($this->current_node) {
                    $this->current_node->success();

                    if ($this->clientBuilder->getLoadBalancer() instanceof SF_RoundRobinBalancer) {
                        SF_ScfServiceState::nodeStateModifyNotify($this->clientBuilder, $this->current_node);
                    }

                    if ($this->current_node->resume) {
                        // 恢复apcu中node的状态
                        $this->current_node->setResume(false);
                        SF_ScfServiceState::nodeStateModifyNotify($this->clientBuilder, $this->current_node);
                    }
                }
                $res = array(
                    'value' => $result,
                    'scfservice' => $this
                );
                return $res;
            } catch (\BadMethodCallException $e) {
                // 销毁client
                $this->closeCurrentClient();
                throw $e;
            } catch (SF_FatalException $e) {
                $this->closeCurrentClient();
                throw $e;
            } catch (SF_NormalException $e) { // timeout类异常需要进行重试
                if ($this->current_node) {
                    $node_key = $this->current_node->key();

                    $nodeAtApcu = SF_ScfServiceState::INSTANCE()->loadStatesFromApcuBykey($this->clientBuilder, $node_key);
                    if (! $nodeAtApcu) {
                        $nodeAtApcu = $this->current_node;
                    }

                    // 瞬时读出，瞬时写入。
                    if ($nodeAtApcu) {
                        if ($e->getCode() == 10) {
                            $nodeAtApcu->fail(4);
                            //$retryTimes = 2;
                            LogHelper::logWarnMsg("scf retry match server. cause " . $e->getMessage());
                        } else {
                            $nodeAtApcu->fail();
                        }
                        $this->clientBuilder->loadBalancer->fail($nodeAtApcu); // mark node failed
                        SF_ScfServiceState::nodeStateModifyNotify($this->clientBuilder, $nodeAtApcu);
                    }
                }

                $this->closeCurrentClient();

                //如果失败次数已经到了，则抛出异常
                if($retryTimes > 0 && $i === $retryTimes - 1) {
                    throw $e;
                }
                if($retryInterval > 0) {
                    sleep($retryInterval);
                }

                continue;
            } catch (\Exception $e) { // 其他未知错误
                $this->closeCurrentClient();
                throw $e;
            }
        }
    }

    private function closeCurrentClient()
    {
        if ($this->current_remote_client) {
            $this->current_remote_client->close();
        }
        $this->current_remote_client = null;
    }

    public function __set($field, $value)
    {
        $this->$field = $value;
    }

    public function __destruct()
    {
        $this->closeCurrentClient();
    }

    public function closeClient()
    {
        $this->closeCurrentClient();
    }
}