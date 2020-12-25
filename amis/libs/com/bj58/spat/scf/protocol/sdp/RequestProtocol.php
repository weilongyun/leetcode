<?php
namespace com\bj58\spat\scf\protocol\sdp;

use com\bj58\spat\scf\serialize\component\SCFType;
class RequestProtocol
{
    static $_TSPEC;
    static $_SCFNAME = 'RequestProtocol';

    private $lookup;//string
    private $methodName;//string
    private $paraKVList;//List<KeyValuePair>

    public function __construct($lookup = '', $methodName = '', $paraKVList = '')
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'lookup',
                    'type' => SCFType::STRING,
                    'sortId' => 1,
                ),
                2 => array(
                    'var' => 'methodName',
                    'type' => SCFType::STRING,
                    'sortId' => 2,
                ),
                3 => array(
                    'var' => 'paraKVList',
                    'type' => SCFType::LST,
                    'etype' => SCFType::OBJECT,
                    'elem' => array(
                        'type' => SCFType::OBJECT,
                    ),
                    'sortId' => 3,
                ),
            );
        }
        $this->lookup = $lookup;
        $this->methodName = $methodName;
        $this->paraKVList = $paraKVList;
    }
 /**
     * @return the $_TSPEC
     */
    public static function getTSPEC()
    {
        return RequestProtocol::$_TSPEC;
    }

 /**
     * @return the $lookup
     */
    public function getLookup()
    {
        return $this->lookup;
    }

 /**
     * @return the $methodName
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

 /**
     * @return the $paraKVList
     */
    public function getParaKVList()
    {
        return $this->paraKVList;
    }

 /**
     * @param field_type $_TSPEC
     */
    public static function setTSPEC($_TSPEC)
    {
        RequestProtocol::$_TSPEC = $_TSPEC;
    }

 /**
     * @param field_type $lookup
     */
    public function setLookup($lookup)
    {
        $this->lookup = $lookup;
    }

 /**
     * @param field_type $methodName
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;
    }

 /**
     * @param field_type $paraKVList
     */
    public function setParaKVList($paraKVList)
    {
        $this->paraKVList = $paraKVList;
    }
}