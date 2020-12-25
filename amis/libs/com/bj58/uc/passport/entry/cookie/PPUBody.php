<?php

namespace com\bj58\uc\passport\entry\cookie;

use com\bj58\spat\scf\serialize\component\SCFType;

class PPUBody {

    static $_TSPEC;
    static $_SCFNAME = 'PPUBody';
    private $userId;
    private $createTime;
    private $ticketId;
    private $level;
    private $domain;
    private $loginVer;
    private $type;

    public function __construct($userId = '', $createTime = '', $ticketId = '', $level = '', $domain = '', $loginVer = '', $type = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'userId',
                    'sortId' => 1,
                    'type' => SCFType::I64,
                ),
                2 => array(
                    'var' => 'createTime',
                    'sortId' => 2,
                    'type' => SCFType::I64,
                ),
                3 => array(
                    'var' => 'ticketId',
                    'sortId' => 3,
                    'type' => SCFType::STRING,
                ),
                4 => array(
                    'var' => 'level',
                    'sortId' => 4,
                    'type' => SCFType::I16,
                ),
                5 => array(
                    'var' => 'domain',
                    'sortId' => 5,
                    'type' => SCFType::STRING,
                ),
                6 => array(
                    'var' => 'loginVer',
                    'sortId' => 6,
                    'type' => SCFType::I32,
                ),
                7 => array(
                    'var' => 'type',
                    'sortId' => 7,
                    'type' => SCFType::BYTE,
                ),
            );
        }
    }

    public static function getTSPEC() {
        return PPUBody::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        PPUBody::$_TSPEC = $_TSPEC;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getCreateTime() {
        return $this->createTime;
    }

    public function setCreateTime($createTime) {
        $this->createTime = $createTime;
    }

    public function getTicketId() {
        return $this->ticketId;
    }

    public function setTicketId($ticketId) {
        $this->ticketId = $ticketId;
    }

    public function getLevel() {
        return $this->level;
    }

    public function setLevel($level) {
        $this->level = $level;
    }

    public function getDomain() {
        return $this->domain;
    }

    public function setDomain($domain) {
        $this->domain = $domain;
    }

    public function getLoginVer() {
        return $this->loginVer;
    }

    public function setLoginVer($loginVer) {
        $this->loginVer = $loginVer;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }
}
