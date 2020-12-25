<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\enums;

class StationDistance {
    static $_TSPEC;
    static $_SCFNAME = 'StationDistanceEnum';

    const ONE = 'ONE';
    const THREE = 'THREE';
    const FIVE = 'FIVE';
    const TEN = 'TEN';
    const FIVE_FLOAT = 5.0;

    public function __construct() {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => 'Enum'
            );
        }
    }
}