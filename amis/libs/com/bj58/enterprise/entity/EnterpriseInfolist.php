<?php

namespace com\bj58\enterprise\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class EnterpriseInfolist {

    static $_TSPEC;
    static $_SCFNAME = 'EnterpriseInfolist';
    private $id;
    private $extendid;
    private $userid;
    private $name;
    private $address;
    private $enterprisetype;
    private $authstate;
    private $paraMap;

    public function __construct($id = '', $extendid = '', $userid = '', $name = '', $address = '', $enterprisetype = '', $authstate = '', $paraMap = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'id',
                    'sortId' => 1,
                    'type' => SCFType::I64,
                ),
                2 => array(
                    'var' => 'extendid',
                    'sortId' => 2,
                    'type' => SCFType::I64,
                ),
                3 => array(
                    'var' => 'userid',
                    'sortId' => 3,
                    'type' => SCFType::I64,
                ),
                4 => array(
                    'var' => 'name',
                    'sortId' => 4,
                    'type' => SCFType::STRING,
                ),
                5 => array(
                    'var' => 'address',
                    'sortId' => 5,
                    'type' => SCFType::STRING,
                ),
                6 => array(
                    'var' => 'enterprisetype',
                    'sortId' => 6,
                    'type' => SCFType::I32,
                ),
                7 => array(
                    'var' => 'authstate',
                    'sortId' => 7,
                    'type' => SCFType::I32,
                ),
                8 => array(
                    'var' => 'paraMap',
                    'sortId' => 8,
           //       'type' => SCFType::OBJECT,
           //       'class' => new Hashtable(),
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
        return EnterpriseInfolist::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        EnterpriseInfolist::$_TSPEC = $_TSPEC;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getExtendid() {
        return $this->extendid;
    }

    public function setExtendid($extendid) {
        $this->extendid = $extendid;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function setUserid($userid) {
        $this->userid = $userid;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getEnterprisetype() {
        return $this->enterprisetype;
    }

    public function setEnterprisetype($enterprisetype) {
        $this->enterprisetype = $enterprisetype;
    }

    public function getAuthstate() {
        return $this->authstate;
    }

    public function setAuthstate($authstate) {
        $this->authstate = $authstate;
    }

    public function getParaMap() {
        return $this->paraMap;
    }

    public function setParaMap($paraMap) {
        $this->paraMap = $paraMap;
    }
}
