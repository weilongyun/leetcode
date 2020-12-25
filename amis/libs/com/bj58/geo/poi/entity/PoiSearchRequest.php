<?php

namespace com\bj58\geo\poi\entity;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\geo\common\geometry\Circle;
use com\bj58\geo\common\geometry\BoundingBox;

class PoiSearchRequest {

    static $_TSPEC;
    static $_SCFNAME = 'PoiSearchRequest';
    private $circle;
    private $bounds;
    private $type;
    private $query;
    private $start;
    private $rows;
    private $mapType;

    public function __construct($circle = '', $bounds = '', $type = '', $query = '', $start = '', $rows = '', $mapType = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'circle',
                    'sortId' => 1,
                    'type' => SCFType::OBJECT,
                    'class' => new Circle(),
                ),
                2 => array(
                    'var' => 'bounds',
                    'sortId' => 2,
                    'type' => SCFType::OBJECT,
                    'class' => new BoundingBox(),
                ),
                3 => array(
                    'var' => 'type',
                    'sortId' => 3,
                    'type' => SCFType::STRING,
                ),
                4 => array(
                    'var' => 'query',
                    'sortId' => 4,
                    'type' => SCFType::STRING,
                ),
                5 => array(
                    'var' => 'start',
                    'sortId' => 5,
                    'type' => SCFType::I32,
                ),
                6 => array(
                    'var' => 'rows',
                    'sortId' => 6,
                    'type' => SCFType::I32,
                ),
                7 => array(
                    'var' => 'mapType',
                    'sortId' => 7,
                    'type' => SCFType::I32,
                ),
            );
        }
        $this->circle = $circle;
        $this->bounds = $bounds;
        $this->type = $type;
        $this->query = $query;
        $this->start = $start;
        $this->rows = $rows;
        $this->mapType = 0;
    }

    public static function getTSPEC() {
        return PoiSearchRequest::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        PoiSearchRequest::$_TSPEC = $_TSPEC;
    }

    public function getCircle() {
        return $this->circle;
    }

    public function setCircle($circle) {
        $this->circle = $circle;
    }

    public function getBounds() {
        return $this->bounds;
    }

    public function setBounds($bounds) {
        $this->bounds = $bounds;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getQuery() {
        return $this->query;
    }

    public function setQuery($query) {
        $this->query = $query;
    }

    public function getStart() {
        return $this->start;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    public function getRows() {
        return $this->rows;
    }

    public function setRows($rows) {
        $this->rows = $rows;
    }

    public function getMapType() {
        return $this->mapType;
    }

    public function setMapType($mapType) {
        $this->mapType = $mapType;
    }
}
