<?php
namespace com\bj58\spat\scf\client\configuration\scfmanager;

use com\bj58\spat\scf\exception\ScfException;

class ManagerProperties
{
    private static $_INSTANCE;

    private $managerFilePath = null;
    private $manager_props = array();
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
            if (apcu_exists('scf_manager_props')) {
                $GLOBALS['scf_manager_props'] = apcu_fetch('scf_manager_props');
            } else {
                $managerFilePath = getcwd() . '/scfclient.properties';
                if (@file_exists($managerFilePath)) {
                    $handle = fopen($managerFilePath, 'r');
                    $prop = array();
                    while(!feof($handle)) {
                        $temp = fgets($handle);
                        $kv = explode('=', $temp);
                        if (count($kv) === 2) {
                            $prop[$kv[0]] = $kv[1];
                        } else {
                            fclose($handle);
                            throw new ScfException('path: '. $managerFilePath . ' is error!');
                        }
                    }
                    fclose($handle);
                    $GLOBALS['scf_manager_props'] = $prop;
                } else {
                    $GLOBALS['scf_manager_props']['addrs'] = 'controler1.srvmgr.service.58dns.org,controler2.srvmgr.service.58dns.org,controler3.srvmgr.service.58dns.org,controler4.srvmgr.service.58dns.org';
                    $GLOBALS['scf_manager_props']['port'] = '27080';
                }
                apcu_add('scf_manager_props', $GLOBALS['scf_manager_props']);
            }
            return $GLOBALS['scf_manager_props'][$key];
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