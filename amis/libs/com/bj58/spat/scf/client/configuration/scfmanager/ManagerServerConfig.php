<?php
namespace com\bj58\spat\scf\client\configuration\scfmanager;

/**
 * @author Administrator
 *
 */
class ManagerServerConfig
{
    private $ip;
    private $port;
//     private $maxPakageSize;
//     private $recvBufferSize;
//     private $sendBufferSize;
//     private $connectTimeOut;

    public function __construct($ip = '', $port = '')
    {
        $this->ip = $ip;
        $this->port = $port;
//         $this->connectTimeOut = 1000 * 2;
//         $this->maxPakageSize = 1024 * 1024 * 2;
//         $this->recvBufferSize = 1024 * 1024 * 2;
//         $this->sendBufferSize = 1024 * 1024 * 2;
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

 /**
     * @param field_type $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

 /**
     * @param field_type $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

}