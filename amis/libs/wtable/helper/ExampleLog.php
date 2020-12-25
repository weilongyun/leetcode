<?php
namespace WTable\helper;

class ExampleLog extends ILog
{
    public function __construct($logFile, $logLevel=ILog::ERROR)
    {
        $this->logLevel = $logLevel;
        $this->LogFile = @fopen($logFile, 'a+');
        if (! is_resource($this->LogFile)) {
            throw new WTableException('invalid file Stream . ');
        }
    }

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
