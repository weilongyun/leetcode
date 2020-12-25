<?php
namespace com\bj58\spat\scf\client\monitor;

class ServiceMoniter
{
    private static $_INSTANCE;
    private $monitorServerDispatch;//ManagerServerDispatch

    public static function INSTANCE()
    {
        if(self::$_INSTANCE === null) {
            self::$_INSTANCE = new self();
        }

        return self::$_INSTANCE;
    }

    private function __construct()
    {
        $ippairs = MonitorProperties::getManagerIps();
        $port = MonitorProperties::getManagerPort();
        $monitorServerConfigs = array();
        foreach ($ippairs as $ip) {
            $monitorServerConfig = new MonitorServerConfig($ip, $port);
            $monitorServerConfigs[] = $monitorServerConfig;
        }
        $this->monitorServerDispatch = new MonitorServerDispatch($monitorServerConfigs);
    }

    /**
     * @return SSMRespData
     */
    public function sendReqData($content)
    {
        try {
            if (null !== $content) {
                $sendManagerServer = $this->monitorServerDispatch->getMonitorServer();
                if (null !== $sendManagerServer && $sendManagerServer->isConnected()) {
                    try {
                        $reqProtocol = new MonitorReqProtocol();
                        $reqProtocol->setType(5);
                        $sendData = $reqProtocol->dataCreate($content);
//                         $sendData .= '\n';
                        $sendManagerServer->sendMessage($sendData);
                    } catch (\Exception $e) {
                        $sendManagerServer->destroySocket();
                        throw $e;
                    }
                }
            }
            return null;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

?>