<?php
namespace com\bj58\spat\scf\client\configuration\scfmanager;

class ServiceConfigManager
{
    private static $_INSTANCE;
    private $managerServerDispatcher;//ManagerServerDispatch

    public static function INSTANCE()
    {
        if(self::$_INSTANCE === null) {
            self::$_INSTANCE = new self();
        }

        return self::$_INSTANCE;
    }

    private function __construct()
    {
        $ippairs = ManagerProperties::getManagerIps();
        $port = ManagerProperties::getManagerPort();
        $managerServerConfigs = array();
        foreach ($ippairs as $ip) {
            $managerServerConfig = new ManagerServerConfig($ip, $port);
            array_push($managerServerConfigs, $managerServerConfig);
        }
        $this->managerServerDispatcher = new ManagerServerDispatch($managerServerConfigs);
    }

    /**
     *
     * @param unknown $servicename
     * @param unknown $time
     * @param unknown $scfkey
     */
    public function getServiceConfig($servicename, $time, $scfkey)
    {
        if (null === $scfkey) {
            return null;
        }
        $req = '{"sessionId":1 ,"serviceName":"' .  $servicename . '" ,';
        $req = $req . '"scfKey":"' . $scfkey . '" ,';
        $req = $req . '"configTime":' . $time . ' }';

        $sendManagerServer = $this->managerServerDispatcher->getManagerServer();
        if (null !== $sendManagerServer && $sendManagerServer->isConnected()) {
            try {
                $reqProtocol = new SSMReqProtocol();
                $reqProtocol->setType(0);
                $sendData = $reqProtocol->dataCreate($req);
                $recvData = $sendManagerServer->sendMessage($sendData);
                return $recvData;
            } catch (\Exception $e) {
                $sendManagerServer->destroySocket();
                throw $e;
            }
        }
        return null;
    }

    /**
     * @return SSMRespData
     */
    public function getRespData($servicename, $time, $scfkey)
    {
        try {
            $data = self::getServiceConfig($servicename, $time, $scfkey);
            $resp = null;
            if (null !== $data) {
                $resp = SSMRespData::fromBytes($data);
            }
            return $resp;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

?>