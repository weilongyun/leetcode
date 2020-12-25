<?php
namespace wcacheclient\util;
use wcacheclient\exception\WcacheException;
class ConnAddrUtil 
{
    /**
     * ping address
     * @param type $address
     * @return boolean
     */
    public static function pingAddress($addr)
    {
        $status = - 1;
        if (strcasecmp(PHP_OS, 'WINNT') === 0) {
            // Windows 
            $pingresult = exec("ping -n 1 -W 1 {$addr}", $outcome, $status);
        } elseif (strcasecmp(PHP_OS, 'Linux') === 0) {
            // Linux 
            $pingresult = exec("ping -c 1 -W 1 {$addr}", $outcome, $status);
        }
        if (0 == $status) {
            $status = true;
        } else {
            $status = false;
        }
        return $status;
    }
    
    /**
     * get host by ip .
     * @param unknown $addr
     * @return string
     */
    public static function getHostByIp($ipAddress)
    {
        return gethostbyaddr($ipAddress);
    }
    
    /**
     * get ips by address .
     * @param unknown $addr
     */
    public static function getIps($addr)
    {
        $ips = array();
        $ips = gethostbynamel($addr);
        if (false == $ips) {
            throw new WcacheException("get ips from configaccess failed.");
        }
        return $ips;
    }
    
}

