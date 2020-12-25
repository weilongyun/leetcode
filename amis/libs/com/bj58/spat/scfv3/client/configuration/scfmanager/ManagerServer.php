<?php
namespace com\bj58\spat\scf\client\configuration\scfmanager;

class ManagerServer
{
    private $managerSocket;
    private $managerServerConfig;
    private $isConnected = false;

    public function __construct($managerServerConfig)
    {
        $this->managerServerConfig = $managerServerConfig;
        $this->managerSocket = new ManagerSocket($managerServerConfig);
    }

    public function isConnected()
    {
        if (null !== $this->managerSocket && $this->managerSocket->isOpen()) {
            return true;
        }
        return false;
    }

    public function connect()
    {
        if ($this->managerSocket !== null) {
            $this->managerSocket->open();
        }
    }

    public function sendMessage($sendData)
    {
        try {
            $recevice = $this->managerSocket->request($sendData);
            return $recevice;
        } catch (\Exception $e) {
            self::destroySocket();
            throw $e;
        }
        return null;
    }

    public function destroySocket()
    {
        if (null !== $this->managerSocket) {
            try {
                $this->managerSocket->close();
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }

    public function getSocket()
    {
        return $this->managerSocket;
    }

    public function getManagerServerConfig()
    {
        return $this->managerServerConfig;
    }
}

?>