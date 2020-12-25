<?php

namespace com\bj58\fang\xiaoqu\service\dict\contract\dto;

use com\bj58\spat\scf\serialize\component\SCFType;

class TrafficLineDTO {

    static $_TSPEC;
    static $_SCFNAME = 'TrafficLineDTO';
    private $lineid;
    private $linename;
    private $cityid;
    private $intro;

    public function __construct($lineid = '', $linename = '', $cityid = '', $intro = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'lineid',
                    'sortId' => 1,
                    'type' => SCFType::I32,
                ),
                2 => array(
                    'var' => 'linename',
                    'sortId' => 2,
                    'type' => SCFType::STRING,
                ),
                3 => array(
                    'var' => 'cityid',
                    'sortId' => 3,
                    'type' => SCFType::I32,
                ),
                4 => array(
                    'var' => 'intro',
                    'sortId' => 4,
                    'type' => SCFType::STRING,
                ),
            );
        }
    }

    public static function getTSPEC() {
        return TrafficLineDTO::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        TrafficLineDTO::$_TSPEC = $_TSPEC;
    }

    public function getLineid() {
        return $this->lineid;
    }

    public function setLineid($lineid) {
        $this->lineid = $lineid;
    }

    public function getLinename() {
        return $this->linename;
    }

    public function setLinename($linename) {
        $this->linename = $linename;
    }

    public function getCityid() {
        return $this->cityid;
    }

    public function setCityid($cityid) {
        $this->cityid = $cityid;
    }

    public function getIntro() {
        return $this->intro;
    }

    public function setIntro($intro) {
        $this->intro = $intro;
    }
}
