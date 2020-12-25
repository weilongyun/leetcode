<?php
/**
 * PHP log class
 */
namespace wcacheclient\helper;

class Config
{

    public static function getConfig()
    {
        return array(
            'LOG_FILE' => __DIR__ . '/../log/wcacheclient.log',
            'LOG_LEVEL' => 75
        ); // INFO

    }
}

class Log
{

    private $LogFile;

    private $logLevel;

    const DEBUG = 100;

    const INFO = 75;

    const NOTICE = 50;

    const WARNING = 25;

    const ERROR = 10;

    const CRITICAL = 5;

    private function __construct()
    {
        $cfg = Config::getConfig();
        $this->logLevel = isset($cfg['LOG_LEVEL']) ? $cfg['LOG_LEVEL'] : LOG::INFO;
        if (! isset($cfg['LOG_FILE']) && strlen($cfg['LOG_FILE'])) {
            throw new \Exception('can\'t set file to empty');
        }
        $this->LogFile = @fopen($cfg['LOG_FILE'], 'a+');
        if (! is_resource($this->LogFile)) {
            //throw new \Exception('invalid file Stream . '); 别抛异常
            $this->LogFile = NULL;
        }
    }

    public static function getInstance()
    {
        static $obj;
        if (! isset($obj)) {
            $obj = new Log();
        }
        return $obj;
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
        if (is_null($obj->LogFile)) {
            return;
        }  
        $time = @date('[Y-m-d H:i:s]') . ':';
        $msg = str_replace("\t", '', $msg);
        $msg = str_replace("\n", '', $msg);
        
        $strLogLevel = $obj->levelToString($logLevel);
        
        if (isset($module)) {
            $module = str_replace(array(
                "\n",
                "\t"
            ), array(
                "",
                ""
            ), $module);
        }
        $logLine = "$time\t$strLogLevel\t$module\t$msg\r\n";
        fwrite($obj->LogFile, $logLine);
    }

    public function levelToString($logLevel)
    {
        $ret = '[unknow]';
        switch ($logLevel) {
            case LOG::DEBUG:
                $ret = 'LOG::DEBUG';
                break;
            case LOG::INFO:
                $ret = 'LOG::INFO';
                break;
            case LOG::NOTICE:
                $ret = 'LOG::NOTICE';
                break;
            case LOG::WARNING:
                $ret = 'LOG::WARNING';
                break;
            case LOG::ERROR:
                $ret = 'LOG::ERROR';
                break;
            case LOG::CRITICAL:
                $ret = 'LOG::CRITICAL';
                break;
        }
        return $ret;
    }
}

