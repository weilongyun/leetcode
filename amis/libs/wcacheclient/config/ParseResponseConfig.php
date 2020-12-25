<?php
namespace wcacheclient\config;
use wcacheclient\util\ConnAddrUtil;
use wcacheclient\config\ServerConfigEntity;
use wcacheclient\exception\WcacheException;

class ParseResponseConfig
{

    public static $HOST_CONFIG_DELIMITER = '|';
    
    private $pollInterval;

    /**
     * Parse response from getConfig for cluster type.
     * version number
     * hostname1|ipaddress1|port hostname2|ipaddress2|port
     * poll intervals
     * returns the ClusterConfiguration object which contains the parsed results.
     * 
     * @param unknown $configurationResponse            
     * @throws Exception 
     */
    public  function parseClusterTypeConfiguration($configurationResponse)
    {
        if ($configurationResponse === NULL) {
            throw new WcacheException("Null configuration");
        }
        if (strcmp($configurationResponse, "") === 0) {
            throw new WcacheException("No configuration in the response: $configurationResponse");
        }
        $lines = preg_split('/(?:\\r?\\n)/', trim($configurationResponse));
        if ($lines === NULL || count($lines) != 3) {
            throw new WcacheException("Incorrect response format. Response: $configurationResponse");
        }
        $version = trim($lines[0]);
        if (strcmp($version, "") === 0) {
            throw new WcacheException("Version number is missing. Response: $configurationResponse");
        }
        if (is_long($version)) {
            throw new WcacheException("Version number is not long. Response: $configurationResponse");
        }
        
        $hostList = trim($lines[1]);
        $pollIntervalStr = $lines[2];
        
        if (strcmp($pollIntervalStr, "") === 0) {
            throw new WcacheException("Config poll interval is missing. Response: $configurationResponse");
        }
        
        if (strcmp($hostList, "") === 0) {
            throw new WcacheException("Empty host list in the response: $configurationResponse");
        }
        
        $servers = array();
        
        foreach (preg_split('/(?:\\s)+/', $hostList) as $hostDetails) {
            if (strcmp($hostDetails, "") === 0) {
                continue;
            }
            $firstDelimiter = stripos($hostDetails, self::$HOST_CONFIG_DELIMITER);
            $lastDelimiter = strripos($hostDetails, self::$HOST_CONFIG_DELIMITER);
            if ($firstDelimiter === $lastDelimiter) {
                throw new WcacheException("Invalid server $hostDetails in response:  $configurationResponse");
            }
            $secondDelimiter = strpos($hostDetails, self::$HOST_CONFIG_DELIMITER, $firstDelimiter + 1);
            if ($secondDelimiter === $lastDelimiter) {
                $hostName = trim(substr($hostDetails, 0, $firstDelimiter));
                $ipAddress = trim(substr($hostDetails, $firstDelimiter + 1, $lastDelimiter - $firstDelimiter - 1));
                $port = trim(substr($hostDetails, $lastDelimiter + 1));
                if (strcasecmp($hostName, "") === 0 && strcasecmp($ipAddress, "") != 0) {
                    $hostName = ConnAddrUtil::getHostByIp($ipAddress);
                }
                $this->pollInterval = $pollIntervalStr;
                $serverConfigEntity = new ServerConfigEntity($hostName, $ipAddress, $port, $pollIntervalStr);
                $servers[] = $serverConfigEntity->transferApcuCacheInfo();
            } else 
                if ($secondDelimiter < $lastDelimiter) {
                    $hostName = trim(substr($hostDetails, 0, $firstDelimiter));
                    $ipAddress = trim(substr($hostDetails, $firstDelimiter + 1, $secondDelimiter - $firstDelimiter - 1));
                    $port = trim(substr($hostDetails, $secondDelimiter + 1, $lastDelimiter - $secondDelimiter - 1));
                    $aliases = trim(substr($hostDetails, $lastDelimiter + 1));
                    
                    if (strcasecmp($hostName, "") === 0 && strcasecmp($ipAddress, "") != 0) {
                        $hostName = ConnAddrUtil::getHostByIp($ipAddress);
                    }
                    $this->pollInterval = $pollIntervalStr;
                    $serverConfigEntity = new ServerConfigEntity($hostName, $ipAddress, $port, $pollIntervalStr, $aliases);
                    $servers[] = $serverConfigEntity->transferApcuCacheInfo();
                }
            
            if (count($servers) === 0) {
                throw new \Exception("No servers found");
            }
        }
        return $servers;
    }
    /**
     * @return the $pollInterval
     */
    public function getPollInterval()
    {
        return $this->pollInterval;
    }

    /**
     * @param field_type $pollInterval
     */
    public function setPollInterval($pollInterval)
    {
        $this->pollInterval = $pollInterval;
    }
    
}