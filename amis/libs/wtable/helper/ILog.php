<?php
/**
 * PHP log class
 */
namespace WTable\helper;

abstract class ILog
{
    public $LogFile;

    public $logLevel;

    const DEBUG = 100;

    const INFO = 75;

    const NOTICE = 50;

    const WARNING = 25;

    const ERROR = 10;

    const CRITICAL = 5;

    abstract public  function logMessage($module, $logLevel, $msg);
  
}

