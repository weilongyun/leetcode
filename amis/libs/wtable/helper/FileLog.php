<?php
/**
 * PHP log class
 */
namespace WTable\helper;
use WTable\exception\WTableException;
use WTable\exception\WTableError;

class FileLog extends ILog
{
    const WTABLE_DEFAULT_LOG = '../log/wtable.log';
    public function __construct($logFile=FileLog::WTABLE_DEFAULT_LOG, $logLevel=ILog::ERROR)
    {
        $this->logLevel = $logLevel;
        if($logFile == FileLog::WTABLE_DEFAULT_LOG) {
            $logFile = __DIR__."/".$logFile;
        }
        $this->LogFile = @fopen($logFile, 'a+');
        if (! is_resource($this->LogFile)) {
            throw new WTableException('invalid file Stream . ');
        }
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
    public  function logMessage($module, $logLevel, $msg)
    {
        if ($logLevel > $this->logLevel) {
            return;
        }
        $time = @date('[Y-m-d H:i:s]') . ':';
        $msg = str_replace("\t", '', $msg);
        $msg = str_replace("\n", '', $msg);
        
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
        $logLine = "$time\t$strLogLevel\t$module\t$msg\r\n";
        fwrite($this->LogFile, $logLine);
    }

    public function levelToString($logLevel)
    {
        $ret = '[unknow]';
        switch ($logLevel) {
            case FileLog::DEBUG:
                $ret = 'LOG::DEBUG';
                break;
            case FileLog::INFO:
                $ret = 'FileLog::INFO';
                break;
            case FileLog::NOTICE:
                $ret = 'FileLog::NOTICE';
                break;
            case FileLog::WARNING:
                $ret = 'FileLog::WARNING';
                break;
            case FileLog::ERROR:
                $ret = 'FileLog::ERROR';
                break;
            case FileLog::CRITICAL:
                $ret = 'FileLog::CRITICAL';
                break;
        }
        return $ret;
    }
}

