<?php
namespace com\bj58\spat\scf\serialize\serializerV3;

use com\bj58\spat\scf\serialize\serializerV3\SerializerBase;
use com\bj58\spat\scf\serialize\serializerV3\SerializerFactory;
use com\bj58\spat\scf\serialize\component\SCFType;

class DecimalSerializer extends SerializerBase
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
     * @param SCFOutStream $outStream
     * @see \serialize\SerializerBase\SerializerBase::WriteObject()
     */
    public function WriteObject($obj, $outStream, $etype = null, $generic = false)
    {
        SerializerFactory::GetSerializer(SCFType::STRING)->WriteObject(strval($obj), $outStream);
    }

    /**
     *
     * @param SCFInStream $inStream
     * @see \serialize\SerializerBase\SerializerBase::ReadObject()
     */
    public function ReadObject($inStream, $defType, $etype = null, $generic = false)
    {
        $value = SerializerFactory::GetSerializer(SCFType::STRING)->ReadObject($inStream, "string");
        return $value;
    }
}