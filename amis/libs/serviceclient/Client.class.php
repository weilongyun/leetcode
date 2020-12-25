<?php
namespace Libs\Serviceclient;
/**
 * 处理请求的client
 * @author zx 
 */

class Client {
    /*
     * service 服务标识，比如virus、doota 
     * apiName 接口名
     * params 接口需要的参数
     * opt, array('timeout' => 1) 可选配置， 比如method、timeout等
     * headers, array('Content-Type' => 'multipart/form-data') 可选配置
     */
    public function call($service, $apiName, $params, $opt = array(), $headers = array()) {
        $callback = 'solo';
        $request = Request::createRequest();
        $request->setApi($service, $apiName);
        $request->setParam($params);
        $request->setHeaders($headers);
        $request->setOptions($opt);
        $response = Transport::exec(array($callback => $request), $opt);
        return $response[$callback];
    }
}
