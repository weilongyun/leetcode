<?php

namespace Libs\Serviceclient\Api;

class BaiduApiList {

    private static $apiList = array(
        '/place/v2/search' => array('service' => 'baidu', 'method' => 'GET', 'opt' => array('timeout' => 1)),
    );

    public static function get($server, $api) {
        $apiInfo = array('service' => 'baidu', 'method' => 'GET');
        if (isset(static::$apiList[$api])) {
            $apiInfo = static::$apiList[$api];
        }
        return $apiInfo;
    }
}
