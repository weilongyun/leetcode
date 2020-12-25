<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\enums;

class StationCount {
    static $_TSPEC;
    static $_SCFNAME = 'StationCountEnum';

    const ONE = 'ONE';
    const THREE = 'THREE';
    const FIVE = 'FIVE';
    const TEN = 'TEN';
    const FIVE_INT = 5;

    public function __construct() {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => 'Enum'
            );
        }
    }
}