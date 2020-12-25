<?php

namespace com\bj58\spat\scf\serialize\serializerV2;

use com\bj58\spat\scf\serialize\serializerV2\SerializerBase;
use com\bj58\spat\scf\serialize\component\helper\ByteHelper;
class CharSerializer extends SerializerBase
{
    /**
     *
     * @param Object $obj
     * @param SCFOutStream $outStream
     */
    public function WriteObject($obj, $outStream, $etype = null)
    {
        $bs = ByteHelper::GetBytesFromChar($obj);
        $outStream -> WriteByte($bs);
    }

    /**
     *
     * @param SCFInStream $inStream
     * @param String $defType
     * @return string
     */
    public function ReadObject($inStream, $defType, $etype = null)
    {
        $data = $inStream -> ReadInt16();
        return ByteHelper::GetCharFromBytes($data);
    }
}