<?php
namespace wcacheclient\config;

/**
 *
 * @author 58
 *        
 */
class ServerConfigEntity
{

    private $hostName;

    private $ip;

    private $port;

    private $aliases;

    private $configPollInterval;

    public function __construct($hostName, $ip, $port, $configPollInterval, $aliases = "")
    {
        $this->hostName = $hostName;
        $this->ip = $ip;
        $this->port = $port;
        $this->aliases = $aliases;
        $this->configPollInterval = $configPollInterval;
    }

    /**
     *
     * @return the $hostName
     */
    public function getHostName()
    {
        return $this->hostName;
    }

    /**
     *
     * @param field_type $hostName            
     */
    public function setHostName($hostName)
    {
        $this->hostName = $hostName;
    }

    /**
     *
     * @return the $ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     *
     * @return the $port
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     *
     * @return the $aliases
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     *
     * @param field_type $ip            
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     *
     * @param field_type $port            
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     *
     * @param field_type $aliases            
     */
    public function setAliases($aliases)
    {
        $this->aliases = $aliases;
    }

    /**
     *
     * @return the $configPollInterval
     */
    public function getConfigPollInterval()
    {
        return $this->configPollInterval;
    }

    /**
     *
     * @param field_type $configPollInterval            
     */
    public function setConfigPollInterval($configPollInterval)
    {
        $this->configPollInterval = $configPollInterval;
    }

    public function __toString()
    {
        return "ServerConfigEntity,hostName:" . $this->hostName . ",ip:" . $this->ip . ",port:" . $this->port . ",aliases:" . $this->aliases . ",configPollInterval:" . $this->configPollInterval;
    }

    public function transferApcuCacheInfo()
    {
        return $this->hostName . " " . $this->ip . " " . $this->port . " " . $this->aliases . " " . $this->configPollInterval;
    }
}