<?php

namespace com\bj58\geo\poi\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class PoiTypeName {

    static $_TSPEC;
    static $_SCFNAME = 'PoiTypeName';
    public static $CATER = 'cater';
    public static $SCOPE = 'scope';
    public static $LIFE = 'life';
    public static $HOSPITAL = 'hospital';
    public static $HOTEL = 'hotel';
    public static $HOUSE = 'house';
    public static $SHOPPING = 'shopping';
    public static $EDUCATION = 'education';
    public static $ENTERPRISE = 'enterprise';

    public function __construct($CATER = '', $SCOPE = '', $LIFE = '', $HOSPITAL = '', $HOTEL = '', $HOUSE = '', $SHOPPING = '', $EDUCATION = '', $ENTERPRISE = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'CATER',
                    'sortId' => 1,
                    'type' => SCFType::STRING,
                ),
                2 => array(
                    'var' => 'SCOPE',
                    'sortId' => 2,
                    'type' => SCFType::STRING,
                ),
                3 => array(
                    'var' => 'LIFE',
                    'sortId' => 3,
                    'type' => SCFType::STRING,
                ),
                4 => array(
                    'var' => 'HOSPITAL',
                    'sortId' => 4,
                    'type' => SCFType::STRING,
                ),
                5 => array(
                    'var' => 'HOTEL',
                    'sortId' => 5,
                    'type' => SCFType::STRING,
                ),
                6 => array(
                    'var' => 'HOUSE',
                    'sortId' => 6,
                    'type' => SCFType::STRING,
                ),
                7 => array(
                    'var' => 'SHOPPING',
                    'sortId' => 7,
                    'type' => SCFType::STRING,
                ),
                8 => array(
                    'var' => 'EDUCATION',
                    'sortId' => 8,
                    'type' => SCFType::STRING,
                ),
                9 => array(
                    'var' => 'ENTERPRISE',
                    'sortId' => 9,
                    'type' => SCFType::STRING,
                ),
            );
        }
    }

    public static function getTSPEC() {
        return PoiTypeName::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        PoiTypeName::$_TSPEC = $_TSPEC;
    }

    public static function getCATER() {
        return self::$CATER;
    }

    public static function setCATER($CATER) {
        self::$CATER = $CATER;
    }

    public static function getSCOPE() {
        return self::$SCOPE;
    }

    public static function setSCOPE($SCOPE) {
        self::$SCOPE = $SCOPE;
    }

    public static function getLIFE() {
        return self::$LIFE;
    }

    public static function setLIFE($LIFE) {
        self::$LIFE = $LIFE;
    }

    public static function getHOSPITAL() {
        return self::$HOSPITAL;
    }

    public static function setHOSPITAL($HOSPITAL) {
        self::$HOSPITAL = $HOSPITAL;
    }

    public static function getHOTEL() {
        return self::$HOTEL;
    }

    public static function setHOTEL($HOTEL) {
        self::$HOTEL = $HOTEL;
    }

    public static function getHOUSE() {
        return self::$HOUSE;
    }

    public static function setHOUSE($HOUSE) {
        self::$HOUSE = $HOUSE;
    }

    public static function getSHOPPING() {
        return self::$SHOPPING;
    }

    public static function setSHOPPING($SHOPPING) {
        self::$SHOPPING = $SHOPPING;
    }

    public static function getEDUCATION() {
        return self::$EDUCATION;
    }

    public static function setEDUCATION($EDUCATION) {
        self::$EDUCATION = $EDUCATION;
    }

    public static function getENTERPRISE() {
        return self::$ENTERPRISE;
    }

    public static function setENTERPRISE($ENTERPRISE) {
        self::$ENTERPRISE = $ENTERPRISE;
    }
}
