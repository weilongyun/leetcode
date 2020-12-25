<?php

namespace Libs\Log;

/**
 *
 * @example :
 *         
 *          <?php
 *         
 *          $GLOBALS['LOG'] = array(
 *          'intLevel' => 0x07, //fatal, warning, notice
 *          'strLogFile' => '/home/space/space/log/test.log', //test.log.wf will be the wf log file,test.log.bi will be the bi log file
 *          'boolAutoRotate' => true,
 *          'strRotateFormat'=> 'YmdH'
 *          'arrSelfLogFiles' => array(
 *          'acstat' => '/home/space/space/log/acstat.sdf.log',
 *          'bhstat' => '/home/space/space/log/bhstat.sdf.log',
 *          ),
 *          );
 *         
 *          $str = 'biaji';
 *          LevelLogWriter::notice($str);
 *          LevelLogWriter::fatal($str);
 *          LevelLogWriter::warning($str);
 *          LevelLogWriter::debug($str);
 *          LevelLogWriter::bilog($str);
 *          LevelLogWriter::selfLog('acstat', $str);
 *          LevelLogWriter::selfLog('bhstat', $str);
 *         
 *         
 *         
 */
class LevelLogWriter extends LogWriter {

    const LOG_LEVEL_NONE = 0x00;
    const LOG_LEVEL_FATAL = 0x01;
    const LOG_LEVEL_WARNING = 0x02;
    const LOG_LEVEL_NOTICE = 0x04;
    const LOG_LEVEL_TRACE = 0x08;
    const LOG_LEVEL_DEBUG = 0x10;
    const LOG_LEVEL_ALL = 0xFF;

    public static $arrLogLevels = array(
        self::LOG_LEVEL_NONE => 'NONE',
        self::LOG_LEVEL_FATAL => 'FATAL',
        self::LOG_LEVEL_WARNING => 'WARNING',
        self::LOG_LEVEL_NOTICE => 'NOTICE',
        self::LOG_LEVEL_TRACE => 'TRACE',
        self::LOG_LEVEL_DEBUG => 'DEBUG',
        self::LOG_LEVEL_ALL => 'ALL'
    );
    protected $intLevel;
    protected $strLogFile;
    protected $arrSelfLogFiles;
    protected $intLogId;
    protected $intStartTime;
    protected $boolAutoRotate = true;
    protected $strRotateFormat = 'YmdH';
    protected $arrNoticeLogData = array();
    private static $instance = null;

    public function __construct($arrLogConfig = null, $intStartTime = null) {
        if (!$arrLogConfig) {
            $arrLogConfig = $GLOBALS ['LOG'];
        }
        if (!$intStartTime) {
            $intStartTime = defined('PROCESS_START_TIME') ? PROCESS_START_TIME : microtime(true) * 1000;
        }
        $this->init($arrLogConfig, $intStartTime);
    }

    private function init($arrLogConfig, $intStartTime) {
        $this->intLevel = intval($arrLogConfig ['intLevel']);
        $this->strLogFile = $arrLogConfig ['strLogFile'];
        $this->arrSelfLogFiles = $arrLogConfig ['arrSelfLogFiles'];
        $this->boolAutoRotate = $arrLogConfig ['boolAutoRotate'];
        $this->strRotateFormat = $arrLogConfig ['strRotateFormat'];
        $this->intLogId = self::__logId();
        $this->intStartTime = $intStartTime;
    }

    /**
     *
     * @return LevelLogWriter
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self ();
        }

        return self::$instance;
    }

    /**
     * Write raw string to log file
     *
     * @param string $str        	
     * @return int Return log string length if success, or null if failed
     */
    public static function rawlog($str) {
        $log = self::getInstance();
        return $log->writeRawLog($str);
    }

    /**
     * Write self defined log
     *
     * @param string $strKey
     *        	of the self defined log file
     * @param string $str
     *        	defined log string
     * @param array $arrArgs
     *        	in k/v format to be write into the log
     */
    public static function selflog($strKey, $str, $arrArgs = null) {
        $log = self::getInstance();
        return $log->writeSelfLog($strKey, $str, $arrArgs);
    }

    /**
     * Write bi log
     *
     * @param string $str
     *        	defined log string
     * @param array $arrArgs
     *        	in k/v format to be write into the log
     */
    public static function bilog($str, $arrArgs = null) {
        $log = self::getInstance();
        return $log->writeBiLog($str, $arrArgs);
    }

    /**
     * Write debug log
     *
     * @param string $str
     *        	defined log string
     * @param int $errno
     *        	to be write into log
     * @param array $arrArgs
     *        	in k/v format to be write into log
     * @param int $depth
     *        	of the function be packaged
     */
    public static function debug($str, $errno = 0, $arrArgs = null, $depth = 0) {
        $log = self::getInstance();
        return $log->writeLog(self::LOG_LEVEL_DEBUG, $str, $errno, $arrArgs, $depth + 1);
    }

    /**
     * Write trace log
     *
     * @param string $str
     *        	defined log string
     * @param int $errno
     *        	to be write into log
     * @param array $arrArgs
     *        	in k/v format to be write into log
     * @param int $depth
     *        	of the function be packaged
     */
    public static function trace($str, $errno = 0, $arrArgs = null, $depth = 0) {
        $log = self::getInstance();
        return $log->writeLog(self::LOG_LEVEL_TRACE, $str, $errno, $arrArgs, $depth + 1);
    }

    public static function notice($str, $errno = 0, $arrArgs = null, $depth = 0) {
        $log = self::getInstance();
        $arrArgs = array_merge($arrArgs, $log->arrNoticeLogData);
        return $log->writeLog(self::LOG_LEVEL_NOTICE, $str, $errno, $arrArgs, $depth + 1);
    }

    public static function pushNotice($key, $val) {
        $log = self::getInstance();
        $log->arrNoticeLogData [$key] = $val;
    }

    /**
     * Write warning log
     *
     * @param string $str
     *        	defined log string
     * @param int $errno
     *        	to be write into log
     * @param array $arrArgs
     *        	in k/v format to be write into log
     * @param int $depth
     *        	of the function be packaged
     */
    public static function warning($str, $errno = 0, $arrArgs = null, $depth = 0) {
        $log = self::getInstance();
        return $log->writeLog(self::LOG_LEVEL_WARNING, $str, $errno, $arrArgs, $depth + 1);
    }

    /**
     * Write fatal log
     *
     * @param string $str
     *        	defined log string
     * @param int $errno
     *        	to be write into log
     * @param array $arrArgs
     *        	in k/v format to be write into log
     * @param int $depth
     *        	of the function be packaged
     */
    public static function fatal($str, $errno = 0, $arrArgs = null, $depth = 0) {
        $log = self::getInstance();
        return $log->writeLog(self::LOG_LEVEL_FATAL, $str, $errno, $arrArgs, $depth + 1);
    }

    /**
     * Get logid for current http request
     *
     * @return int
     */
    public static function logId() {
        return self::getInstance()->intLogId;
    }

    /**
     * Get the real remote client's IP
     *
     * @return string
     */
    public static function getClientIP() {
        if (isset($_SERVER ['HTTP_X_FORWARDED_FOR']) && $_SERVER ['HTTP_X_FORWARDED_FOR'] != '127.0.0.1') {
            $ips = explode(',', $_SERVER ['HTTP_X_FORWARDED_FOR']);
            $ip = $ips [0];
        } elseif (isset($_SERVER ['HTTP_X_REAL_IP'])) {
            $ip = $_SERVER ['HTTP_X_REAL_IP'];
        } elseif (isset($_SERVER ['HTTP_CLIENTIP'])) {
            $ip = $_SERVER ['HTTP_CLIENTIP'];
        } elseif (isset($_SERVER ['REMOTE_ADDR'])) {
            $ip = $_SERVER ['REMOTE_ADDR'];
        } else {
            $ip = '127.0.0.1';
        }

        $pos = strpos($ip, ',');
        if ($pos > 0) {
            $ip = substr($ip, 0, $pos);
        }

        return trim($ip);
    }

    public function writeLog($intLevel, $str, $errno = 0, $arrArgs = null, $depth = 0) {
        if ($intLevel > $this->intLevel || !isset(self::$arrLogLevels [$intLevel])) {
            return;
        }

        $strLevel = self::$arrLogLevels [$intLevel];

        $strLogFile = $this->strLogFile;
        if (($intLevel & self::LOG_LEVEL_WARNING) || ($intLevel & self::LOG_LEVEL_FATAL)) {
            $strLogFile .= '.wf';
        }

        if ($this->boolAutoRotate && $this->strRotateFormat) {
            $strLogFile = $strLogFile . '.' . date($this->strRotateFormat, time());
        }

        $trace = debug_backtrace();
        if ($depth >= count($trace)) {
            $depth = count($trace) - 1;
        }
        $file = basename($trace [$depth] ['file']);
        $line = $trace [$depth] ['line'];

        $strArgs = '';
        if (is_array($arrArgs) && count($arrArgs) > 0) {
            foreach ($arrArgs as $key => $value) {
                $strArgs .= $key . "[$value] ";
            }
        }

        $intTimeUsed = microtime(true) * 1000 - $this->intStartTime * 1000;

        $str = sprintf("%s: [time:%s] [%s:%d] errno[%d] cip[%s] sip[%s] logid[%u] uri[%s] time_used[%d] %s%s\n", $strLevel, date('y-m-d H:i:s', time()), $file, $line, $errno, self::getClientIP(), $_SERVER ['SERVER_ADDR'], $this->intLogId, isset($_SERVER ['REQUEST_URI']) ? $_SERVER ['REQUEST_URI'] : '', $intTimeUsed, $strArgs, $str);

        $this->collect($strLogFile, $str);
        return file_put_contents($strLogFile, $str, FILE_APPEND);
    }

    public function writeSelfLog($strKey, $str, $arrArgs = null) {
        if (isset($this->arrSelfLogFiles [$strKey])) {
            $strLogFile = $this->arrSelfLogFiles [$strKey];
        } else {
            $strLogFile = dirname($this->strLogFile) . '/' . $strKey . '.log';
        }

        if ($this->boolAutoRotate && $this->strRotateFormat) {
            $strLogFile = $strLogFile . '.' . date($this->strRotateFormat, time());
        }

        $strArgs = '';
        if (is_array($arrArgs) && count($arrArgs) > 0) {
            foreach ($arrArgs as $key => $value) {
                $strArgs .= $key . "[$value] ";
            }
        }

        $str = sprintf("%s: [time:%s] cip[%s] sip[%s] logid[%u] uri[%s] %s%s\n", $strKey, date('y-m-d H:i:s', time()), self::getClientIP(), $_SERVER ['SERVER_ADDR'], $this->intLogId, isset($_SERVER ['REQUEST_URI']) ? $_SERVER ['REQUEST_URI'] : '', $strArgs, $str);

        $this->collect($strLogFile, $str);
        return file_put_contents($strLogFile, $str, FILE_APPEND);
    }

    public function write($mark, $str) {
        return $this->writeSelfLog($mark, $str);
    }

    public function writeBiLog($str, $arrArgs = null) {
        $strLogFile = $this->strLogFile . '.bi';

        $strArgs = '';
        if (is_array($arrArgs) && count($arrArgs) > 0) {
            foreach ($arrArgs as $key => $value) {
                $strArgs .= $key . "[$value] ";
            }
        }

        $str = sprintf("BILOG: %s ip[%s] logid[%u] uri[%s] %s%s\n", date('m-d H:i:s:', time()), self::getClientIP(), $this->intLogId, isset($_SERVER ['REQUEST_URI']) ? $_SERVER ['REQUEST_URI'] : '', $strArgs, $str);

        $this->collect($strLogFile, $str);
        return file_put_contents($strLogFile, $str, FILE_APPEND);
    }

    public function writeRawLog($str) {
        $strLogFile = $this->strLogFile;

        $this->collect($strLogFile, $str);
        return file_put_contents($strLogFile, $str . "\n", FILE_APPEND);
    }

    private static function __logId() {
        if (defined('LOG_ID')) {
            return LOG_ID;
        }

        if (getenv('HTTP_LOGID') && intval(trim(getenv('HTTP_LOGID'))) !== 0) {
            define('LOG_ID', trim(getenv('HTTP_LOGID')));
        } elseif (isset($_REQUEST ['logid']) && intval($_REQUEST ['logid']) !== 0) {
            define('LOG_ID', intval($_REQUEST ['logid']));
        } else {
            $arr = gettimeofday();
            $logId = ((($arr ['sec'] * 100000 + $arr ['usec'] / 10) & 0x7FFFFFFF) | 0x80000000);
            define('LOG_ID', $logId);
        }
        return LOG_ID;
    }

    private static function collect($file, $str) {
        if (!\Frame\ConfigFilter::instance()->getConfig('scribe') || !defined('LOG_COLLECT') || !LOG_COLLECT) {
            return false;
        }

        $collector = new ScribeLogCollector ();

        $mark = pathinfo($file, PATHINFO_FILENAME);
        $mark = substr($mark, 0, strpos($file, '.'));
        $str = trim($str);

        try {
            $collector->sendLog($mark, $str);
        } catch (\Exception $e) {
            $strLogFile = dirname(self::getInstance()->strLogFile) . '/logcollect.log.wf' . '.' . date(self::getInstance()->strRotateFormat, time());
            $str = sprintf("COLLECT_ERR: %s ip[%s] logid[%u] uri[%s] %s ||| %s ||| %s\n", date('m-d H:i:s:', time()), self::getClientIP(), self::logId(), isset($_SERVER ['REQUEST_URI']) ? $_SERVER ['REQUEST_URI'] : '', $str, $mark, $e->getMessage());
            @file_put_contents($strLogFile, $str, FILE_APPEND);
        }
    }

}