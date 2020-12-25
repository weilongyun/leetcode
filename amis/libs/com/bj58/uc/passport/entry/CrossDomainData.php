<?php

namespace com\bj58\uc\passport\entry;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\uc\passport\entry\cookie\PCookie;

class CrossDomainData {

    static $_TSPEC;
    static $_SCFNAME = 'CrossDomainData';
    private $userId;
    private $html;
    private $redirectUrl;
    private $cookies;
    private $otherData;

    public function __construct($userId = '', $html = '', $redirectUrl = '', $cookies = '', $otherData = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'userId',
                    'sortId' => 1,
                    'type' => SCFType::I64,
                ),
                2 => array(
                    'var' => 'html',
                    'sortId' => 2,
                    'type' => SCFType::STRING,
                ),
                3 => array(
                    'var' => 'redirectUrl',
                    'sortId' => 3,
                    'type' => SCFType::STRING,
                ),
                4 => array(
                    'var' => 'cookies',
                    'sortId' => 4,
                    'type' => SCFType::LST,
                    'elem' => array(
                        'type' => SCFType::OBJECT,
                        'elem' => array(
                            'class' => new PCookie(),
                        ),
                    ),
                ),
                5 => array(
                    'var' => 'otherData',
                    'sortId' => 5,
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
        return CrossDomainData::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        CrossDomainData::$_TSPEC = $_TSPEC;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getHtml() {
        return $this->html;
    }

    public function setHtml($html) {
        $this->html = $html;
    }

    public function getRedirectUrl() {
        return $this->redirectUrl;
    }

    public function setRedirectUrl($redirectUrl) {
        $this->redirectUrl = $redirectUrl;
    }

    public function getCookies() {
        return $this->cookies;
    }

    public function setCookies($cookies) {
        $this->cookies = $cookies;
    }

    public function getOtherData() {
        return $this->otherData;
    }

    public function setOtherData($otherData) {
        $this->otherData = $otherData;
    }
}
