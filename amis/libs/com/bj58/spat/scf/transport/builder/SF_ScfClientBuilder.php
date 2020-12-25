<?php
namespace com\bj58\spat\scf\transport\builder;

use com\bj58\spat\scf\transport\core\SF_RetryPolicy;
use com\bj58\spat\scf\transport\loadbalancer\SF_RoundRobinBalancer;
use com\bj58\spat\scf\transport\core\SF_ScfService;
use com\bj58\spat\scf\transport\util\SF_Duration;
use com\bj58\spat\scf\client\InitObj;
use com\bj58\spat\scf\exception\ScfException;
class SF_ScfClientBuilder{
    /**
     * 做负载均衡的类
     * @var unknown
     */
    private $loadBalancer;

    /**
     * 协议解析类
     * @var unknown
     */
    private $clientFactory;

    /**
     * 重试策略
     * @var SF_RetryPolicys
     */
    private $retryPolicy;

    /**
     * clientBuilder实例
     * @var SF_ScfClientBuilder
     */
    private $clientBuilder;

    /**
     * 服务名称
     * @var string
     */
    private $serviceName;

    /**
     * tcp读超时时间
     * SF_Duration
     */
    private $timeout;

    /**
     * scf init obj
     * @var unknown
     */
    private $scfkeyPath;

    /**
     * tcp连接/写超时时间
     * @var SF_Duration
     */
    private $tcpConnectTimeout;

    private function apply() {
        return new ClientBuilder();
    }

    public function get() {
        return $this->apply();
    }

    public function __construct($scfkeyPath = '') {
        $this->scfkeyPath = $scfkeyPath;
    }

    /**
     * @return SF_ScfService
     * @throws Exception
     */
    function build() {

        # 默认不重试
        if(!$this->retryPolicy) {
            $this->retryPolicy = new SF_RetryPolicy(
                1,
                SF_RetryPolicy::$DEFAULT_INTERVAL
            );
        }

        # 默认用加权轮询
        if(!$this->loadBalancer) {
            $this->loadBalancer = new SF_RoundRobinBalancer();
        }

        return new SF_ScfService($this);
    }

    /**
     * The logical destination of requests dispatched through this
     * client.
     */
    function destName($name) {
        $this->serviceName=$name;
        return $this;
    }

    /**
     * @return 返回当前服务的服务名(去掉uuid的)
     */
    function getServiceName() {
        $simpleService = explode('-', $this->serviceName);
        return $simpleService[0];
    }

    /**
     * @param SF_Duration $resTimeout
     * @brief 设定响应超时时间
     * @return SF_ScfClientBuilders
     */
    function responseTimeout(SF_Duration $resTimeout) {
//         assert( is_a( $resTimeout , "SF_Duration" ));
        $this->timeout = $resTimeout;
        return $this;
    }

    /**
     * @param SF_Duration $timeout
     * @brief 设定连接超时时间
     * @return SF_ScfClientBuilder
     */
    public function tcpConnectTimeout(SF_Duration $timeout) {
        $this->tcpConnectTimeout=$timeout;
        return $this;
    }

    /**
     * 传入clientFactory。
     * @param $clientFactory
     * @return SF_ScfClientBuilder
     */
    function clientFactory($clientFactory) {
        $this->clientFactory=$clientFactory;
        return $this;
    }

    function getClientFactory() {
        return $this->clientFactory;
    }

    /**
     * 负责均衡策略
     * @param $factory
     * @return SF_ScfClientBuilder
     */
    public function loadBalance($factory) {
        $loadBalancer = $factory->get();
        $this->loadBalancer=$loadBalancer;
        return $this;
    }

    public function getLoadBalancer() {
        return $this->loadBalancer;
    }

    public function retries($times) {
        $retryPolicy = new SF_RetryPolicy($times, SF_RetryPolicy::$DEFAULT_INTERVAL);
        $this->retryPolicy($retryPolicy);
        return $this;
    }

    public function retryPolicy($retryPolicy) {
        $this->retryPolicy=$retryPolicy;
        return $this;
    }

 public function __get($name) {
        return $this->$name;
    }

    public function getScfkeyPath()
    {
        return $this->scfkeyPath;
    }

    public function setScfkeyPath($scfkeyPath)
    {
        $this->scfkeyPath = $scfkeyPath;
        return $this;
    }

}