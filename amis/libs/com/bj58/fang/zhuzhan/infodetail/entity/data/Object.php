<?php
namespace com\bj58\fang\zhuzhan\infodetail\entity\data;

use com\bj58\spat\scf\serialize\component\SCFType;

class Object
{
    static $_TSPEC;
    static $_SCFNAME = 'Object';

    public function __construct()
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array();
        }
    }
}
