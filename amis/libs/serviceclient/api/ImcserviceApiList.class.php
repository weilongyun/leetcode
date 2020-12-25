<?php

namespace Libs\Serviceclient\Api;

class ImcserviceApiList {

    private static $apiList = array(
        '/postservice/send' => array('service' => 'imcservice', 'method' => 'POST', 'opt' => array('timeout' => 5)),
        '/postservice/update' => array('service' => 'imcservice', 'method' => 'POST', 'opt' => array('timeout' => 5)),
        '/delservice/delete' => array('service' => 'imcservice', 'method' => 'POST', 'opt' => array('timeout' => 5)),
    );

    public static function get($server, $api) {
        $apiInfo = array('service' => 'imcservice', 'method' => 'POST');
        if (isset(static::$apiList[$api])) {
            $apiInfo = static::$apiList[$api];
        }
        return $apiInfo;
    }

}
