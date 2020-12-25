<?php
namespace com\bj58\spat\scf\client\monitor;

class MonitorServerDispatch
{
    private $monitorServerConfigList;
    private $sendMonitorServer;

    public function __construct($monitorServerConfigList)
    {
        $this->monitorServerConfigList = $monitorServerConfigList;
        self::initMonitorServer();
    }

    public function getMonitorServer()
    {
        if (null === $this->monitorServerConfigList || count($this->monitorServerConfigList) === 0) {
            return null;
        }
        return $this->sendMonitorServer;
    }

    public function initMonitorServer()
    {
        $retryCount = 0;
        while (null === $this->sendMonitorServer || !$this->sendMonitorServer->isConnected())
        {
            if (($retryCount++) >= count($this->monitorServerConfigList)) {
                break;
            }
            try {
                self::startConnect();
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }

    private function startConnect()
    {
        $currentIndex = 0;
        $len = count($this->monitorServerConfigList);
        if ($len === 1) {
            $currentIndex = 0;
        } else {
            $currentIndex = rand(0, $len -1);
        }
        $serConfig = $this->monitorServerConfigList[$currentIndex];
        $this->sendMonitorServer = new MonitorServer($serConfig);
        $this->sendMonitorServer->connect();
    }
}

?>