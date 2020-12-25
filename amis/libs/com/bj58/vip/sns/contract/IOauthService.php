<?php
namespace com\bj58\vip\sns\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;

class IOauthService {
    public $ps;
    public function __construct($serviceName = '', $lookup = '', $initObj = '') {
        $ps = new ProxyStandard($serviceName, $lookup, $initObj);
        $this->ps = $ps;
    }

    public function createOauthURL($redirect_uri = '', $oauthid = '', $string_scope = '') {
        $value = array(
            '1@String' => $redirect_uri,
            '2@String' => $oauthid,
            '3@String' => $string_scope,
        );
        $res = $this->ps->invoke('createOauthURL', $value);
        return $res;
    }

    public function decryptUserInfo($oauthid = '', $encrypttext = '', $intervalSecond = '') {
        $value = array(
            '1@String' => $oauthid,
            '2@String' => $encrypttext,
            '3@long' => $intervalSecond,
        );
        $res = $this->ps->invoke('decryptUserInfo', $value);
        return $res;
    }

}