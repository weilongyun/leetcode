<?php
namespace com\bj58\spat\scf\serialize\serializerV2;

use com\bj58\spat\scf\serialize\serializerV2\SerializerBase;

class DoubleSerializer extends SerializerBase
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

    /*
     * @param SCFOutStream $outStream
     * @see \serialize\SerializerBase\SerializerBase::WriteObject()
     */
    public function WriteObject($obj, $outStream, $etype = null)
    {
        $buf = pack("d", $obj);
        $outStream->write($buf);
    }

    public function ReadObject($inStream, $defType, $etype = null)
    {
        $res = $inStream->read(8);
        $data = unpack("d", $res);
        return $data[1];
    }
}