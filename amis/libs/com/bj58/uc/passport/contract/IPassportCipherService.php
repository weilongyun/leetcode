<?php

namespace com\bj58\uc\passport\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\uc\passport\entry\ParterAuth;
use com\bj58\uc\passport\entry\cookie\PPUCipherKey;
use com\bj58\uc\passport\entry\cookie\PPUCipherAlgoType;

class IPassportCipherService {

    public $ps;

    public function __construct($serviceName = '', $lookup = '', $initObj = '') {
        $ps = new ProxyStandard($serviceName, $lookup, $initObj);
        $this->ps = $ps;
    }

    public function getTopPublicKey($parterAuth = '', $size = '') {
        ObjectSerializer::GetTypeInfo(new ParterAuth());
        ObjectSerializer::GetTypeInfo(new PPUCipherKey());
        ObjectSerializer::GetTypeInfo(new PPUCipherAlgoType());        
        $value = array(
            '1@ParterAuth' => $parterAuth,
            '2@int' => $size
        );
        $res = $this->ps->invoke('getTopPublicKey', $value);
        return $res;
    }
}
