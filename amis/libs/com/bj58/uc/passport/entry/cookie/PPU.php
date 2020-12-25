<?php

namespace com\bj58\uc\passport\entry\cookie;

use com\bj58\spat\scf\serialize\component\SCFType;

class PPU {

    static $_TSPEC;
    static $_SCFNAME = 'PPU';
    private $ppuBodyCipherText;
    private $version;
    private $ppuBody;
    private $ext;

    public function __construct($ppuBodyCipherText = '', $version = '', $ppuBody = '', $ext = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'ppuBodyCipherText',
                    'sortId' => 1,
                    'type' => SCFType::STRING,
                ),
                2 => array(
                    'var' => 'version',
                    'sortId' => 2,
                    'type' => SCFType::I32,
                ),
                3 => array(
                    'var' => 'ppuBody',
                    'sortId' => 3,
                    'type' => SCFType::OBJECT,
                    'elem' => array(
                        'class' => new PPUBody(),
                    ),
                ),
                4 => array(
                    'var' => 'ext',
                    'sortId' => 4,
                    'type' => SCFType::MAP,
                    'key' => array(
                        'type' => SCFType::STRING,
                    ),
                    'value' => array(
                        'type' => SCFType::STRING,
                    ),
                ),
            );
        }
    }

    public static function getTSPEC() {
        return PPU::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        PPU::$_TSPEC = $_TSPEC;
    }

    public function getPpuBodyCipherText() {
        return $this->ppuBodyCipherText;
    }

    public function setPpuBodyCipherText($ppuBodyCipherText) {
        $this->ppuBodyCipherText = $ppuBodyCipherText;
    }

    public function getVersion() {
        return $this->version;
    }

    public function setVersion($version) {
        $this->version = $version;
    }

    public function getPpuBody() {
        return $this->ppuBody;
    }

    public function setPpuBody($ppuBody) {
        $this->ppuBody = $ppuBody;
    }

    public function getExt() {
        return $this->ext;
    }

    public function setExt($ext) {
        $this->ext = $ext;
    }
}
