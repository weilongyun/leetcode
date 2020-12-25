<?php
namespace Libs\Util;

/**
 * 功能控制类
 * @author xiangbowu <xiangbowu@meilishuo.com>
 */
class FunctionUtilities {
    
    const CFG_FILE_PATH = '/home/work/conf/func/xxx.cfg.php'; //xxx用来替换key
    
    private static $allCfg = array();

    /*
     * 检查一个业务模块是否开启，默认开启，返回1的话，业务可以屏蔽
     * $service  业务名，决定了配置文件名
     * $module   模块名
     */
    
    public static function Check($service, $module) {
        $cfg = self::GetCfgByServKey($service);
        if (empty($cfg)) {
            return '';
        }        
        return isset($cfg[$module]) ? $cfg[$module] : '';
    } 
    
    public static function Get($service, $module) {
        $cfg = self::GetCfgByServKey($service);
        if (empty($cfg)) {
            return '';
        }        
        return isset($cfg[$module]) ? $cfg[$module] : '';
    }     
    
    private static function GetCfgByServKey($key) {
        if (empty($key)) {
            return array();
        }

        if (!empty(self::$allCfg[$key])) {
            return self::$allCfg[$key];
        }

        $data = self::GetCfgFromFile($key);

        self::$allCfg[$key] = $data;
        return self::$allCfg[$key];
    }
    
    private static function GetCfgFromFile($key) {
        $file = str_replace('xxx', $key, self::CFG_FILE_PATH);

        if (!is_file($file)) {
            return array();
        }

        $config = include $file;
        if (is_array($config)) {
            return $config;
        }        
        return array();
    }
}
