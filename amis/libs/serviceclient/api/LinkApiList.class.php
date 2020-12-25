<?php

namespace Libs\Serviceclient\Api;

class LinkApiList {

    private static $apiList = array(
        '/ulink.aspx' => array('service' => 'link', 'method' => 'GET', 'opt' => array('timeout' => 1)),
    );

    public static function get($server, $api) {
        $apiInfo = array('service' => 'link', 'method' => 'GET');
        if (isset(static::$apiList[$api])) {
            $apiInfo = static::$apiList[$api];
        }
        return $apiInfo;
    }
    
}
