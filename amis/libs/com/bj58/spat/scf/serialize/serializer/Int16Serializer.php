<?php
namespace com\bj58\spat\scf\serialize\serializer;
use com\bj58\spat\scf\serialize\serializer\SerializerBase;
class Int16Serializer extends SerializerBase
{
    /**
     *
     * @param Object $obj
     * @param SCFOutStream $outStream
     */
    public function WriteObject($obj, $outStream, $etype = null)
    {
        $outStream -> WriteInt16($obj);
    }

    /**
     *
     * @param SCFInStream $inStream
     * @param String $defType
     */
    public function ReadObject($inStream, $defType, $etype = null)
    {
        return $inStream -> ReadInt16();
    }
}