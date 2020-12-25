<?php
/**
 * @file MLog.php
 * @brief class for logging
 * @author CHEN Yijie(yijiechen@meilishuo.com)
 *  
 **/
namespace Libs\Log;
use Libs\Log\mlog\conf\MLogConfig;


require_once(dirname(__FILE__) . '/mlog/conf/log.conf.php');

/*********************************************
 * format string，取自lighttpd文档
 * 前面标记 - 代表MLog库不支持
 * 行为不一致的，均有注释说明
 * 后面的 === 之后的，是MLog扩展的功能
  ====== ================================
  Option Description
  ====== ================================
  %%     a percent sign
  %h     name or address of remote-host
  -%l     ident name (not supported)
  -%u     authenticated user
  %t     timestamp of the end-time of the request //param, show current time, param specifies strftime format
  -%r     request-line 
  -%s     status code 
  -%b     bytes sent for the body
  %i     HTTP-header field //param
  %a     remote address
  %A     local address
  -%B     same as %b
  %C     cookie field (not supported) //param
  %D     time used in ms
  %e     environment variable //param
  %f     physical filename
  %H     request protocol (HTTP/1.0, ...)
  %m     request method (GET, POST, ...)
  -%n     (not supported)
  -%o     `response header`_
  %p     server port
  -%P     (not supported)
  %q     query string
  %T     time used in seconds //support param, s, ms, us, default to s
  %U     request URL
  %v     server-name
  %V     HTTP request host name
  -%X     connection status
  -%I     bytes incomming
  -%O     bytes outgoing
  ====== ================================
  %L     Log level
  %N     line number
  %E     err_no
  %l     log_id
  -%u     user
  %S     strArray, support param, takes a key and removes the key from %S
  %M     error message
  %x     extension, supports various param, like log_level, line_number etc.

  currently supported param for %x:
  log_level, line, class, function, err_no, err_msg, log_id, app, function_param, argv, encoded_str_array

  in %x, prepend u_ to key to urlencode before its value
*************************************************/
class MLog
{
    const LOG_LEVEL_FATAL   = 0x01;
    const LOG_LEVEL_WARNING = 0x02;
    const LOG_LEVEL_NOTICE  = 0x04;
    const LOG_LEVEL_TRACE   = 0x08;
    const LOG_LEVEL_DEBUG   = 0x10;

    const DEFAULT_DEBUG_BACKTRACE_DEPTH = 5;

    public static $arrLogLevels = array(
        self::LOG_LEVEL_FATAL   => 'FATAL',
        self::LOG_LEVEL_WARNING => 'WARNING',
        self::LOG_LEVEL_NOTICE  => 'NOTICE',
        self::LOG_LEVEL_TRACE   => 'TRACE',
        self::LOG_LEVEL_DEBUG   => 'DEBUG',
    );

    public $app = null;
    protected $intLevel;
    protected $strLogFile;
    protected $bolAutoRotate;
    protected $pushKey = array();

    private static $arrInstance = array();

    private static $lastLogs    = array();
    private static $lastLogSize = 0;

    const DEFAULT_FORMAT = '%L: %{%y-%m-%d %H:%M:%S}t %{app}x * %{pid}x [local_ip=%a logid=%l filename=%f lineno=%N uri=%U errno=%{err_no}x %{encoded_str_array}x] %{err_msg}x';

    private function __construct($arrLogConfig) {
        $this->app = $arrLogConfig['app'];
        $this->intLevel         = $arrLogConfig['level'];
        $this->bolAutoRotate    = $arrLogConfig['auto_rotate'];
        $this->strLogFile       = $arrLogConfig['log_file'];
        $this->strFormat        = $arrLogConfig['format']; 
        $this->strFormatWF      = $arrLogConfig['format_wf'];
        $this->strFormatFATAL   = $arrLogConfig['format_fatal'];
    }

    /**
     * @brief 获取最近使用的app
     * @return  public static function
    **/
    private function getApp() {
        if (!empty($this->app)) {
            return $this->app;
        } else {
            return 'default';
        }
    }

    /**
     * @brief 获取log对象
     * @return MLog
     * */
    public static function getLogger($app = null) {
        if (empty($app)) {
            $app = 'default';
        }

        if (empty(self::$arrInstance[$app])) {
            // 生成路径
            $logPath = MLogConfig::$log_path;
            if (MLogConfig::$use_sub_dir == "1") {
                if (!is_dir($logPath."/$app")) {
                    @mkdir($logPath."/$app", 0777, true);
                }
                $log_file = $logPath."/$app/$app.log";
            } else {
                $log_file = $logPath."/$app.log";
            }

            //get log format
            if (isset(MLogConfig::$format)) {
                $format = MLogConfig::$format;
            } else {
                $format = self::DEFAULT_FORMAT;
            }

            if (isset(MLogConfig::$format_wf)) {
                $format_wf = MLogConfig::$format_wf;
            } else {
                $format_wf = $format;
            }

            if (isset(MLogConfig::$format_fatal)) {
                $format_fatal = MLogConfig::$format_fatal;
            } else {
                $format_fatal = $format;
            }

            $log_conf = array(
                'app' => $app,
                'level'         => intval(MLogConfig::$level),
                'auto_rotate'   => (MLogConfig::$auto_rotate == '1'),
                'log_file'      => $log_file,
                'format'        => $format,
                'format_wf'     => $format_wf,
                'format_fatal'  => $format_fatal
            );

            self::$arrInstance[$app] = new MLog($log_conf);
        }

        return self::$arrInstance[$app];
    }

    public function debug($str, $errno = 0, $arrArgs = null, $depth = 0) {
        $ret = $this->writeLog(self::LOG_LEVEL_DEBUG, $str, $errno, $arrArgs, $depth + 1);
        return $ret;
    }

    public function trace($str, $errno = 0, $arrArgs = null, $depth = 0) {
        $ret = $this->writeLog(self::LOG_LEVEL_TRACE, $str, $errno, $arrArgs, $depth + 1);
        return $ret;
    }

    public function notice($str, $errno = 0, $arrArgs = null, $depth = 0) {
        $ret = $this->writeLog(self::LOG_LEVEL_NOTICE, $str, $errno, $arrArgs, $depth + 1);
        return $ret;
    }

    public function warning($str, $errno = 0, $arrArgs = null, $depth = 0) {
        $ret = $this->writeLog(self::LOG_LEVEL_WARNING, $str, $errno, $arrArgs, $depth + 1);
        return $ret;
    }

    public function fatal($str, $errno = 0, $arrArgs = null, $depth = 0) {
        $ret = $this->writeLog(self::LOG_LEVEL_FATAL, $str, $errno, $arrArgs, $depth + 1);
        return $ret;
    }

    public function pushKey($key, $value) {

        if (!isset($value)) {
            $value = $key;
            $key = '@';
        }

        $info = is_array($value) ? strtr(strtr(var_export($value, true), 
        array("  array (\n"=>'{', "array (\n"=>'{', ' => '=> ':',",\n"=> ',',)), 
        array('{  '=> '{', ":\n{"=>':{', '  ),  ' => '},', '),' => '},', ',)'=>'}', ',  '=>',',))
        : $value;
        $this->pushKey[$key] = $info;
    }

    // 生成logid
    public function genLogID() {
        if (defined('LOG_ID')) {
            return LOG_ID;
        }

        if (getenv('HTTP_X_MLS_LOGID') && intval(trim(getenv('HTTP_X_MLS_LOGID'))) !== 0) {
            define('LOG_ID', trim(getenv('HTTP_X_MLS_LOGID')));
        } else {
            $arr = gettimeofday();
            $logId = ((($arr['sec']*100000 + $arr['usec']/10) & 0x7FFFFFFF) | 0x80000000);
            define('LOG_ID', $logId);
        }
        return LOG_ID;
    }

    // 获取客户端ip
    public function getClientIp() {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            return getenv('HTTP_X_FORWARDED_FOR');
        }
        if (getenv('HTTP_CLIENT_IP')) {
            return getenv('HTTP_CLIENT_IP');
        }

        return getenv('REMOTE_ADDR');
    }

    private function writeLog($intLevel, $str, $errno = 0, $arrArgs = null, $depth = 0, $filename_suffix = '', $log_format = null) {
        if ($intLevel > $this->intLevel || !isset(self::$arrLogLevels[$intLevel])) {
            return;
        }
        //log file name
        $strLogFile = $this->strLogFile;
        if (($intLevel & self::LOG_LEVEL_WARNING) || ($intLevel & self::LOG_LEVEL_FATAL)) {
            $strLogFile .= '.wf';
        }

        $strLogFile .= $filename_suffix;

        $this->setPropertiesForFormat($intLevel, $str, $errno, $arrArgs, $depth);

        //get the format
        if ($log_format == null) {
            $format = $this->getFormat($intLevel);
        } else {
            $format = $log_format;
        }
        $str = $this->getLogString($format);

        $orignLogFile = $strLogFile;
        if ($this->bolAutoRotate) {
            $strLogFile .= '.'.date('YmdH');
        }

        if (self::$lastLogSize > 0) {
            self::$lastLogs[] = $str;
            if (count(self::$lastLogs) > self::$lastLogSize) {
                array_shift(self::$lastLogs);
            }
        }

        if (!file_exists($strLogFile)) {
            $result = file_put_contents($strLogFile, $str, FILE_APPEND);
            if(is_link($orignLogFile)){
                unlink($orignLogFile);
            }
            symlink($strLogFile, $orignLogFile);
            return $result;
        } else {
            return file_put_contents($strLogFile, $str, FILE_APPEND);
        }
    }
  // added support for self define format
    private function getFormat($level) {
        if ($level == self::LOG_LEVEL_WARNING) {
            $fmtstr = $this->strFormatWF;
        } else if ($level == self::LOG_LEVEL_FATAL) {
            $fmtstr = $this->strFormatFATAL;
        } else {
            $fmtstr = $this->strFormat;
        }
        return $fmtstr;
    }

    private function setPropertiesForFormat($intLevel, $str, $errno, $arrArgs, $depth) {
        //need refactor begin
        //assign data required
        $this->current_log_level = self::$arrLogLevels[$intLevel];

        //build array for use as strargs
        $_arr_args = false;
        $_add_notice = false;
        if (is_array($arrArgs) && count($arrArgs) > 0) {
            $_arr_args = true;
        }
        if (!empty($this->pushKey)) {
            $_add_notice = true;
        }

        if ($_arr_args && $_add_notice) { //both are defined, merge
            $this->current_args = $arrArgs + $this->pushKey;
        } else if (!$_arr_args && $_add_notice) { //only add notice
            $this->current_args = $this->pushKey;
        } else if ($_arr_args && !$_add_notice) { //only arr args
            $this->current_args = $arrArgs;
        } else { //empty
            $this->current_args = array();
        }

        $this->current_err_no = $errno;
        $this->current_err_msg = $str;
        $trace = debug_backtrace();

        $depth2 = $depth + 1;

        
        if ($depth >= count($trace)) {
            $depth = count($trace) - 1;
            $depth2 = $depth;
        }

        $this->current_file = isset( $trace[$depth]['file'] ) 
                              ? $trace[$depth]['file'] : "" ;
        $this->current_line = isset( $trace[$depth]['line'] ) 
                              ? $trace[$depth]['line'] : "";
        $this->current_function = isset( $trace[$depth2]['function'] ) 
                                  ? $trace[$depth2]['function'] : "";
        $this->current_class = isset( $trace[$depth2]['class'] ) 
                               ? $trace[$depth2]['class'] : "" ; 
        $this->current_function_param = isset( $trace[$depth2]['args'] ) 
                                        ? $trace[$depth2]['args'] : "";
        //need refactor end
    }

    private function getLogString($format) {
        $md5val = md5($format);
        $func = "_dlog_$md5val";
        if (function_exists($func)) {
            return $func($this);
        }
        $dataPath = MLogConfig::$data_path;
        $filename = $dataPath . '/log/'.$md5val.'.php';
        if (!file_exists($filename)) {
            $tmp_filename = $filename . '.' . posix_getpid() . '.' . rand();
            if (!is_dir($dataPath . '/log')) {
                @mkdir($dataPath . '/log', 0777, true);
            }
            file_put_contents($tmp_filename, $this->parseFormat($format));
            rename($tmp_filename, $filename);
        }
        include_once($filename);
        $str = $func($this);

        return $str;
    }

    // parse format and generate code
    private function parseFormat($format) {
        $matches = array();
        $regex = '/%(?:{([^}]*)})?(.)/';
        preg_match_all($regex, $format, $matches);
        $prelim = array();
        $action = array();
        $prelim_done = array();
        
        $len = count($matches[0]);
        for ($i = 0; $i < $len; $i++) {
            $code = $matches[2][$i];
            $param = $matches[1][$i];
            switch($code) {
            case 'h':
                $action[] = "(defined('CLIENT_IP')? CLIENT_IP :" . ' $log->getClientIp())';
                break;
            case 't':
                $action[] = ($param == '')? "strftime('%y-%m-%d %H:%M:%S')" : "strftime(" . var_export($param, true) . ")";
                break;
            case 'i':
                $key = 'HTTP_' . str_replace('-', '_', strtoupper($param));
                $key = var_export($key, true);
                $action[] = "(isset(\$_SERVER[$key])? \$_SERVER[$key] : '')";
                break;
            case 'a':
                $action[] = "(defined('CLIENT_IP')? CLIENT_IP " . ': $log->getClientIp())';
                break;
            case 'A':
                $action[] = "(isset(\$_SERVER['SERVER_ADDR'])? \$_SERVER['SERVER_ADDR'] : '')";
                break;
            case 'C':
                if ($param == '') {
                    $action[] = "(isset(\$_SERVER['HTTP_COOKIE'])? \$_SERVER['HTTP_COOKIE'] : '')";
                } else {
                    $param = var_export($param, true);
                    $action[] = "(isset(\$_COOKIE[$param])? \$_COOKIE[$param] : '')";
                }
                break;
            case 'D':
                $action[] = "(defined('REQUEST_TIME_US')? (microtime(true) * 1000 - REQUEST_TIME_US/1000) : '')";
                break;
            case 'e':
                $param = var_export($param, true);
                $action[] = "((getenv($param) !== false)? getenv($param) : '')";
                break;
            case 'f':
                $action[] = '$log->current_file';
                break;
            case 'H':
                $action[] = "(isset(\$_SERVER['SERVER_PROTOCOL'])? \$_SERVER['SERVER_PROTOCOL'] : '')";
                break;
            case 'm':
                $action[] = "(isset(\$_SERVER['REQUEST_METHOD'])? \$_SERVER['REQUEST_METHOD'] : '')";
                break;
            case 'p':
                $action[] = "(isset(\$_SERVER['SERVER_PORT'])? \$_SERVER['SERVER_PORT'] : '')";
                break;
            case 'q':
                $action[] = "(isset(\$_SERVER['QUERY_STRING'])? \$_SERVER['QUERY_STRING'] : '')";
                break;
            case 'T':
                switch($param) {
                case 'ms':
                    $action[] = "(defined('REQUEST_TIME_US')? (microtime(true) * 1000 - REQUEST_TIME_US/1000) : '')";
                    break;
                case 'us':
                    $action[] = "(defined('REQUEST_TIME_US')? (microtime(true) * 1000000 - REQUEST_TIME_US) : '')";
                    break;
                default:
                    $action[] = "(defined('REQUEST_TIME_US')? (microtime(true) - REQUEST_TIME_US/1000000) : '')";
                }
                break;
            case 'U':
                $action[] = "(isset(\$_SERVER['REQUEST_URI'])? \$_SERVER['REQUEST_URI'] : '')";
                break;
            case 'v':
                $action[] = "(isset(\$_SERVER['HOSTNAME'])? \$_SERVER['HOSTNAME'] : '')";
                break;
            case 'V':
                $action[] = "(isset(\$_SERVER['HTTP_HOST'])? \$_SERVER['HTTP_HOST'] : '')";
                break;

            case 'L':
                $action[] = '$log->current_log_level';
                break;
            case 'N':
                $action[] = '$log->current_line';
                break;
            case 'E':
                $action[] = '$log->current_err_no';
                break;
            case 'l':
                $action[] = '$log->genLogID()';
                break;
            case 'u':
                if (!isset($prelim_done['user'])) {
                    //TODO support get user info from cookie, now just 0
                    $prelim[] = '$____user____ = array("uid"=>0,"uname"=>"");';
                    $prelim_done['user'] = true;
                }
                $action[] = "((defined('CLIENT_IP') ? CLIENT_IP: \$log->getClientIp()) . ' ' . \$____user____['uid'] . ' ' . \$____user____['uname'])";
                break;
            case 'S':
                if ($param == '') {
                    $action[] = '$log->getStrArgs()';
                } else {
                    $param_name = var_export($param, true);
                    if (!isset($prelim_done['S_'.$param_name])) {
                        $prelim[] = 
                            "if (isset(\$log->current_args[$param_name])) {
                            \$____curargs____[$param_name] = \$log->current_args[$param_name];
                            unset(\$log->current_args[$param_name]);
                        } else \$____curargs____[$param_name] = '';";
                        $prelim_done['S_'.$param_name] = true;
                    }
                    $action[] = "\$____curargs____[$param_name]";
                }
                break;
            case 'M':
                $action[] = '$log->current_err_msg';
                break;
            case 'x':
                $need_urlencode = false;
                if (substr($param, 0, 2) == 'u_') {
                    $need_urlencode = true;
                    $param = substr($param, 2);
                }
                switch($param) {
                case 'log_level':
                case 'line':
                case 'class':
                case 'function':
                case 'err_no':
                case 'err_msg':
                    $action[] = '$log->current_'.$param;
                    break;
                case 'log_id':
                    $action[] = 'log->genLogID()';
                    break;
                case 'app':
                    $action[] = '$log->app';
                    break;
                case 'function_param':
                    $action[] = '$log->flattenArgs($log->current_function_param)';
                    break;
                case 'argv':
                    $action[] = '(isset($GLOBALS["argv"])? $log->flattenArgs($GLOBALS["argv"]) : \'\')';
                    break;
                case 'pid':
                    $action[] = 'posix_getpid()';
                    break;
                case 'encoded_str_array':
                    $action[] = '$log->getStrArgsStd()';
                    break;
                case 'cookie':
                    $action[] = "(isset(\$_SERVER['HTTP_COOKIE'])? \$_SERVER['HTTP_COOKIE'] : '')";
                    break;
                case 'backtrace':
                    $action[] = '$log->getBackTrace()';
                    break;
                default:
                    $action[] = "''";
                }
                if ($need_urlencode) {
                    $action_len = count($action);
                    $action[$action_len-1] = 'rawurlencode(' . $action[$action_len-1] . ')';
                }
                break;
            case '%':
                $action[] =  "'%'";
                break;
            default:
                $action[] = "''";
            }
        }

        $strformat = preg_split($regex, $format);
        $code = var_export($strformat[0], true);
        for ($i = 1; $i < count($strformat); $i++) {
            $code = $code . ' . ' . $action[$i-1] . ' . ' . var_export($strformat[$i], true);
        }
        $code .=  ' . "\n"';
        $pre = implode("\n", $prelim);

        $cmt = "Used for app " . $this->getApp() . "\n";
        $cmt .= "Original format string: " . str_replace('*/', '* /', $format);

        $md5val = md5($format);
        $func = "_dlog_$md5val";
        $str = "<?php \n/*\n$cmt\n*/\n" ."use \\". __NAMESPACE__ ."\MLog as MLog;\n" ."function $func(MLog \$log) {\n$pre\nreturn $code;\n}";
        return $str;
    }

    //helper functions for use in generated code
    public static function flattenArgs($args) {
        if (!is_array($args)) {
            return '';
        }
        $str = array();
        foreach ($args as $a) {
            $str[] = preg_replace('/[ \n\t]+/', " ", $a);
        }
        return implode(', ', $str);
    }

    public function getStrArgs() {
        $strArgs = '';
        foreach ($this->current_args as $k=>&$v) {
            if (is_array($v) || is_object($v)) {
                $v = serialize($v);
            }
            $strArgs .= ' '.$k.'['.$v.']';
        }
        return $strArgs;
    }

    public function getStrArgsStd() {
        $args = array();
        foreach ($this->current_args as $k=>&$v) {
            if (is_array($v) || is_object($v)) {
                $v = serialize($v);
            }
            $args[] = rawurlencode($k).'='.rawurlencode($v);
        }
        return implode(' ', $args);
    }
    
    public function getBackTrace() {
        $backtrace = debug_backtrace();
        for ($i = 0; $i < 5; $i++) {
            array_shift($backtrace);
        }
        $backtraceArr = array();
        foreach ($backtrace as $k => $v) {
           if ($k > self::DEFAULT_DEBUG_BACKTRACE_DEPTH) {
               break;
           }
           $arr = array(
                'function' => $v['function'],
                'line' => $v['line'],
                'file' => $v['file'],
                'class' => $v['class']
           );
           $backtraceArr [] = $arr;
           //$str .= ' args => ' . $v['args'];
        }
        $str = 'backtrace' . json_encode($backtraceArr, JSON_UNESCAPED_SLASHES);
        return $str;
    }
}
