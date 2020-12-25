<?php

namespace Libs\Util;
use \Libs\Log\ScribeLogCollector;

class Utilities {

    public static function ObjectToArray($object) {
        if (!is_object($object)) return (array)$object;

        $array = array();
        $arr = explode(PHP_EOL, print_r($object, true));
        foreach ($arr as $line) {
            $lineArr = explode(" => ", $line);
            if (count($lineArr) != 2) continue;

            $key = trim(current(explode(":", $lineArr[0])), " [");
            $array[ $key ] = $lineArr[1];
        }
        return $array;
    }

    public static function DataToArray($dbData, $keyword, $allowEmpty = FALSE) {
        if (empty($dbData) || !is_array($dbData)) {
            return array();
        }

        $retArray = array();
        foreach ($dbData as $oneData) {
            if (isset($oneData [$keyword]) and empty($oneData [$keyword]) == false or $allowEmpty) {
                $retArray [] = $oneData [$keyword];
            }
        }
        return $retArray;
    }

    public static function changeDataKeys($data, $keyName, $toLowerCase = false) {
        if (empty($data) || !is_array($data)) {
            return array();
        }

        $resArr = array();
        foreach ($data as $v) {
            $k = $v [$keyName];
            if ($toLowerCase === true) {
                $k = strtolower($k);
            }
            $resArr [$k] = $v;
        }
        return $resArr;
    }
 
    public static function Scf_object_array($array) {
        if (is_object($array)) {    
            $className = get_class($array);
            $classLen = strlen($className)+2;
            $array = (array) $array;
            foreach ($array as $key => $v) {
                $k = substr($key, $classLen);
                if (!empty($k)) {  
                    $array[$k] = $v;
                    unset($array[$key]);
                }
            } 
        } if (is_array($array)) {
            foreach ($array as $key => $value) {
                $key = trim($key);
                $array[$key] = self::Scf_object_array($value);
            }
        }
        return $array;
    }
    
    public static function Class_object_to_array($stdclassobject) {
        $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
        foreach ($_array as $key => $value) {
            $value = (is_array($value) || is_object($value)) ? self::Class_object_to_array($value) : $value;
            $array[$key] = $value;
        }
        return $array;
    }

    public static function sortArray($array, $order_by, $order_type = 'ASC') {
        if (!is_array($array)) {
            return array();
        }
        $order_type = strtoupper($order_type);
        if ($order_type != 'DESC') {
            $order_type = SORT_ASC;
        } else {
            $order_type = SORT_DESC;
        }

        $order_by_array = array();
        foreach ($array as $k => $v) {
            $order_by_array [] = $array [$k] [$order_by];
        }
        array_multisort($order_by_array, $order_type, $array);
        return $array;
    }

    public static function nginx_userid_decode($str) {
        $str_unpacked = unpack('h*', base64_decode(str_replace(' ', '+', $str)));
        $str_split = str_split(current($str_unpacked), 8);
        $str_map = array_map('strrev', $str_split);
        $str_decoded = strtoupper(implode('', $str_map));

        return $str_decoded;
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

        $pos = strpos($ip, ':');
        if ($pos > 0) {
            $ip = substr($ip, 0, $pos);
        }

        return trim($ip);
    }

    /**
     * 获取服务器IP
     * @return string
     */
    public static function getServerIp() {
        static $ip;
        if ($ip) {
            return $ip;
        }
        if (isset($_SERVER['SERVER_ADDR'])) {
            if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
                $ip = $_SERVER['HTTP_X_REAL_IP'];
            } else {
                $ip = $_SERVER['SERVER_ADDR'];
            }
        } else {
            $ip = '';
        }
        return $ip;
    }

    /**
     * 生成唯一票据，使用场景：作为登录态access_token
     * @return string
     */
    public static function getUniqueId() {
        return md5(uniqid(mt_rand(), TRUE) . $_SERVER['REQUEST_TIME'] . mt_rand());
    }
    
    public static function ValidateCallBK($callBack) {
        if (!preg_match("/^[a-zA-Z][0-9a-zA-Z_]*$/", $callBack)) {
            return FALSE;
        }
        return TRUE;
    }
    
    public static function Go2Login($loginUrl, $params=array()) {
        if (empty($loginUrl)) {
            return;
        }
        $app = \Frame\Application::instance();        
        $currentUrl = $app->request->uri;
        if (!empty($currentUrl)) {
            $params['redirect'] = $currentUrl;
        }  
        if (empty($params)) {
            $loginUrl = "{$loginUrl}"; 
        } else {
            $loginUrl = "{$loginUrl}?" . http_build_query($params) ;
        }    
        $app->response->redirect($loginUrl);
        return;
    }

    /*
     * 生成随机字符串
     * @param int    $length 随机字符串位数
     * @param string $prefix 前缀
     * @param string $suffix 后缀
     * return string
     */
    public static function CreateRandStr($length, $prefix = '', $suffix = '') {
        $randStr ='';
        if ( $length > 32 ) {
            $length = 32;
        }
        for ($i = 0; $i < $length; $i++) {
            $randStr .= chr(mt_rand(97, 122));
        }
        return $prefix.$randStr.$suffix;
    }

    /*
     * 生成随机密码：由字母与数字组成，最长32位
     * @param int $length 随机密码位数
     * @return string
     */
    public static function CreateRandPassword($length = 0) {
        $password = substr(md5(time().self::CreateRandStr(6)), 0, $length);
        return $password;
    }

    /*
     * 正则匹配电话、手机号码，400电话号码
     * @param  string $tel
     * @param  string $type
     * @return boolean
     */
    public static function IsTel($tel, $type = '') {
        $regxArr = array(
            'phone' =>  '/^(\+?86-?)?(18|15|13)[0-9]{9}$/',
            'tel'   =>  '/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/',
            '400'   =>  '/^400(-\d{3,4}){2}$/',
        );
        if( $type && isset($regxArr[$type]) ) {
            return preg_match($regxArr[$type], $tel) ? TRUE:FALSE;
        }
        foreach( $regxArr as $regx ) {
            if( preg_match($regx, $tel)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public static function IsDomainRewrite() {
        if (isset($GLOBALS['DOMAIN_REWRITE'])) return $GLOBALS['DOMAIN_REWRITE'];

        //return isset($_SERVER['HTTP_X_FORWARDED_FOR']) || $_SERVER['SERVER_NAME'] != $_SERVER['HTTP_HOST'];
        $pos = stripos($_SERVER['HTTP_HOST'], 'gongyu');
        return isset($_SERVER['HTTP_X_FORWARD_FOR']) || $pos === FALSE;
    }  
    
    public static function MaskPhone($phone) {
        if (empty($phone)) {
            return $phone;
        }
        $phone = (string)$phone;
        $res = substr($phone, 0, 3) . '****' . substr($phone, 7);
        return $res;
    }

    /*
     * 运行日志
     * @param string  日志名字
     * @param array   $logInfo 业务自定义日志信息
     * @param boolean 不在日志中打印参数，如修改密码等操作情况下
     */
    public static function RunLog($logName, $logInfo = array(), $skipPrams = FALSE) {
        //获取Application实例
        $app = \Frame\Application::instance();
        $logStr = "uri:" . $_SERVER['REQUEST_URI'] . "\treferer:" . $_SERVER['HTTP_REFERER'];
        if( !empty($app->request->REQUEST) && !$skipPrams ) {
            $logStr .= "\tparams:" . http_build_query($app->request->REQUEST);
        }
        !empty($logInfo) && $logStr .= "\tlogInfo:" . json_encode($logInfo, JSON_UNESCAPED_UNICODE);
        //线下环境将日志打印到本地
        if( $GLOBALS['IS_DEV_ENV'] ) {
            $app->log->log($logName, $logStr);
        } else { //打印scribe日志
            try {
                $logger = new ScribeLogCollector();
                $currentTime = date("Y-m-d H:i:s", time());
                $logger->sendLog($logName, "[$currentTime]\t" . $logStr);
            } catch (\Exception $e) {
                $app->log->log($logName, $logStr);
            }
        }
    }


    /*
     * 用于去除掉url特定的参数：如图片链接去除w参数，前端则可以自行调整w参数获取不同大小的图片
     * @param  array $removeParams 要去除的特定参数，如为空则去除掉所有参数
     * @author rongxiaolong
     */
    public static function RemoveUrlParams($url, $removeParams = array()) {
        $parserUrlArray = parse_url($url);
        if( empty($parserUrlArray['query']) ) {
            return $url;
        }
        $resultUrl = empty($parserUrlArray['scheme']) ? 'http://' : $parserUrlArray['scheme'].'://';
        $resultUrl .= $parserUrlArray['host'].$parserUrlArray['path'];
        if( !empty($removeParams) && is_array($removeParams) ) {
            $queryParts = explode('&', $parserUrlArray['query']);
            $paramsArray = array();
            foreach ($queryParts as $param) {
                $item = explode('=', $param);
                !in_array($item[0], $removeParams) && $paramsArray[$item[0]] = $item[1];
            }
            $resultUrl .= '?'.http_build_query($paramsArray);
        }
        return $resultUrl;
    }

    /**
     * 根据parse_url格式的数组生成完整的url
     * @param array $url_arr 接受parse_url解析出来的所有参数,完整参数实例如下：
     *        Array
     *        (
     *            [scheme] => http            // 协议
     *            [host] => www.baidu.com     // 主机
     *            [port] => 80                // 端口，可选
     *            [path] => /path/file.php    // 路径(文件名)，可选
     *            [query] => a=aaa&b=aaabbb    // 参数(query string)，可选
     *            [fragment] => 123            // 附加部分或者叫做锚点(#后面的)，可选
     *        )
     */
    public static function http_build_url($url_arr){
        $new_url = $url_arr['scheme'] . "://".$url_arr['host'];
        if(!empty($url_arr['port']))
            $new_url = $new_url.":".$url_arr['port'];
        $new_url = $new_url . $url_arr['path'];
        if(!empty($url_arr['query']))
            $new_url = $new_url . "?" . $url_arr['query'];
        if(!empty($url_arr['fragment']))
            $new_url = $new_url . "#" . $url_arr['fragment'];
        return $new_url;
    }
    
    public static function utf8_urldecode($str) {
        $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
        return html_entity_decode($str,null,'UTF-8');;
    }    
}
