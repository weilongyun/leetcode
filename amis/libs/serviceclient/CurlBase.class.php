<?php

namespace Libs\Serviceclient;

/*
 * curl基类
 * @package Base
 * @since 2012.12.17
 * @统计超时日志数量的shell例子: for i in `ls -d mutilcurl_* | grep -v "result"`;do grep "2013-12-16" $i/$i\_current | wc -l;echo $i\_current;done
 */
abstract class CurlBase {

    const LOGFILE_NAME = 'serviceclient.log';

    protected $logger;

    /**
     *
     * 构造 CurlBase 设定 Logger
     *
     */
    public function __construct() {
        $log_writer = new \Libs\Log\BasicLogWriter();
        $this->logger = new \Libs\Log\Log($log_writer);
    }

    /**
     * 记录错误日志
     *
     * @return boolean
     * @access private
     * @param $ch curl的句柄, $type是该请求所采用的curl类型
     */
    public function wlog($ch, $type) {
        $curlErrno = curl_errno($ch);
        $curlError = curl_error($ch);
        $info = curl_getinfo($ch);
        $url = $info['url'];
        $code = $info['http_code'];
        if ($code == 200) {  //200的时候不记录日志
            return;
        }  

        $time = $_SERVER['REQUEST_TIME'];
        $fromIp = $_SERVER['SERVER_ADDR'];
        $logid = $_SERVER['HTTP_X_LOGID'];

        $uri = 'http://' . $_SERVER['HTTP_HOST'] . (empty($_SERVER['REQUEST_URI']) ? '' : $_SERVER['REQUEST_URI']);
        $encodedErrMsg = urlencode($curlError);
        $str = "[time:{$time}][logid:{$logid}][ip:{$fromIp}][req:{$url}][url:{$uri}][errno:{$curlErrno}][errmsg:{$encodedErrMsg}][code:{$code}]";
        $extra = http_build_query($info);
        $ctimeStr = sprintf('%.2f', $info['connect_time'] * 1000);
        $wtimeStr = sprintf('%.2f', ($info['pretransfer_time'] - $info['connect_time']) * 1000);
        $rtimeStr = sprintf('%.2f', ($info['total_time'] - $info['pretransfer_time']) * 1000);
        $ttimeStr = sprintf('%.2f', $info['total_time'] * 1000);
        $str .= "[ctime:{$ctimeStr}][wtime:{$wtimeStr}][rtime:{$rtimeStr}][ttime:{$ttimeStr}][extra:{$extra}]";
        $this->logger->log(self::LOGFILE_NAME, $str);

        return TRUE;
    }
}
