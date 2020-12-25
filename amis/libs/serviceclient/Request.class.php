<?php
namespace Libs\Serviceclient;
/**
 * 一个服务请求
 * @author
 */


class Request {

    private $url = '';
    private $method = 'GET';
    private $params = array();
    private $headers = array();
    private $opt = array();

    public static function createRequest() {
        return new self();
    }

    public function setApi($server, $apiName) {
        $this->url = ServiceApiInfomation::getApiUrl($server, $apiName);
        $this->method = ServiceApiInfomation::getApiMethod($server,$apiName);
        $this->opt = ServiceApiInfomation::getApiOpt($server,$apiName);
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function setParam($params) {
        $this->params = $params;
    }

    public function setHeaders($headers) {
        $this->headers = (array)$headers;
    }

    public function setOptions($opt) {
        if (!is_array($opt)) {
            return ;
        }
        foreach ($opt as $key => $value) {
            $this->setopt($key, $value);
        }
    }

    public function setAdditionOpt($opt) {
        if (!is_array($opt)) {
            return;
        }
        foreach ($opt as $key => $value) {
            if (isset($this->opt[$key])) {
                continue;
            } else {
                $this->setopt($key, $value);
            }
        }
    }

    private function setopt($type, $value) {
        switch ($type) {
            case 'timeout': 
                $this->opt['timeout'] = (int)$value;
                break;
            case 'connect_timeout':
                $this->opt['connect_timeout'] = (int)$value;
                break;
            case 'timeout_ms': 
                $this->opt['timeout_ms'] = (int)$value;
                break;
            case 'connect_timeout_ms':
                $this->opt['connect_timeout_ms'] = (int)$value;
                break;
        } 
    }

    public function __get($type) {
        if (isset($this->$type)) {
           return $this->$type; 
        }
        else {
            return array();
        }
        
    }
}

