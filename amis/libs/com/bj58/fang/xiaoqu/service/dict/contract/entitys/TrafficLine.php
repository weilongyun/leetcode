<?php

namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class TrafficLine {

    static $_TSPEC;
    static $_SCFNAME = 'TrafficLine';
    private $lineid;
    private $linename;
    private $cityid;
    private $intro;
    private $sortid;
    private $state;
    private $adddate;
    private $postdate;
    private $type;

    public function __construct($lineid = '', $linename = '', $cityid = '', $intro = '', $sortid = '', $state = '', $adddate = '', $postdate = '', $type = '') {
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
                5 => array(
                    'var' => 'sortid',
                    'sortId' => 5,
                    'type' => SCFType::I32,
                ),
                6 => array(
                    'var' => 'state',
                    'sortId' => 6,
                    'type' => SCFType::I16,
                ),
                7 => array(
                    'var' => 'adddate',
                    'sortId' => 7,
                    'type' => SCFType::DATE,
                ),
                8 => array(
                    'var' => 'postdate',
                    'sortId' => 8,
                    'type' => SCFType::DATE,
                ),
                9 => array(
                    'var' => 'type',
                    'sortId' => 9,
                    'type' => SCFType::I16,
                ),
            );
        }
    }

    public static function getTSPEC() {
        return TrafficLine::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        TrafficLine::$_TSPEC = $_TSPEC;
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

    public function getSortid() {
        return $this->sortid;
    }

    public function setSortid($sortid) {
        $this->sortid = $sortid;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function getAdddate() {
        return $this->adddate;
    }

    public function setAdddate($adddate) {
        $this->adddate = $adddate;
    }

    public function getPostdate() {
        return $this->postdate;
    }

    public function setPostdate($postdate) {
        $this->postdate = $postdate;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }
}
