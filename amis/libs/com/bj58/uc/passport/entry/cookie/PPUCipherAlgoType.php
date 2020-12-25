<?php
namespace com\bj58\uc\passport\entry\cookie;

class PPUCipherAlgoType {

    static $_TSPEC;
    static $_SCFNAME = 'PPUCipherAlgoType';

    const RSA = 'RSA';
    const UNKOWN = 'UNKOWN';

    public function __construct() {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => 'Enum'
            );
        }
    }
}
