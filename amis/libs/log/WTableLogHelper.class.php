<?php

namespace Libs\Log;

use WTable\exception\WTableException;
use WTable\helper\ILog;

class WTableLogHelper extends ILog
{

    private static $_instance;

    private $logger = null;

    public static function getInstance() {
        if(!isset(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /*
     * $GLOBALS['SCF_LOG_OPEN'] : '0,'1';
     * $GLOBALS['SCF_LOG_LEVEL'] : info, warn, error
     */
    private function __construct($logLevel=ILog::ERROR){
        $app = \Frame\Application::instance();
        $logger = $app->log;

        $this->logLevel = $logLevel;
        $this->logger = $logger;
    }

    public function logMessage($module, $logLevel, $msg)
    {
        if ($logLevel > $this->logLevel) {
            return;
        }

        $strLogLevel = $this->levelToString($logLevel);

        if (isset($module)) {
            $module = str_replace(array(
                "\n",
                "\t"
            ), array(
                "",
                ""
            ), $module);
        }
        $logLine = "$strLogLevel\t$module\t$msg\r\n";

        if ($this->logger) {
            $this->logger->log('wtable_client_log',$logLine);
        }
    }

    public function levelToString($logLevel)
    {
        $ret = '[unknow]';
        switch ($logLevel) {
            case ILog::DEBUG:
                $ret = 'DEBUG';
                break;
            case ILog::INFO:
                $ret = 'INFO';
                break;
            case ILog::NOTICE:
                $ret = 'NOTICE';
                break;
            case ILog::WARNING:
                $ret = 'WARNING';
                break;
            case ILog::ERROR:
                $ret = 'ERROR';
                break;
            case ILog::CRITICAL:
                $ret = 'CRITICAL';
                break;
        }
        return $ret;
    }
}
