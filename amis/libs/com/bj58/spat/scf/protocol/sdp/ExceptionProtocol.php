<?php
namespace com\bj58\spat\scf\protocol\sdp;

use com\bj58\spat\scf\serialize\component\SCFType;
class ExceptionProtocol
{
    static $_TSPEC;
    static $_SCFNAME = "ExceptionProtocol";

    private $errorCode;//int
    private $toIp;//String
    private $fromIp;//String
    private $errorMsg;

    public function __construct()
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'errorCode',
                    'type' => SCFType::STRING,
                    'sortId' => 1,
                ),
                2 => array(
                    'var' => 'toIp',
                    'type' => SCFType::STRING,
                    'sortId' => 2,
                ),
                3=> array(
                    'var' => 'fromIp',
                    'type' => SCFType::STRING,
                    'sortId' => 3,
                ),
                4=> array(
                    'var' => 'errorMsg',
                    'type' => SCFType::STRING,
                    'sortId' => 4,
                ),
            );
        }
    }

 /**
     * @return the $errorCode
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

 /**
     * @return the $toIp
     */
    public function getToIp()
    {
        return $this->toIp;
    }

 /**
     * @return the $fromIp
     */
    public function getFromIp()
    {
        return $this->fromIp;
    }

 /**
     * @return the $errorMsg
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

 /**
     * @param field_type $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

 /**
     * @param field_type $toIp
     */
    public function setToIp($toIp)
    {
        $this->toIp = $toIp;
    }

 /**
     * @param field_type $fromIp
     */
    public function setFromIp($fromIp)
    {
        $this->fromIp = $fromIp;
    }

 /**
     * @param field_type $errorMsg
     */
    public function setErrorMsg($errorMsg)
    {
        $this->errorMsg = $errorMsg;
    }
}