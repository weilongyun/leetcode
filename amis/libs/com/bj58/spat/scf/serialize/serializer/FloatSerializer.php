<?php

namespace com\bj58\spat\scf\serialize\serializer;
use com\bj58\spat\scf\serialize\serializer\SerializerBase;
class FloatSerializer extends SerializerBase
{
    /**
     * @param SCFOutStream $outStream
     * @see \serialize\SerializerBase\SerializerBase::WriteObject()
     */
    public function WriteObject($obj, $outStream, $etype = null)
    {
        $buf = pack("f", $obj);
        $outStream->write($buf);
    }

    /**
     * @param SCFInStream $inStream
     * @see \serialize\SerializerBase\SerializerBase::ReadObject()
     */
    public function ReadObject($inStream, $defType, $etype = null)
    {
        $res = $inStream->read(4);
        $data = unpack("f", $res);
        return $data[1];
    }
}