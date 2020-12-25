<?php

namespace com\bj58\fang\xiaoqu\service\dict\contract\dto;

use com\bj58\spat\scf\serialize\component\SCFType;

class TrafficStationDTO {

    static $_TSPEC;
    static $_SCFNAME = 'TrafficStationDTO';
    private $stationid;
    private $stationname;
    private $cityid;
    private $lon;
    private $lat;
    private $intro;
    private $stationDistance;
    private $lineList;

    public function __construct($stationid = '', $stationname = '', $cityid = '', $lon = '', $lat = '', $intro = '', $stationDistance = '', $lineList = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'stationid',
                    'sortId' => 1,
                    'type' => SCFType::I32,
                ),
                2 => array(
                    'var' => 'stationname',
                    'sortId' => 2,
                    'type' => SCFType::STRING,
                ),
                3 => array(
                    'var' => 'cityid',
                    'sortId' => 3,
                    'type' => SCFType::I32,
                ),
                4 => array(
                    'var' => 'lon',
                    'sortId' => 4,
                    'type' => SCFType::DOUBLE,
                ),
                5 => array(
                    'var' => 'lat',
                    'sortId' => 5,
                    'type' => SCFType::DOUBLE,
                ),
                6 => array(
                    'var' => 'intro',
                    'sortId' => 6,
                    'type' => SCFType::STRING,
                ),
                7 => array(
                    'var' => 'stationDistance',
                    'sortId' => 7,
                    'type' => SCFType::DOUBLE,
                ),
                8 => array(
                    'var' => 'lineList',
                    'sortId' => 8,
                    'type' => SCFType::LST,
                    'elem' => array(
                        'type' => SCFType::OBJECT,
                        'class' => new TrafficLineDTO(),
                    ),
                ),
            );
        }
    }

    public static function getTSPEC() {
        return TrafficStationDTO::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        TrafficStationDTO::$_TSPEC = $_TSPEC;
    }

    public function getStationid() {
        return $this->stationid;
    }

    public function setStationid($stationid) {
        $this->stationid = $stationid;
    }

    public function getStationname() {
        return $this->stationname;
    }

    public function setStationname($stationname) {
        $this->stationname = $stationname;
    }

    public function getCityid() {
        return $this->cityid;
    }

    public function setCityid($cityid) {
        $this->cityid = $cityid;
    }

    public function getLon() {
        return $this->lon;
    }

    public function setLon($lon) {
        $this->lon = $lon;
    }

    public function getLat() {
        return $this->lat;
    }

    public function setLat($lat) {
        $this->lat = $lat;
    }

    public function getIntro() {
        return $this->intro;
    }

    public function setIntro($intro) {
        $this->intro = $intro;
    }

    public function getStationDistance() {
        return $this->stationDistance;
    }

    public function setStationDistance($stationDistance) {
        $this->stationDistance = $stationDistance;
    }

    public function getLineList() {
        return $this->lineList;
    }

    public function setLineList($lineList) {
        $this->lineList = $lineList;
    }
}
