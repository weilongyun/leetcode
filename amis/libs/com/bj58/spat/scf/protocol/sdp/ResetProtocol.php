<?php
namespace com\bj58\spat\scf\protocol\sdp;

use com\bj58\spat\scf\serialize\component\SCFType;
class ResetProtocol
{
    static $_TSPEC;
    static $_SCFNAME = 'ResetProtocol';

    private $msg;

    public function __construct()
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'msg',
                    'type' => SCFType::STRING,
                    'sortId' => 1,
                ),
            );
        }
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;
        return $this;
    }
}