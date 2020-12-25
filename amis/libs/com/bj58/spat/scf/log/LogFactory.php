<?php
namespace com\bj58\spat\scf\log;

class LogFactory
{
    static private $log;

    static function registerLog($log) {
        self::$log = $log;
        return $log;
    }

    static function getLog() {
        return self::$log;
    }
}

?>