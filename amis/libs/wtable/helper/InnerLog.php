<?php
/**
 * PHP log class
 */
namespace WTable\helper;

class InnerLog 
{
    const DEBUG = 100;
    const INFO = 75;
    const NOTICE = 50;
    const WARNING = 25;
    const ERROR = 10;
    const CRITICAL = 5;
    private static $obj;

    public static function getInstance()
    {
        if (!isset(self::$obj) || false === (self::$obj instanceof ILog)) {
            self::$obj = new FileLog();
        }
        return self::$obj;
    }
    
    public static function setLog($log) {
        if(!isset($log) ||  false === ($log instanceof ILog)) {
            throw \WTableException("setLog is null or not instanceof ILog!");
        }
        self::$obj = $log;
    }

    /**
     *
     * @param unknown $module
     *            className:line
     * @param unknown $logLevel
     *            info or error end so on
     * @param unknown $msg
     *            log msg
     */
    public static function logMessage($module, $logLevel, $msg)
    {
        $obj = self::getInstance();
        if ($logLevel > $obj->logLevel) {
            return;
        }
        $obj->logMessage($module, $logLevel, $msg);
    }
}
