<?php
namespace com\bj58\spat\scf\protocol\sdp;

use com\bj58\spat\scf\serialize\component\SCFType;
class ResponseProtocol
{
    static $_TSPEC;
    static $_SCFNAME = 'ResponseProtocol';

    private $result;
    private $outpara;

    public function __construct()
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'result',
                    'type' => SCFType::OBJECT,
                    'sortId' => 2,
                ),
                2 => array(
                    'var' => 'outpara',
                    'type' => SCFType::ARAY,
                    'etype' => SCFType::OBJECT,
                    'sortId' => 1,
                ),
            );
        }
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    public function getOutpara()
    {
        return $this->outpara;
    }

    public function setOutpara($outpara)
    {
        $this->outpara = $outpara;
        return $this;
    }
}