<?php

namespace com\bj58\uc\passport\entry\cookie;

use com\bj58\spat\scf\serialize\component\SCFType;

class PPUCipherKey {

    static $_TSPEC;
    static $_SCFNAME = 'PPUCipherKey';
    private $publicKey;
    private $algoType;
    private $version;

    public function __construct($publicKey = '', $algoType = '', $version = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'publicKey',
                    'sortId' => 1,
                    'type' => SCFType::STRING,
                ),
                2 => array(
                    'var' => 'algoType',
                    'sortId' => 2,
                    'type' => SCFType::OBJECT,
                    'elem' => array(
                        'class' => new PPUCipherAlgoType(),
                    ),
                ),
                3 => array(
                    'var' => 'version',
                    'sortId' => 3,
                    'type' => SCFType::I32,
                ),
            );
        }
    }

    public static function getTSPEC() {
        return PPUCipherKey::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        PPUCipherKey::$_TSPEC = $_TSPEC;
    }

    public function getPublicKey() {
        return $this->publicKey;
    }

    public function setPublicKey($publicKey) {
        $this->publicKey = $publicKey;
    }

    public function getAlgoType() {
        return $this->algoType;
    }

    public function setAlgoType($algoType) {
        $this->algoType = $algoType;
    }

    public function getVersion() {
        return $this->version;
    }

    public function setVersion($version) {
        $this->version = $version;
    }
}
