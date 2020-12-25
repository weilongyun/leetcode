<?php
namespace com\bj58\spat\scf\transport\core;
use com\bj58\spat\scf\transport\builder\SF_ScfClientBuilder;
use com\bj58\spat\scf\transport\util\SF_Duration;
use com\bj58\spat\scf\transport\exception\SF_ServiceLocationClientException;
use com\bj58\spat\scf\client\configuration\SCFConfig;
use com\bj58\spat\scf\transport\exception\SF_ServiceException;

class SF_ScfServiceState {
    /**
     * @var array
     * array(
     *    serviceName=>SF_NodeStates
     * )
     */
    private static $all_states = array();

    /**
     * @var array
     */
    private static $_SERVICE_CREATETIME = array();

    /**
     * @var int
     */
    private static $_SERVICE_EXPIRE = 10;

    /**
     * @var int
     */
    private static $_APCU_REGCENTER_TTL = 3600;

    private $scfConfig;

    /**
     * @param SF_ScfClientBuilder $builder
     * @throws LengthException
     * @return SF_NodeState
     */
    public function getState(SF_ScfClientBuilder $builder) {
        // lookup all_states
        $serviceName = $builder->serviceName;
        $scfkey = $builder->getScfkeyPath();
        $currentTime = time();
        if(!array_key_exists($scfkey, self::$all_states) || !array_key_exists($serviceName, self::$all_states[$scfkey])
            || (isset(self::$_SERVICE_CREATETIME[$scfkey][$serviceName]) && $currentTime - self::$_SERVICE_CREATETIME[$scfkey][$serviceName] > self::$_SERVICE_EXPIRE)) {
            self::$all_states[$scfkey][$serviceName] = $this->loadStates($builder);   // SF_NodeStates
        }

        $nodeStates = self::$all_states[$scfkey][$serviceName];
        $this->setRWTime($builder, $nodeStates);
        // models
        $models = $nodeStates->getNodeStates();    // []SF_NodeState鏁扮粍

        $len = count($models);
        if($len < 1) {
            throw new SF_ServiceException('no remote server effective!');
        }

        // balancer.
        $loadBalancer = $builder->loadBalancer;
        return $loadBalancer->match(array_values($models));
    }

    public static function removeLocalStates($serviceName) {
        if(array_key_exists($serviceName, self::$all_states)) {
            unset(self::$all_states[$serviceName]);
        }
    }

    private static $INSTANCE;
    public static function INSTANCE() {
        if(self::$INSTANCE === null) {
            self::$INSTANCE = new self();
        }

        return self::$INSTANCE;
    }

    private function __construct() {

    }

    /**
     * @param SF_ScfClientBuilder $builder
     * @param SF_NodeStates $nodeStates
     */
    private function setRWTime(SF_ScfClientBuilder $builder, SF_NodeStates $nodeStates) {

        $builder->tcpConnectTimeout(new SF_Duration($nodeStates->getSendTimeout(), SF_Duration::UNIT_MILLISECONDS));

        $builder->responseTimeout(new SF_Duration($nodeStates->getReceiveTimeout(), SF_Duration::UNIT_MILLISECONDS));

    }

    /**
     * @param SF_ScfClientBuilder $builder
     * @return SF_NodeStates
     */
    private function loadStates(SF_ScfClientBuilder $builder) {
        // load_from_apcu
        $apcu_key = md5($builder->getScfkeyPath()) . self::getapcuKey($builder->serviceName);
        $apcu_key_local = $apcu_key . '_local';

        $nodeStates = null;
        if(apcu_exists($apcu_key)) {
            $nodeStates = self::readApcu($apcu_key);
        } else {
            try {
                $this->scfConfig = $this->readRegCenter($builder);

                if(!$this->scfConfig && !$this->scfConfig['host']) {
                    throw new SF_ServiceException('Read config failure!');
                }

                # nodeStates
                $nodeStates = new SF_NodeStates();
                $nodeStates->setSendTimeout($this->scfConfig['sendTimeout']);
                $nodeStates->setReceiveTimeout($this->scfConfig['receiveTimeout']);
                $host = $this->scfConfig['hosts'];
                foreach ($host as $k => $v) {
                    $nodeState = new SF_NodeState();
                    $nodeState->host($v['host']);
                    $nodeState->port($v['port']);
                    $nodeState->weight($v['weight']);

                    $nodeStates->setNodeState($nodeState->key(), $nodeState);
                }

                $nodeStates->setCreateTime(SF_Duration::fromSeconds(time()));

                # write to apcu
                $this->writeApcu($apcu_key, $nodeStates, $nodeStates->getApcuStoreTTL());

                $this->writeApcu($apcu_key_local, $nodeStates, self::$_APCU_REGCENTER_TTL);

            } catch (\Exception $e) {

                if(apcu_exists($apcu_key_local)) {
                    $nodeStates = self::readApcu($apcu_key_local);
                }

                if (!($nodeStates instanceof SF_NodeStates)) {
                    throw new SF_ServiceException($e->getMessage());
                }

            }
        }

        $this->setRWTime($builder, $nodeStates);

        self::$_SERVICE_CREATETIME[$builder->getScfkeyPath()][$builder->serviceName] = time();
        return $nodeStates;
    }

    public function loadStatesFromApcuBykey(SF_ScfClientBuilder $builder, $node_key) {
//         $apcu_key = self::getApcuKey($builder->serviceName);
        $apcu_key = md5($builder->getScfkeyPath()) . self::getapcuKey($builder->serviceName);

        if(apcu_exists($apcu_key)) {
            if($nodeStates = self::readApcu($apcu_key)) {
                $models = $nodeStates->getNodeStates();
                if(array_key_exists($node_key, $models)) {
                    return $models[$node_key];
                }
            }
        }

        return false;
    }

    public static function setHostsState($serviceName, $hosts) {
        $nodeStates = new SF_NodeStates();
        $nodeStates->setCreateTime(SF_Duration::fromSeconds(time()));

        foreach ($hosts as $hostModel) {
            $dataModel = new SF_NodeState();
            $dataModel->host($hostModel['host']);
            $dataModel->port($hostModel['port']);
            $dataModel->weight($hostModel['weight']);
            $nodeStates->setNodeState($dataModel->key(), $dataModel);
        }
        self::setStates($serviceName, $nodeStates);
    }

    public static function removeState($serviceName) {
        unset(self::$all_states[$serviceName]);
    }

    public static function setStates($serviceName, $nodeStates) {
        self::$all_states[$serviceName] = $nodeStates;
    }

    /**
     * @param string $name
     * @return string
     */
    private static function getApcuKey($name) {
        return urlencode('Finagle_'. $name);
    }

    /**
     * @param SF_NodeState  $state
     */
    private function writeApcu($key, $value, $expireTime) {
        apcu_store($key, $value, $expireTime);
    }

    /**
     *  @return SF_NodeState
     */
    private static function readApcu($apcu_key) {
        return apcu_fetch($apcu_key);
    }

    /**
     * @return config['sendTimeout', 'receiveTimeout', 'host'[host, port, weight]]
     */
    private function readRegCenter(SF_ScfClientBuilder $builder) {
        return SCFConfig::getServerConfig($builder->getScfkeyPath(), $builder->getServiceName());
    }

    /**
     * @param SF_ScfClientBuilder $builder
     * @param SF_NodeState $stateModel
     */
    public static function nodeStateModifyNotify(SF_ScfClientBuilder $builder, SF_NodeState $stateModel) {
        self::INSTANCE()->updateApcuNodeState($builder, $stateModel);

        self::INSTANCE()->updateAllStatesNodeState($builder, $stateModel);
    }

    private function updateApcuNodeState(SF_ScfClientBuilder $builder, SF_NodeState $newNodeState) {
        $apcuKey = md5($builder->getScfkeyPath()) . self::getapcuKey($builder->serviceName);
        if(apcu_exists($apcuKey)) {
            if($obj = $this->readApcu($apcuKey)) {
                if($nodeStates = $obj->getNodeStates()) {
                    if(array_key_exists($newNodeState->key(), $nodeStates)){
                        $obj->setNodeState($newNodeState->key(), $newNodeState);

                        $expire_time = $obj->getApcuStoreTTL() - SF_Duration::timeIntervalInSeconds(SF_Duration::fromSeconds(time()), $obj->getCreateTime());
                        if($expire_time > 0) {
                            $this->writeApcu($apcuKey, $obj, $expire_time);
                        }
                    }
                }
            }
        }
    }

    private function updateAllStatesNodeState(SF_ScfClientBuilder $builder, SF_NodeState $newNodeState) {
        $scfkey = $builder->getScfkeyPath();
        if(array_key_exists($scfkey, self::$all_states) && array_key_exists($builder->serviceName, self::$all_states[$scfkey])){
            self::$all_states[$scfkey][$builder->serviceName]->setNodeState($newNodeState->key(), $newNodeState);
        }
    }
}
