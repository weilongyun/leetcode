<?php
namespace com\bj58\spat\scf\client\proxy;

use com\bj58\spat\scf\protocol\sdp\RequestProtocol;
use com\bj58\spat\scf\protocol\utility\KeyValuePair;
use com\bj58\spat\scf\client\SCFConst;
use com\bj58\spat\scf\client\utility\ProtocolHelper;
use com\bj58\spat\scf\protocol\sfp\Protocol;
use com\bj58\spat\scf\protocol\sfp\enumeration\SDPType;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\client\configuration\SCFConfig;
use com\bj58\spat\scf\transport\builder\SF_ScfClientBuilder;
use com\bj58\spat\scf\transport\client\SF_ScfClientFactory;
use com\bj58\spat\scf\transport\loadbalancer\SF_RoundRobinLoadBalancerFactory;
use com\bj58\spat\scf\transport\core\SF_ScfServiceState;
use com\bj58\spat\scf\client\utility\LogHelper;

class MethodCaller
{

    public static function doMethodCall($param, $methodName, $serviceName, $lookup, $initObj = '', $SerGlobal = false)
    {
        try {
            //read config file
            if ($GLOBALS['SCF_IS_GLOBAL_PATH'] || !$initObj) {
                $scfKeyPath = $GLOBALS['SCF_DEFAULT_SCFKEY_PATH'];
            } else {
                $scfKeyPath = $initObj->getDefaultScfkeyPath();
            }

            $scfKeyPathMd5 = '';
            SCFConfig::loadConfigByScfKey($scfKeyPath, $serviceName, 0, $scfKeyPathMd5);
            $kvPair = array();
            foreach ($param as $k => $v) {
                $index = stripos($k, '@');
                if ($index) {
                    $k = substr($k, $index + 1);
                }
                $value = new KeyValuePair($k, $v);
                $kvPair[] = $value;
            }
            $temp = strpos($methodName, '_PHP_');
            if ($temp !== false) {
                $methodName = substr($methodName, 0, $temp);
            }

            //report version
//             MonitorHelper::reportVersion($scfKeyPathMd5);

            $requestProtocol = new RequestProtocol($lookup, $methodName, $kvPair);
            $sendP = ProtocolHelper::createProtocol($requestProtocol, MethodCaller::createSessionId(), $serviceName, $scfKeyPath, $scfKeyPathMd5);

            if ($SerGlobal) {
                $requestBinaryData = Protocol::toBytes($sendP, $initObj);
                $data = MethodCaller::request($requestBinaryData, $serviceName, $scfKeyPath);
                $responseBinarydata = $data['value'];
                $result = Protocol::fromBytes($responseBinarydata, $initObj);
            } else {
                $requestBinaryData = Protocol::toBytes($sendP);
                $data = MethodCaller::request($requestBinaryData, $serviceName, $scfKeyPath);
                $responseBinarydata = $data['value'];
                $result = Protocol::fromBytes($responseBinarydata);
            }

            if ($result->getSdpType() == SDPType::Response) {
                $responseProtocol = $result->getSdpEntity();
                $res = $responseProtocol-> getResult();
                if (null === $res) {
                    $outpara = $responseProtocol->getOutpara();
                    return $outpara;
                } else {
                    return $res;
                }
            } else if ($result->getSdpType() == SDPType::Exception) {
                throw new ScfException($result->getSdpEntity()->getErrorMsg());
            } else if ($result->getSdpType() == SDPType::Reset){
                if (array_key_exists('scfservice', $data)) {
                    $scfService = $data['scfservice'];
                    $currentNode = $scfService->current_node;
                    $clientBuilder = $scfService->clientBuilder;
                    $node_key = $currentNode->key();

                    $nodeAtApcu = SF_ScfServiceState::INSTANCE()->loadStatesFromApcuBykey($clientBuilder, $node_key);
                    if (! $nodeAtApcu) {
                        $nodeAtApcu = $currentNode;
                    }

                    // 瞬时读出，瞬时写入。
                    if ($nodeAtApcu) {
                        $nodeAtApcu->fail(10);
                        LogHelper::logWarnMsg("server is reboot, delete nodes");
                        $clientBuilder->loadBalancer->fail($nodeAtApcu); // mark node failed
                        SF_ScfServiceState::nodeStateModifyNotify($clientBuilder, $nodeAtApcu);
                    }
                }

                $scfService->current_remote_client->close();
                $scfService->current_remote_client = null;
                throw new ScfException("server is reboot!");
            } else {
                throw new ScfException("userdatatype error!");
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function request($requestBinaryData, $serviceName, $scfkeyPath = '')
    {
        $responseBinaryData = '';
        $builder = new SF_ScfClientBuilder($scfkeyPath);
        $builder->clientFactory(new SF_ScfClientFactory())// scf client
            -> loadBalance(new SF_RoundRobinLoadBalancerFactory())
            -> destName($serviceName)
            -> retries(3);
        $impl = $builder->build();

        try {
            $responseBinaryData = $impl->request($requestBinaryData);
            return $responseBinaryData;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function createSessionId() {
        if (array_key_exists('scf_sessionId', $GLOBALS)) {
            $sid = $GLOBALS['scf_sessionId'];
            if ($sid > SCFConst::MAX_SESSIONID) {
                $GLOBALS['scf_sessionId'] = 1;
            } else {
                $GLOBALS['scf_sessionId'] = $sid + 1;
            }
        } else {
            $GLOBALS['scf_sessionId'] = 1;
        }
        return $GLOBALS['scf_sessionId'];
    }

}
