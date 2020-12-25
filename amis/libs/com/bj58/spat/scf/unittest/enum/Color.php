<?php
namespace com\bj58\spat\scf\unittest\enum;
class Color{
    static $_TSPEC;
    static $_SCFNAME = 'Color';

    const RED = 'RED';
    const BLUE = 'BLUE';
    const BLACK = 'BLACK';
    const WHITE = 'WHITE';
    public function __construct() {
        if(!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1=>'Enum'
            );
        }
    }
}

?>