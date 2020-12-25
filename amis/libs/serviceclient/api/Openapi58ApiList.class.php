<?php

namespace Libs\Serviceclient\Api;

class Openapi58ApiList {

    private static $apiList = array(
        
    );

    public static function get($server, $api) {
        $apiInfo = array('service' => 'openapi58', 'method' => 'POST');
        if (isset(static::$apiList[$api])) {
            $apiInfo = static::$apiList[$api];
        }
        return $apiInfo;
    }

}
