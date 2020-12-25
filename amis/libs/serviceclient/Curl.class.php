<?php

namespace Libs\Serviceclient;


/**
 * 端口开启，请求，返回，关闭
 * @author
 */
class Curl extends CurlBase {
    
    const DefaultTimeOut = 2;  //默认接口超时时间
    const DefaultTimOutConn = 1; //默认连接时间 
    
    private static $instance = NULL;
    private $file = "singlecurl";

    public static function instance() {
        is_null(self::$instance) && self::$instance = new self();
        return self::$instance;
    }

    private $useragent = 'PHP Frame Connect';
    private $curlHandle = NULL;

    public function open() {
        $this->curlHandle = curl_init();
        curl_setopt($this->curlHandle, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->curlHandle, CURLOPT_HEADER, FALSE);
        curl_setopt($this->curlHandle, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->curlHandle, CURLOPT_NOSIGNAL, 1);

        // 设置referer
        if(isset($_SERVER['SERVER_NAME']) && isset($_SERVER['REQUEST_URI'])) {
            $referer = $_SERVER['SERVER_NAME'] . str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
            curl_setopt($this->curlHandle, CURLOPT_REFERER, $referer);
        }
    }

    private function getHeaders($headers = array()) {
        $global_headers = RemoteHeaderCreator::getHeaders();
        
        $headerArr = array('PHP-FRAME:' . $global_headers['PHP-FRAME']);
        if (!empty($global_headers['X-REF'])) {
            $headerArr[] = 'XREF:' . $global_headers['X-REF'];
        }
        
        //transfer the logid http header between rpc
        if($logid = \Libs\Log\LevelLogWriter::logId()){
        	$headerArr [] = 'LOGID:' . $logid;
        }

        foreach ($headers as $key => $value) {
            $headerArr[] = $key . ": " . $value;
        }

        return $headerArr;
    }

    public function send($request) {
        if (is_string($request->params)) {
            $params = $request->params;
        } else {
            $params = http_build_query($request->params);
        }

        $url = $request->url;
        $method = $request->method;
        $method = empty($method) ? 'GET' : $method;
        switch ($method) {
            case 'POST':
                curl_setopt($this->curlHandle, CURLOPT_POST, TRUE);
                curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $params);
                break;
            case 'GET':
                curl_setopt($this->curlHandle, CURLOPT_HTTPGET, TRUE);
                $url .= '?' . $params;
                break;
        }

        curl_setopt($this->curlHandle, CURLOPT_URL, $url);
        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, $this->getHeaders($request->headers));

        $this->setopt($request);
    }

    public function setopt($request) {
        $options = $request->opt;

        if (empty($options['timeout'])) {
            $options['timeout'] = self::DefaultTimeOut;   
        }
        if (!empty($options['timeout_ms'])) {
            unset($options['timeout']);
        }
        
        if (empty($options['connect_timeout'])) {
            $options['connect_timeout'] = self::DefaultTimOutConn;   
        }
        if (!empty($options['connect_timeout_ms'])) {
            unset($options['connect_timeout']);
        }
        
        foreach ($options as $type => $value) {
            switch ($type) {
                case 'timeout':
                    curl_setopt($this->curlHandle, CURLOPT_TIMEOUT, $value);
                    break;
                case 'connect_timeout':
                    curl_setopt($this->curlHandle, CURLOPT_CONNECTTIMEOUT, $value);
                    break;
                case 'timeout_ms':
                    curl_setopt($this->curlHandle, CURLOPT_TIMEOUT_MS, $value);
                    break;
                case 'connect_timeout_ms':
                    curl_setopt($this->curlHandle, CURLOPT_CONNECTTIMEOUT_MS, $value);
                    break;
            }
        }
    }

    public function exec() {
        $response = curl_exec($this->curlHandle);
        parent::wlog($this->curlHandle, $this->file);
        $res = array();
        $res['content'] = json_decode($response, TRUE);
        $res['httpcode'] = curl_getinfo($this->curlHandle, CURLINFO_HTTP_CODE);
        $res['exec_ret'] = $response;
        return $res;
    }

    public function close() {
        curl_close($this->curlHandle);
        $this->curlHandle = NULL;
    }
}
