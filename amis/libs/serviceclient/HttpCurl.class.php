<?php
namespace Libs\Serviceclient;

class HttpCurl {
    var $userAgent = "58 house";
    var $cookie = false;
    var $proxy = "";
    var $ch = NULL;
    var $url = '';

    /**
     * 将头文件的信息作为数据流输出
     * @var boolean
     */
    var $haveHeader = TRUE;

    /**
     * 會將服務器服務器返回的「Location:」放在header中遞歸的返回給服務器
     * @var boolean
     */
    var $followLocation = TRUE;

    /**
     * 強制獲取一個新的連接，替代緩存中的連接。
     * @var boolean
     */
    var $freshConnect = TRUE;

    /**
     * header中「Accept-Encoding: 」部分的內容，支持的編碼格式為："identity"，"deflate"，"gzip"。如果設置為空字符串，則表示支持所有的編碼格式
     * @var string
     */
    var $encodingMethod = 'gzip';

    /**
     * time out
     * @var int
     */
    var $timeOut = 1;

    var $timeOutMs = 500;

    var $addHeader = array();
    
    var $retry = 1;

    function __construct() {
        $this->initialize();
    }

    /**
     * 初始化，来开启一个curl
     * @param NULL
     * @return TRUE
     */
    private function initialize() {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);

        return TRUE;
    }

    /**
     * 一坨opt set
     * @param NULL
     * @return TRUE
     */
    private function setOpt() {
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, $this->followLocation);
        curl_setopt($this->ch, CURLOPT_FRESH_CONNECT, $this->freshConnect);
        curl_setopt($this->ch, CURLOPT_ENCODING, $this->encodingMethod);

        //兼容老的curl版本
        defined('CURLOPT_TIMEOUT') || define('CURLOPT_TIMEOUT', 13);
        defined('CURLOPT_CONNECTTIMEOUT') || define('CURLOPT_CONNECTTIMEOUT', 78);
        defined('CURLOPT_TIMEOUT_MS') || define('CURLOPT_TIMEOUT_MS', 155);
        defined('CURLOPT_CONNECTTIMEOUT_MS') || define('CURLOPT_CONNECTTIMEOUT_MS', 156);

        if ($this->timeOutMs) {
            curl_setopt($this->ch, CURLOPT_NOSIGNAL, 1);
            curl_setopt($this->ch, CURLOPT_TIMEOUT_MS, $this->timeOutMs);
            curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT_MS, $this->timeOutMs);
        } else {
            curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeOut);
        }

        if (!empty($this->addHeader)) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->addHeader);
        }

        return TRUE;
    }

    /**
     * 超时时间(ms)设置
     * @param int
     * @return TRUE
     */
    public function setTimeOut($timeOut = 1) {
        return $this->timeOut = $timeOut;
    }

    public function setTimeOutMs($timeOutMs=200) {
        return $this->timeOutMs = $timeOutMs;
    }

    /**
     * 被ban的时候用代理
     * @param string
     * @return TRUE
     */
    public function setProxy($proxy) {
        curl_setopt($this->ch, CURLOPT_PROXY, $this->proxy);
        return TRUE;
    }

    /*
     * 是否输出头信息
     * */
    public function setNeedHeader($need_header = FALSE) {
        $this->haveHeader = (bool)$need_header;
        return TRUE;
    }

    /**
     * 设置cookie时候用
     * @param string
     * @return TRUE
     * @todo cookie 用file实现
     */
    public function cookie($cookie) {
        curl_setopt($this->ch, CURLOPT_COOKIE, $cookie);
    }

    public function setRetry($retry) {
        $this->retry = $retry;
    } 

    /**
     * to curl
     * @param string
     * @return html
     */
    private function curl($url = '') {
        $this->setOpt();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        //超时重试
        $param = json_encode($this->params_tmp);
        $retry = 1;
        while ($retry <= $this->retry) {
            $html = curl_exec($this->ch);
            $no  = curl_errno($this->ch);
            if ($no === 0) break;
            $retry++;
        }
        curl_close($this->ch);
        return $html;
    }

    /**
     * post method
     * @param string
     * @param array
     * @return array
     */
    public function post($url = '', $params = array()) {
        $this->params_tmp = $params;
        $checkPos = strpos ( $url , "#");
        if ( $checkPos !== false ) {
            $url = substr ( $url , 0 , $checkPos );
        }
        if (trim($url) == '') {
            return TRUE;
        }
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($params));
        return $this->curl($url);
    }

    /**
     * post method
     * @param string
     * @param array
     * @return array
     */
    public function get($url, $referer = '') {
        $checkPos = strpos ( $url , "#");
        if ( $checkPos !== false ) {
            $url = substr ( $url , 0 , $checkPos );
        }
        if (trim($url) == '') {
            return TRUE;
        }
        return $this->curl($url);
    }

    /**
     * post method
     * @param string
     * @param array
     * @return array
     */
    public function setAgent($userAgent) {
        if (!empty($userAgent)) {
            $this->userAgent = $userAgent;
        }
        return TRUE;
    }


    public function addHeader($headers) {
        if (empty($headers)) {
            return TRUE;
        }
        $this->addHeader = $headers;
    }
}