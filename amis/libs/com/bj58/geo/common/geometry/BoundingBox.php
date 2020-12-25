<?php

namespace com\bj58\geo\common\geometry;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\geo\common\geometry\Point;

class BoundingBox {

    static $_TSPEC;
    static $_SCFNAME = 'BoundingBox';
    private $southWest;
    private $northEast;

    public function __construct($southWest = '', $northEast = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'southWest',
                    'sortId' => 1,
                    'type' => SCFType::OBJECT,
                    'class' => new Point(),
                ),
                2 => array(
                    'var' => 'northEast',
                    'sortId' => 2,
                    'type' => SCFType::OBJECT,
                    'class' => new Point(),
                ),
            );
        }
        $this->southWest = $southWest;
        $this->northEast = $northEast;
    }

    public static function getTSPEC() {
        return BoundingBox::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        BoundingBox::$_TSPEC = $_TSPEC;
    }

    public function getSouthWest() {
        return $this->southWest;
    }

    public function setSouthWest($southWest) {
        $this->southWest = $southWest;
    }

    public function getNorthEast() {
        return $this->northEast;
    }

    public function setNorthEast($northEast) {
        $this->northEast = $northEast;
    }
}
