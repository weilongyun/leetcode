<?php
namespace com\bj58\spat\scf\serialize\serializerV3;

use com\bj58\spat\scf\serialize\serializerV3\SerializerBase;

class BooleanSerializer extends SerializerBase
{

    private $initObj;

    function __construct($initObj)
    {
        $this->initObj = $initObj;
    }

    function getKey()
    {
        return $this->initObj;
    }

    /**
     *
     * @param Object $obj
     * @param SCFOutStream $outStream
     */
    public function WriteObject($obj, $outStream, $etype = null, $generic = false)
    {
        $value = 0;
        if ($obj) {
            $value = 1;
        }
        $outStream->WriteByte($value);
    }

    /**
     *
     * @param SCFInStream $inStream
     * @param String $defType
     * @return boolean
     */
    public function ReadObject($inStream, $defType, $etype = null, $generic = false)
    {
        return $inStream->ReadByte() > 0;
    }
}