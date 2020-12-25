<?php
namespace com\bj58\spat\scf\log;

class SCFDefaultLog implements ILog
{

    private static $_instance;
    private $LogFile;
    private $logLevel;

    const DEBUG  = 100;
    const INFO   = 75;
    const NOTICE = 50;
    const WARNING =25;
    const ERROR   = 10;
    const CRITICAL = 5;

    private function __construct($logPath, $logLevel){
        $this->logLevel = isset($logLevel) ? $logLevel:SCFDefaultLog::INFO;
        if(!isset($logPath) && strlen($logPath)){
            $logPath = $GLOBALS['SCF_DEFAULT_SCFLOG_PATH'];
        }
        $this->LogFile = @fopen($logPath,'a+');
        if(!is_resource($this->LogFile)){
            throw new \Exception('invalid file Stream . ');
        }

    }

    public static function getInstance($logPath, $loglevel) {
        if(!isset(self::$_instance)){
            self::$_instance = new SCFDefaultLog($logPath, $loglevel);
        }
        return self::$_instance;
    }

    /**
     * @param unknown $module    className:line
     * @param unknown $logLevel  info or error end so on
     * @param unknown $msg       log msg
     */
    public function logMessage($logLevel, $msg, $module = ''){
//         $dlog = self::getInstance($GLOBALS['DEFAULT_SCFLOG_PATH'], $logLevel);
        if($logLevel > $this->logLevel){
            return ;
        }
        $time = @date('[Y-m-d H:i:s]') . ':';
        $msg = str_replace("\t",'',$msg);
        $msg = str_replace("\n",'',$msg);

        $strLogLevel = $this->levelToString($logLevel);

        if(isset($module)){
            $module = str_replace(array("\n","\t"),array("",""),$module);
        }
        $logLine = "$time\t$strLogLevel\t$module\t$msg\r\n";
        fwrite($this->LogFile,$logLine);
    }

    public function levelToString($logLevel){
        $ret = '[unknow]';
        switch ($logLevel){
            case SCFDefaultLog::DEBUG:
                $ret = 'LOG::DEBUG';
                break;
            case SCFDefaultLog::INFO:
                $ret = 'LOG::INFO';
                break;
            case SCFDefaultLog::NOTICE:
                $ret = 'LOG::NOTICE';
                break;
            case SCFDefaultLog::WARNING:
                $ret = 'LOG::WARNING';
                break;
            case SCFDefaultLog::ERROR:
                $ret = 'LOG::ERROR';
                break;
            case SCFDefaultLog::CRITICAL:
                $ret = 'LOG::CRITICAL';
                break;
        }
        return $ret;
    }

 public function logErrorMsg($msg) {
     $this->logMessage(SCFDefaultLog::ERROR, $msg);
 }

 public function logErrorMsgException($e) {
     $module = $e->getFile() . ': ' . $e->getLine();
     $msg = $e->__toString();
     $this->logMessage(SCFDefaultLog::ERROR, $msg, $module);
 }

 public function logWarnMsg($msg) {
     $this->logMessage(SCFDefaultLog::WARNING, $msg);
 }

 public function logWarnMsgException($e) {
     $module = $e->getFile() . ': ' . $e->getLine();
     $msg = $e->__toString();
     $this->logMessage(SCFDefaultLog::WARNING, $msg, $module);
 }

 public function logInfoMsg($msg) {
     $this->logMessage(SCFDefaultLog::INFO, $msg);
 }

 public function logInfoMsgException($e) {
     $module = $e->getFile() . ': ' . $e->getLine();
     $msg = $e->__toString();
     $this->logMessage(SCFDefaultLog::INFO, $msg, $module);
 }

}

?>