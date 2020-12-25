<?php

namespace com\bj58\uc\passport\entry;

use com\bj58\spat\scf\serialize\component\SCFType;

class ParterAuth {

    static $_TSPEC;
    static $_SCFNAME = 'ParterAuth';
    private $clientId;
    private $clientSecret;

    public function __construct($clientId = '', $clientSecret = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'clientId',
                    'sortId' => 1,
                    'type' => SCFType::I64,
                ),
                2 => array(
                    'var' => 'clientSecret',
                    'sortId' => 2,
                    'type' => SCFType::STRING,
                ),
            );
        }
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public static function getTSPEC() {
        return ParterAuth::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        ParterAuth::$_TSPEC = $_TSPEC;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

    public function getClientSecret() {
        return $this->clientSecret;
    }

    public function setClientSecret($clientSecret) {
        $this->clientSecret = $clientSecret;
    }
}
