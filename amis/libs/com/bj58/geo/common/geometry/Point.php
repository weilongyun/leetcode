<?php

namespace com\bj58\geo\common\geometry;

use com\bj58\spat\scf\serialize\component\SCFType;

class Point {

    static $_TSPEC;
    static $_SCFNAME = 'Point';
    private $longitude;
    private $latitude;

    public function __construct($longitude = '', $latitude = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'longitude',
                    'sortId' => 1,
                    'type' => SCFType::DOUBLE,
                ),
                2 => array(
                    'var' => 'latitude',
                    'sortId' => 2,
                    'type' => SCFType::DOUBLE,
                ),
            );
        }
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    public static function getTSPEC() {
        return Point::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        Point::$_TSPEC = $_TSPEC;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }
}
