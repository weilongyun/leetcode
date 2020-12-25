<?php

/* 
 * 用来统计一个接口各个地方的调用耗时情况，并打印到日志
 * @author xiangbowu
 */

namespace Libs\Util;

use Libs\Log\ScribeLogCollector;

class PerformanceHelper {
    private static $uri = '';
    private static $logName = 'performance';
    private static $needHandle = FALSE;
    public static $queue = array();

    private static $line = 0;
    private static $tab = 0;
    private static $levelQueue = array();
    
    /*
     * 初始化，
     * $randMax 抽样随机数
     * $logName 日志名
     * $uri 接口名，默认从URL里取得 
     */
    public static function Initialize($randMax=1, $logName='', $uri='') {
        if (empty($uri)) {
            $uri = $_SERVER['REQUEST_URI'];
            $pos = stripos($uri,'?');
            if (empty($pos)) {
                self::$uri = $uri;
            } else {
                self::$uri = substr($uri, 0,$pos);                
            }               
        } else {
            self::$uri = $uri;
        }
        
        if ($randMax == 1) {
            self::$needHandle = TRUE;            
        } elseif (rand(1, $randMax) == 1) {
            self::$needHandle = TRUE;
        }  
    }
    
    public static function RecordStart($name, $ext='') {
        if (!self::$needHandle) {
            return;
        }  
        $time = microtime(TRUE);
        if (!isset(self::$queue[$name])) {
            self::$queue[$name] =  array();
        }
        self::$queue[$name][] = array('start_time' => $time, 'ext' => $ext);

        self::$levelQueue[self::$line] = array('start_time' => $time, 'name'=>$name, 'ext' => $ext, 'tab'=> self::$tab++);
        self::$line++;
    }
    
    public static function RecordEnd($name) {
        if (!self::$needHandle) {
            return;
        }  
        $time = microtime(TRUE);
        if (empty(self::$queue[$name])) {
            return;
        }
        $index = count(self::$queue[$name]) - 1;
        $lastItem = self::$queue[$name][$index];
        if (isset($lastItem['end_time'])) {
            return;
        }
        self::$queue[$name][$index]['end_time'] = $time;

        self::$tab--;
        foreach (self::$levelQueue as $line => $item) {
            if (empty($item['end_time']) && $item['tab'] == self::$tab) {
                self::$levelQueue[$line]['end_time'] = $time;
                break;
            }
            continue;
        }
    }

    public static function GetLevelLogArr() {
        if (empty(self::$queue)) {
            return '';
        }
        if (!self::$needHandle) {
            return '';
        }

        $arr = array();
        foreach (self::$levelQueue as $item) {
            $delta = intval(($item['end_time'] - $item['start_time']) * 1000);
            $arr[] = implode('', array_fill(0, $item['tab'], "    ")) . $item['name'] . ":" . $delta . ":" . $item['ext'];
        }

        return $arr;
    }

    public static function GetLogStr() {        
        if (empty(self::$queue)) {
            return '';
        }
        if (!self::$needHandle) {
            return '';
        }
        $stepArr = array();
        foreach (self::$queue as $name => $records) {
            if (empty($records)) {
                continue;
            }
            foreach ($records as $item) { 
                $startTime = $item['start_time'];
                $endTime = $item['end_time'];

                if (empty($endTime) || empty($startTime)) {
                    continue;
                }
                $delta = $endTime - $startTime;
                $delta = intval($delta * 1000);
                if ($delta < 0 || $delta == 0) {
                    continue;
                }
                $stepArr[] = "[{$name}:{$delta}:{$item['ext']}]";
            }
        }       
        if (empty($stepArr)) {
            return '';
        }       
        $stepStr = implode("\t", $stepArr);
        return $stepStr;
    }
    
    public static function GetLogArray() { 
        if (!self::$needHandle) {
            return array();
        }          
        if (empty(self::$queue)) {
            return array();
        }       
        $stepArr = array();
        foreach (self::$queue as $name => $records) {
            if (empty($records)) {
                continue;
            }
            foreach ($records as $item) { 
                $startTime = $item['start_time'];
                $endTime = $item['end_time'];
                if (empty($endTime) || empty($startTime)) {
                    continue;
                }
                $delta = $endTime - $startTime;
                $delta = intval($delta * 1000);
                if ($delta < 0 || $delta == 0) {
                    continue;
                }
                $stepArr[] = array('name' => $name, 'time' => $delta, 'ext' => $item['ext']);
            }
        }       
        return $stepArr;
    }    
    
    public static function WriteLog() {
        if (!self::$needHandle) {
            return;
        }

        $logArr = self::GetLevelLogArr();
        if (empty($logArr)) return ;
        $logStr = json_encode($logArr, JSON_UNESCAPED_UNICODE);

        static $logger = null;
        if (is_null($logger)) $logger = new ScribeLogCollector();

        try{
            $currentTime = date("Y-m-d H:i:s", time());
            $logger->sendLog(self::$logName, "[$currentTime]\t" . self::$uri . "\t" . $logStr);
            return ;
        } catch (\Exception $e) {
            // pass
        }

        $logWriter = new \Libs\Log\BasicLogWriter();
        $logObj = new \Libs\Log\Log($logWriter);

        $uri = self::$uri;
        $tmp = "[{$uri}]\t{$logStr}";
        $logObj->log(self::$logName, $tmp);       
    }

    public static function IsOpen() {
        $date = date('md');
        if (isset($_GET['__trace']) && $_GET['__trace'] == $date) {  
            return TRUE;
        }
        return FALSE;
    } 
}

