<?php

namespace com\bj58\xxzl\keywordreplace\service;

use com\bj58\spat\scf\client\proxy\ProxyStandard;

class IKeyWordService {

    public $ps;

    public function __construct($serviceName = '', $lookup = '', $initObj = '') {
        $ps = new ProxyStandard($serviceName, $lookup, $initObj);
        $this->ps = $ps;
    }

    public function replaceKeyWords($infoidList = '', $cityid = '', $oneTypeid = '', $secondTypeid = '') {
        $value = array(
            '1@List<Long>' => $infoidList,
            '2@int' => $cityid,
            '3@int' => $oneTypeid,
            '4@int' => $secondTypeid,
        );
        $res = $this->ps->invoke('replaceKeyWords', $value);
        return $res;
    }
}