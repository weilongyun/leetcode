<?php
namespace Libs\Log;

use Libs\Log\BasicLogWriter;
use Libs\Wmonitor\WMonitorRBI;
/*
 * 推送错误日志统一类WMonitorRBI
 * 例如：Gongyu\Packages\Base\ExceptionLog::Log($ex);
 */

class ExceptionLog {
    const LOG_NAME = 'exception_log';

    private static function write($logfile, $message) {
        static $scribeLogger = null;
        static $basicLogger = null;
        if (is_null($scribeLogger)) {
            $scribeLogger = new ScribeLogCollector();
            $basicLogger = new BasicLogWriter();
        }

        try{
            $currentTime = date("Y-m-d H:i:s", time());
            $scribeLogger->sendLog($logfile, "[$currentTime]\t" . $message);
        } catch (\Exception $e) {
            $basicLogger->write($logfile, $message);
        }
    }

    public static function Log($ex, $catalog = self::LOG_NAME) {
        if (!is_object($ex)) {
            return;
        }  
        $exType = get_class($ex);
        $exType = strtolower($exType);
        $uri = self::GetUri();
        $line = '';
        $func = '';
        $class = '';
        $trace = debug_backtrace();
        if (isset($trace[2])) {
            $class = $trace[2]['class'];
            $class = strtolower($class);

            $func = $trace[2]['function'];
            $line = $trace[2]['line'];
            if (isset($trace[1]) && !empty($trace[1]['line'])) {
                $line = $trace[1]['line'];
            }
        }

        $id58 = isset($_COOKIE['id58']) ? $_COOKIE['id58'] : '';
        $errorStr = $ex->getMessage();
        $code = $ex->getCode(); 
        $trace = $ex->getTraceAsString();

        $logStr = "[58id:{$id58}]\t[uri:{$uri}]\t[class:{$class}]\t[func:{$func}]\t[line:{$line}]\t[type:{$exType}]\t[msg:{$errorStr}]\t[code:{$code}]\t[trace:{$trace}]";
        self::write($catalog, $logStr);
    }

    public static function GetUri() {
        $sapi_type = php_sapi_name();
        if ($sapi_type == 'cli') {
            $args = $_SERVER['argv'];
            if (empty($args)) {
                return '';
            }
            if (stripos($args[0], 'script.php') !== FALSE) {
                $args[0] = '';
            }
            $uri = implode(' ', $args);
            $uri = trim($uri);
            return $uri;
        }

        $uri = empty($_SERVER['REQUEST_URI']) ? '' : $_SERVER['REQUEST_URI'];
        $pos = stripos($uri,'?');
        if ($pos > 0) {
            $uri = substr($uri, 0, $pos);
        }
        return $uri;
    }
}
