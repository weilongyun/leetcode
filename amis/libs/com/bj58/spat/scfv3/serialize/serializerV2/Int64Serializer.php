<?php
namespace com\bj58\spat\scf\serialize\serializerV2;

use com\bj58\spat\scf\serialize\serializerV2\SerializerBase;

class Int64Serializer extends SerializerBase
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
    public function WriteObject($obj, $outStream, $etype = null)
    {
        $outStream->WriteInt64($obj);
    }

    /**
     *
     * @param SCFInStream $inStream
     * @param String $defType
     */
    public function ReadObject($inStream, $defType, $etype = null)
    {
        return $inStream->ReadInt64();
    }
}