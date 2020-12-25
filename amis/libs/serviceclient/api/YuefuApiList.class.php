<?php

namespace Libs\Serviceclient\Api;

class YuefuApiList {

    private static $apiList = array(
        '/rs/thirdcall/getHouseDetail' => array('service' => 'yuefu', 'method' => 'POST', 'opt' => array('timeout' => 2)),
    );

    public static function get($server, $api) {
        $apiInfo = array('service' => 'yuefu', 'method' => 'POST');
        if (isset(static::$apiList[$api])) {
            $apiInfo = static::$apiList[$api];
        }
        return $apiInfo;
    }
}
