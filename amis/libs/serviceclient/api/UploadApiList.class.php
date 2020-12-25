<?php

namespace Libs\Serviceclient\Api;

class UploadApiList {

    private static $apiList = array(
        '/' => array('service' => 'upload', 'method' => 'POST', 'opt' => array('timeout' => 100)),
    );

    public static function get($server, $api) {
        $apiInfo = array('service' => 'upload', 'method' => 'POST');
        if (isset(static::$apiList[$api])) {
            $apiInfo = static::$apiList[$api];
        }
        return $apiInfo;
    }

}
