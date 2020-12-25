<?php

namespace com\bj58\uc\passport\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\uc\passport\entry\RequestInfo;
use com\bj58\uc\passport\entry\ParterAuth;
use com\bj58\uc\passport\contract\result\CheckPPUResult;
use com\bj58\uc\passport\entry\cookie\PCookie;
use com\bj58\uc\passport\entry\cookie\PPU;
use com\bj58\uc\passport\entry\CrossDomainData;

class IPassportLoginService {

    public $ps;

    public function __construct($serviceName = '', $lookup = '', $initObj = '') {
        $ps = new ProxyStandard($serviceName, $lookup, $initObj);
        $this->ps = $ps;
    }

    public function checkAndUpdatePPU($parterAuth = '', $ppu = '', $requestInfo = '') {
        ObjectSerializer::GetTypeInfo(new ParterAuth());
        ObjectSerializer::GetTypeInfo(new CheckPPUResult());
        ObjectSerializer::GetTypeInfo(new RequestInfo());
        ObjectSerializer::GetTypeInfo(new PCookie());
        ObjectSerializer::GetTypeInfo(new PPU());
        ObjectSerializer::GetTypeInfo(new CrossDomainData());
        
        $value = array(
            '1@ParterAuth' => $parterAuth,
            '2@String' => $ppu,
            '3@RequestInfo' => $requestInfo,
        );
        $res = $this->ps->invoke('checkAndUpdatePPU', $value);
        return $res;
    }

    public function logout($parterAuth = '', $ppu = '', $requestInfo = '') {
        ObjectSerializer::GetTypeInfo(new ParterAuth());
        ObjectSerializer::GetTypeInfo(new RequestInfo());
        $value = array(
            '1@ParterAuth' => $parterAuth,
            '2@String' => $ppu,
            '3@RequestInfo' => $requestInfo,
        );
        $res = $this->ps->invoke('logout', $value);
        return $res;
    }
}
