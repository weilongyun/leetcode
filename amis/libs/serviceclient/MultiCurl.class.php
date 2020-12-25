<?php

namespace Libs\Serviceclient;


/**
 * 端口开启，请求，返回，关闭
 * @author
 */
class MultiCurl extends CurlBase {

    const DefaultTimeOut = 2;  //默认接口超时时间
    const DefaultTimOutConn = 1; //默认连接时间   

    private static $instance = NULL;
    private $file = "mutilcurl";

    public static function instance() {
        is_null(self::$instance) && self::$instance = new self();
        return self::$instance;
    }

    private $requestMap = array();
    private $useragent = 'PHP Frame Connect';
    private $headers = array();
    private $curlMultiHandle = NULL;

    public function open() {
        $this->curlMultiHandle = curl_multi_init();
        $this->headers = $this->getHeaders();
    }

    public function send($requests) {
        if (!is_array($requests) || empty($requests)) {
            return NULL;
        }
        foreach ($requests as $key => $request) {
            $curlHandle = $this->initSingleCutl();
            $curlHandle = $this->setOpt($curlHandle, $request);
            $curlHandle = $this->setUrl($curlHandle, $request);
            curl_multi_add_handle($this->curlMultiHandle, $curlHandle);
            $this->requestMap[(string) $curlHandle] = $key;
        }
    }

    private function initSingleCutl() {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curlHandle, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curlHandle, CURLOPT_HEADER, FALSE);
        curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curlHandle, CURLOPT_NOSIGNAL, 1);

        // 设置referer
        if(isset($_SERVER['SERVER_NAME']) && isset($_SERVER['REQUEST_URI'])) {
            $referer = $_SERVER['SERVER_NAME'] . str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
            curl_setopt($curlHandle,CURLOPT_REFERER,$referer);
        }
        return $curlHandle;
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

    private function setOpt($curlHandle, $request) {
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
                    curl_setopt($curlHandle, CURLOPT_TIMEOUT, $value);
                    break;
                case 'connect_timeout':
                    curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, $value);
                    break;
                case 'timeout_ms':
                    curl_setopt($curlHandle, CURLOPT_TIMEOUT_MS, $value);
                    break;
                case 'connect_timeout_ms':
                    curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT_MS, $value);
                    break;
            }
        }
        return $curlHandle;
    }

    private function setUrl($curlHandle, $request) {
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
                curl_setopt($curlHandle, CURLOPT_POST, TRUE);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $params);
                break;
            case 'GET':
                curl_setopt($curlHandle, CURLOPT_HTTPGET, TRUE);
                $url .= '?' . $params;
                break;
        }

        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $this->getHeaders($request->headers));

        return $curlHandle;
    }

    public function exec() {
        $active = null;
        $responses = array();
        do {
            do {
                $status = curl_multi_exec($this->curlMultiHandle, $active);
            } while ($status == CURLM_CALL_MULTI_PERFORM);
            if ($status != CURLM_OK) {
                break;
            }
            while ($respond = curl_multi_info_read($this->curlMultiHandle)) {
                $response = curl_multi_getcontent($respond['handle']);

                $responses[$this->requestMap[(string) $respond['handle']]] = array(
                    'content' => json_decode($response, TRUE),
                    'httpcode' => curl_getinfo($respond['handle'], CURLINFO_HTTP_CODE),
                    'exec_ret' => $response,
                );

                parent::wlog($respond['handle'], $this->file);

                curl_multi_remove_handle($this->curlMultiHandle, $respond['handle']);
                curl_close($respond['handle']);
            }
            if ($active > 0) {
                curl_multi_select($this->curlMultiHandle, 0.05);
            }
        } while ($active);
        return $responses;
    }

    public function close() {
        curl_multi_close($this->curlMultiHandle);
        $this->curlMultiHandle = NULL;
        $this->requestMap = array();
        $this->headers = array();
    }
}
