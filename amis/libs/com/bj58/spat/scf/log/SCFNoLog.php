<?php
namespace com\bj58\spat\scf\log;

class SCFNoLog implements ILog
{
    private static $_instance;

    private function __construct(){

    }

    public static function getInstance() {
        if(!isset(self::$_instance)){
            self::$_instance = new SCFNoLog();
        }
        return self::$_instance;
    }


    public function logErrorMsg($msg) {
    }

    public function logErrorMsgException($e) {
    }

    public function logWarnMsg($msg) {
    }

    public function logWarnMsgException($e) {
    }

    public function logInfoMsg($msg) {
    }

    public function logInfoMsgException($e) {
    }
}

?>