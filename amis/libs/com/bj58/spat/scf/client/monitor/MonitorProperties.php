<?php
namespace com\bj58\spat\scf\client\monitor;

use com\bj58\spat\scf\exception\ScfException;
class MonitorProperties
{
    private static $_INSTANCE;

    private $monitorFilePath = null;
    private $monitor_props = array();
    private $inApcu = false;

    public static function INSTANCE()
    {
        if(self::$_INSTANCE === null) {
            self::$_INSTANCE = new self();
        }
        return self::$_INSTANCE;
    }

    private function __construct()
    {
    }

    private static function getProperty($key)
    {
        try {
            if (apcu_exists('scf_monitor_props')) {
                $GLOBALS['scf_monitor_props'] = apcu_fetch('scf_monitor_props');
            } else {
                $monitorFilePath = getcwd() . '/scfclient.properties';
                if (@file_exists($monitorFilePath)) {
                    $handle = fopen($monitorFilePath, 'r');
                    $prop = array();
                    while(!feof($handle)) {
                        $temp = fgets($handle);
                        $kv = explode('=', $temp);
                        if (count($kv) === 2) {
                            $prop[$kv[0]] = $kv[1];
                        } else {
                            fclose($handle);
                            throw new ScfException('path: '. $monitorFilePath . ' is error!');
                        }
                    }
                    fclose($handle);
                    $GLOBALS['scf_monitor_props'] = $prop;
                } else {
                    $GLOBALS['scf_monitor_props']['addrs'] = '10.252.148.75';
                    $GLOBALS['scf_monitor_props']['port'] = '30000';
                }
                apcu_add('scf_monitor_props', $GLOBALS['scf_monitor_props']);
            }
            return $GLOBALS['scf_monitor_props'][$key];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function getManagerIps()
    {
        $addrs = self::getProperty('addrs');
        $addrs = explode(',', $addrs);
        return $addrs;
    }

    public static function getManagerPort()
    {
        return self::getProperty('port');
    }
}

?>