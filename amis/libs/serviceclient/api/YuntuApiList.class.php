<?php

namespace Libs\Serviceclient\Api;

class YuntuApiList {

    private static $apiList = array(
        '/datamanage/data/create' => array('service' => 'yuntu', 'method' => 'POST', 'opt' => array('timeout' => 5)),
        '/datamanage/data/update' => array('service' => 'yuntu', 'method' => 'POST', 'opt' => array('timeout' => 5)),
        '/datamanage/data/delete' => array('service' => 'yuntu', 'method' => 'POST', 'opt' => array('timeout' => 5)),
        '/datamanage/data/list' => array('service' => 'yuntu', 'method' => 'GET', 'opt' => array('timeout' => 5)),

        '/datasearch/local' => array('service' => 'yuntu', 'method' => 'GET', 'opt' => array('timeout' => 5)),
        '/datasearch/around' => array('service' => 'yuntu', 'method' => 'GET', 'opt' => array('timeout' => 5)),
        '/datasearch/polygon' => array('service' => 'yuntu', 'method' => 'GET', 'opt' => array('timeout' => 5)),
        '/datasearch/id' => array('service' => 'yuntu', 'method' => 'GET', 'opt' => array('timeout' => 5)),
    );

    public static function get($server, $api) {
        $apiInfo = array('service' => 'yuntu', 'method' => 'POST');
        if (isset(static::$apiList[$api])) {
            $apiInfo = static::$apiList[$api];
        }
        return $apiInfo;
    }

}
