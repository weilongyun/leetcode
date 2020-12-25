<?php
namespace com\bj58\spat\scf\serialize\serializerV3;

use com\bj58\spat\scf\serialize\serializerV3\SerializerBase;
use com\bj58\spat\scf\serialize\component\helper\ByteHelper;

class CharSerializer extends SerializerBase
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
        $bs = ByteHelper::GetBytesFromChar($obj);
        $outStream->write($bs);
    }

    /**
     *
     * @param SCFInStream $inStream
     * @param String $defType
     * @return string
     */
    public function ReadObject($inStream, $defType, $etype = null, $generic = false)
    {
        $data = $inStream->read(2);
        return ByteHelper::GetCharFromBytes($data);
    }
}