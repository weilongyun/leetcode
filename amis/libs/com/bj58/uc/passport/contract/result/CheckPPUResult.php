<?php

namespace com\bj58\uc\passport\contract\result;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\uc\passport\entry\cookie\PCookie;
use com\bj58\uc\passport\entry\cookie\PPU;
use com\bj58\uc\passport\entry\CrossDomainData;

class CheckPPUResult {

    static $_TSPEC;
    static $_SCFNAME = 'CheckPPUResult';
    private $code;
    private $message;
    private $newPPUCookie;
    private $ppu;
    private $crossDomainData;
    private $ext;

    public function __construct($code = '', $message = '', $newPPUCookie = '', $ppu = '', $crossDomainData = '', $ext = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'code',
                    'sortId' => 1,
                    'type' => SCFType::I32
                ),
                2 => array(
                    'var' => 'message',
                    'sortId' => 2,
                    'type' => SCFType::STRING
                ),
                3 => array(
                    'var' => 'newPPUCookie',
                    'sortId' => 3,
                    'type' => SCFType::OBJECT,
                    'elem' => array(
                        'class' => new PCookie()
                    )
                ),
                4 => array(
                    'var' => 'ppu',
                    'sortId' => 4,
                    'type' => SCFType::OBJECT,
                    'elem' => array(
                        'class' => new PPU()
                    )
                ),
                5 => array(
                    'var' => 'crossDomainData',
                    'sortId' => 5,
                    'type' => SCFType::OBJECT,
                    'elem' => array(
                        'class' => new CrossDomainData ()
                    )
                ),
                6 => array(
                    'var' => 'ext',
                    'sortId' => 6,
                    'type' => SCFType::MAP,
                    'key' => array(
                        'type' => SCFType::STRING
                    ),
                    'value' => array(
                        'type' => SCFType::STRING
                    )
                )
            );
        }
    }

    public static function getTSPEC() {
        return CheckPPUResult::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        CheckPPUResult::$_TSPEC = $_TSPEC;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getNewPPUCookie() {
        return $this->newPPUCookie;
    }

    public function setNewPPUCookie($newPPUCookie) {
        $this->newPPUCookie = $newPPUCookie;
    }

    public function getPpu() {
        return $this->ppu;
    }

    public function setPpu($ppu) {
        $this->ppu = $ppu;
    }

    public function getCrossDomainData() {
        return $this->crossDomainData;
    }

    public function setCrossDomainData($crossDomainData) {
        $this->crossDomainData = $crossDomainData;
    }

    public function getExt() {
        return $this->ext;
    }

    public function setExt($ext) {
        $this->ext = $ext;
    }
}
