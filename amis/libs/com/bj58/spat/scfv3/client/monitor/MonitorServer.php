<?php
namespace com\bj58\spat\scf\client\monitor;

class MonitorServer
{
    private $monitorSocket;
    private $monitorServerConfig;
    private $isConnected = false;

    public function __construct($monitorServerConfig)
    {
        $this->managerServerConfig = $monitorServerConfig;
        $this->monitorSocket = new MonitorSocket($monitorServerConfig);
    }

    public function isConnected()
    {
        if (null !== $this->monitorSocket && $this->monitorSocket->isOpen()) {
            return true;
        }
        return false;
    }

    public function connect()
    {
        if ($this->monitorSocket !== null) {
            $this->monitorSocket->open();
        }
    }

    public function sendMessage($sendData)
    {
        try {
            $recevice = $this->monitorSocket->request($sendData);
            return $recevice;
        } catch (\Exception $e) {
            self::destroySocket();
            throw $e;
        }
        return null;
    }

    public function destroySocket()
    {
        if (null !== $this->monitorSocket) {
            try {
                $this->monitorSocket->close();
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }

    public function getSocket()
    {
        return $this->monitorSocket;
    }

    public function getManagerServerConfig()
    {
        return $this->managerServerConfig;
    }
}

?>