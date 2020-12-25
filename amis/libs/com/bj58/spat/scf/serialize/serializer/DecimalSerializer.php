<?php
namespace com\bj58\spat\scf\serialize\serializer;

use com\bj58\spat\scf\serialize\serializer\SerializerBase;
use com\bj58\spat\scf\serialize\serializer\SerializerFactory;
use com\bj58\spat\scf\serialize\component\SCFType;
class DecimalSerializer extends SerializerBase
{

    /**
     *
     * @param SCFOutStream $outStream
     * @see \serialize\SerializerBase\SerializerBase::WriteObject()
     */
    public function WriteObject($obj, $outStream, $etype = null)
    {
        SerializerFactory::GetSerializer(SCFType::STRING)->WriteObject(strval($obj), $outStream);
    }

    /**
     *
     * @param SCFInStream $inStream
     * @see \serialize\SerializerBase\SerializerBase::ReadObject()
     */
    public function ReadObject($inStream, $defType, $etype = null)
    {
        $value = SerializerFactory::GetSerializer(SCFType::STRING)->ReadObject($inStream, "string");
        return $value;
    }
}