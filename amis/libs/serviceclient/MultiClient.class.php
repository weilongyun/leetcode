<?php

namespace Libs\Serviceclient;

/**
 * 处理请求的client
 * 
 * @author zx
 */
class MultiClient {
    private $requestList = array();
    private $responseList = array();
    private $globalOpt = array();

    /*
     * service 服务标识，比如virus、doota 
     * apiName 接口名
     * params 接口需要的参数
     * callback 返回数据的标识
     * opt, array('timeout' => 1) 可选配置， 比如method、timeout等
     * headers, array('Content-Type' => 'multipart/form-data',) 可选配置
     */    
    public function call($service, $apiName, $params, $callback, $opt = array(), $headers = array()) {
        $request = Request::createRequest();
        $request->setApi($service, $apiName);
        $request->setParam($params);
        $request->setHeaders($headers);
        $request->setOptions($opt);
        $this->requestList [$callback] = $request;
    }

    public function callRequest(Request $request, $callback) {
        $this->requestList [$callback] = $request;
    }

    public function setGlobalOpt($globalOpt) {
        $this->globalOpt = (array) $globalOpt;
    }

    public function callData() {
        $this->responseList = Transport::exec($this->requestList, $this->globalOpt);
        $this->requestList = array();
        return $this->responseList;
    }
    public function __get($callback) {
        if (isset($this->responseList [$callback])) {
            return $this->responseList [$callback];
        }
        else {
            return '';
        }
    }
    public function formatClientData($callback) {
        $Data = $this->__get($callback);
        if ($Data && $Data ['httpcode'] == 200 && $Data ['content'] ['error_code'] == 0) {
            return $Data ['content'] ['data'];
        } else {
            return false;
        }
    }
}
