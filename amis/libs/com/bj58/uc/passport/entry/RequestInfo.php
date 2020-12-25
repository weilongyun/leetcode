<?php

namespace com\bj58\uc\passport\entry;

use com\bj58\spat\scf\serialize\component\SCFType;

class RequestInfo {

    static $_TSPEC;
    static $_SCFNAME = 'RequestInfo';
    private $userIp;
    private $currentUrl;
    private $referer;
    private $userAgent;
    private $id58;
    private $otherData;

    public function __construct($userIp = '', $currentUrl = '', $referer = '', $userAgent = '', $id58 = '', $otherData = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'userIp',
                    'sortId' => 1,
                    'type' => SCFType::STRING,
                ),
                2 => array(
                    'var' => 'currentUrl',
                    'sortId' => 2,
                    'type' => SCFType::STRING,
                ),
                3 => array(
                    'var' => 'referer',
                    'sortId' => 3,
                    'type' => SCFType::STRING,
                ),
                4 => array(
                    'var' => 'userAgent',
                    'sortId' => 4,
                    'type' => SCFType::STRING,
                ),
                5 => array(
                    'var' => 'id58',
                    'sortId' => 5,
                    'type' => SCFType::STRING,
                ),
                6 => array(
                    'var' => 'otherData',
                    'sortId' => 6,
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
        $this->userIp = $userIp;
        $this->currentUrl = $currentUrl;
        $this->referer = $referer;
        $this->userAgent = $userAgent;
        $this->id58 = $id58;
        $this->otherData = $otherData;
    }

    public static function getTSPEC() {
        return RequestInfo::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        RequestInfo::$_TSPEC = $_TSPEC;
    }

    public function getUserIp() {
        return $this->userIp;
    }

    public function setUserIp($userIp) {
        $this->userIp = $userIp;
    }

    public function getCurrentUrl() {
        return $this->currentUrl;
    }

    public function setCurrentUrl($currentUrl) {
        $this->currentUrl = $currentUrl;
    }

    public function getReferer() {
        return $this->referer;
    }

    public function setReferer($referer) {
        $this->referer = $referer;
    }

    public function getUserAgent() {
        return $this->userAgent;
    }

    public function setUserAgent($userAgent) {
        $this->userAgent = $userAgent;
    }

    public function getId58() {
        return $this->id58;
    }

    public function setId58($id58) {
        $this->id58 = $id58;
    }

    public function getOtherData() {
        return $this->otherData;
    }

    public function setOtherData($otherData) {
        $this->otherData = $otherData;
    }
}
