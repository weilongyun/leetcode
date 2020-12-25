<?php

namespace com\bj58\geo\common\geometry;

use com\bj58\spat\scf\serialize\component\SCFType;

class MapType {

    static $_TSPEC;
    static $_SCFNAME = 'MapType';
    public static $Undefined =0;
    public static $GCJ02 = 1;
    public static $BD09LL = 2;
    public static $Mapbar = 3;
    public static $WGS84 = 4;
    public static $Google = 1;
    public static $Baidu =2;


    public function __construct($Undefined = '', $GCJ02 = '', $BD09LL = '', $Mapbar = '', $WGS84 = '', $Google = '', $Baidu = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'Undefined',
                    'sortId' => 1,
                    'type' => SCFType::I32,
                ),
                2 => array(
                    'var' => 'GCJ02',
                    'sortId' => 2,
                    'type' => SCFType::I32,
                ),
                3 => array(
                    'var' => 'BD09LL',
                    'sortId' => 3,
                    'type' => SCFType::I32,
                ),
                4 => array(
                    'var' => 'Mapbar',
                    'sortId' => 4,
                    'type' => SCFType::I32,
                ),
                5 => array(
                    'var' => 'WGS84',
                    'sortId' => 5,
                    'type' => SCFType::I32,
                ),
                6 => array(
                    'var' => 'Google',
                    'sortId' => 6,
                    'type' => SCFType::I32,
                ),
                7 => array(
                    'var' => 'Baidu',
                    'sortId' => 7,
                    'type' => SCFType::I32,
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


}
