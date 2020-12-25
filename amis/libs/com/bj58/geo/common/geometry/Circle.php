<?php

namespace com\bj58\geo\common\geometry;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\geo\common\geometry\Point;

class Circle {

    static $_TSPEC;
    static $_SCFNAME = 'Circle';
    private $centroid;
    private $radius;

    public function __construct($centroid = '', $radius = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'centroid',
                    'sortId' => 1,
                    'type' => SCFType::OBJECT,
                    'class' => new Point(),
                ),
                2 => array(
                    'var' => 'radius',
                    'sortId' => 2,
                    'type' => SCFType::DOUBLE,
                ),
            );
        }
        $this->centroid = $centroid;
        $this->radius = $radius;
    }

    public static function getTSPEC() {
        return Circle::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        Circle::$_TSPEC = $_TSPEC;
    }

    public function getCentroid() {
        return $this->centroid;
    }

    public function setCentroid($centroid) {
        $this->centroid = $centroid;
    }

    public function getRadius() {
        return $this->radius;
    }

    public function setRadius($radius) {
        $this->radius = $radius;
    }
}
