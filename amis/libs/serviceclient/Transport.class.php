<?php
namespace Libs\Serviceclient;

class Transport {

    public static function exec($requestList = array(), $globalOpt = array()) {
        if(empty($requestList))
            return array();
        foreach ($requestList as $request) {
            $request->setAdditionOpt($globalOpt);
        }

        if (count($requestList) > 1) {
            $responseList = self::MultiCurlExec($requestList);
        } else {
            $responseList = self::curlExec($requestList); 
        }

        return $responseList;
    }

    private static function MultiCurlExec($requestList) {
        if (empty($requestList)) {
            return array();
        }

        MultiCurl::instance()->open();
        MultiCurl::instance()->send($requestList);
        $responseList = MultiCurl::instance()->exec();
        MultiCurl::instance()->close();

        return $responseList;       
    }

    private static function curlExec($requestList) {
        $responseList = array();
        foreach ($requestList as $key => $request) {
            Curl::instance()->open();
            Curl::instance()->send($request);
            $responseList[$key] = Curl::instance()->exec();
            Curl::instance()->close();
        }
        return $responseList;
    }
}

