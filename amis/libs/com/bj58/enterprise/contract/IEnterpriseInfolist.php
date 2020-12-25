<?php

namespace com\bj58\enterprise\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\enterprise\entity\EnterpriseInfolist;

class IEnterpriseInfolist {

    public $ps;

    public function __construct($serviceName = '', $lookup = '') {
        $ps = new ProxyStandard($serviceName, $lookup);
        $this->ps = $ps;
    }

    public function getEnterpriseForInfoList($UserID = '') {
        ObjectSerializer::GetTypeInfo(new EnterpriseInfolist());
        $value = array(
            '1@Long' => $UserID,
        );
        $res = $this->ps->invoke('getEnterpriseForInfoList', $value);
        return $res;
    }

    public function getEnterpriseForList($UserID = '') {
        ObjectSerializer::GetTypeInfo(new EnterpriseList());
        $value = array(
            '1@Long' => $UserID,
        );
        $res = $this->ps->invoke('getEnterpriseForList', $value);
        return $res;
    }

    public function customEnterpriseForInfoList($UserID = '') {
        ObjectSerializer::GetTypeInfo(new EnterpriseInfolist());
        $value = array(
            '1@Long' => $UserID,
        );
        $res = $this->ps->invoke('customEnterpriseForInfoList', $value);
        return $res;
    }

    public function getEnterpriseForInfoList_PHP_2($ids = '') {
        ObjectSerializer::GetTypeInfo(new EnterpriseInfolist());
        $value = array(
            '1@Long[]' => $ids,
        );
        $res = $this->ps->invoke('getEnterpriseForInfoList_PHP_2', $value);
        return $res;
    }

    public function customEnterpriseForInfoList_PHP_2($ids = '') {
        ObjectSerializer::GetTypeInfo(new EnterpriseInfolist());
        $value = array(
            '1@Long[]' => $ids,
        );
        $res = $this->ps->invoke('customEnterpriseForInfoList_PHP_2', $value);
        return $res;
    }

    public function customEnterpriseListByEnterpriseId($enterpriseIds = '') {
        ObjectSerializer::GetTypeInfo(new EnterpriseInfolist());
        $value = array(
            '1@List<Long>' => $enterpriseIds,
        );
        $res = $this->ps->invoke('customEnterpriseListByEnterpriseId', $value);
        return $res;
    }

    public function getEnterpriseForList_PHP_2($ids = '') {
        ObjectSerializer::GetTypeInfo(new EnterpriseList());
        $value = array(
            '1@Long[]' => $ids,
        );
        $res = $this->ps->invoke('getEnterpriseForList_PHP_2', $value);
        return $res;
    }

    public function getEnterpriseForInfo($userid = '') {
        ObjectSerializer::GetTypeInfo(new EnterpriseInfo());
        $value = array(
            '1@Long' => $userid,
        );
        $res = $this->ps->invoke('getEnterpriseForInfo', $value);
        return $res;
    }

    public function getLicense($ids = '') {
        $value = array(
            '1@Long[]' => $ids,
        );
        $res = $this->ps->invoke('getLicense', $value);
        return $res;
    }

    public function getEnterpriseByMobile($mobile = '', $pagesize = '') {
        ObjectSerializer::GetTypeInfo(new EnterpriseInfo());
        $value = array(
            '1@Long' => $mobile,
            '2@Integer' => $pagesize,
        );
        $res = $this->ps->invoke('getEnterpriseByMobile', $value);
        return $res;
    }
}
