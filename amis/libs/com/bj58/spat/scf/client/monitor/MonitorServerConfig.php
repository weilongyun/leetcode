<?php
namespace com\bj58\spat\scf\client\monitor;

class MonitorServerConfig
{
    private $ip;
    private $port;
    private $sendTimeout;
    private $recvTimeout;

    public function __construct($ip = '', $port = '', $sendTimeout = 3000, $recvTimeout = 3000)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->sendTimeout = $sendTimeout;
        $this->recvTimeout = $recvTimeout;
    }
    /**
     * @return the $ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return the $port
     */
    public function getPort()
    {
        return $this->port;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function getSendTimeout()
    {
        return $this->sendTimeout;
    }

    public function setSendTimeout($sendTimeout)
    {
        $this->sendTimeout = $sendTimeout;
        return $this;
    }

    public function getRecvTimeout()
    {
        return $this->recvTimeout;
    }

    public function setRecvTimeout($recvTimeout)
    {
        $this->recvTimeout = $recvTimeout;
        return $this;
    }
}

?>