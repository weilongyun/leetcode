<?php

namespace Libs\Log;

use com\bj58\spat\scf\log\ILog;

class SCFLogHelper implements ILog{

    private static $_instance;

    private $info_logger = null;
    private $warn_logger = null;
    private $error_logger = null;

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
    private function __construct(){
        $app = \Frame\Application::instance();
        $logger = $app->log;

        if ($GLOBALS['SCF_LOG_OPEN']) {
            switch ($GLOBALS['SCF_LOG_LEVEL']) {
                case 'info':
                    $this->error_logger = $this->warn_logger = $this->info_logger = $logger;
                    break;
                case 'warn':
                    $this->error_logger = $this->warn_logger = $logger;
                    break;
                case 'error':
                    $this->error_logger = $logger;
                    break;
            }
        }
    }

    function logErrorMsg($msg){
        if ($this->error_logger) {
            $this->error_logger->log('scf_client_log',$msg);
        }
    }

    function logErrorMsgException($e){
        if ($this->error_logger) {
            $module = $e->getFile() . ': ' . $e->getLine();
            $msg = $e->__toString();
            $this->error_logger->log('scf_client_log',$msg."\t".$module);
        }
    }

    function logWarnMsg($msg) {
        if ($this->warn_logger) {
            $this->warn_logger->log('scf_client_log',$msg);
        }
    }

    function logWarnMsgException($e) {
        if ($this->warn_logger) {
            $module = $e->getFile() . ': ' . $e->getLine();
            $msg = $e->__toString();
            $this->warn_logger->log('scf_client_log',$msg."\t".$module);
        }
    }

    function logInfoMsg($msg){
        if ($this->info_logger) {
            $this->info_logger->log('scf_client_log',$msg);
        }
    }

    function logInfoMsgException($e){
        if ($this->info_logger) {
            $module = $e->getFile() . ': ' . $e->getLine();
            $msg = $e->__toString();
            $this->info_logger->log('scf_client_log',$msg."\t".$module);
        }
    }

}
