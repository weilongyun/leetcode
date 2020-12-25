<?php
namespace com\bj58\spat\scf\serialize\serializer;

use com\bj58\spat\scf\serialize\serializer\SerializerBase;
class BooleanSerializer extends SerializerBase
{
    /**
     *
     * @param Object $obj
     * @param SCFOutStream $outStream
     */
    public function WriteObject($obj, $outStream, $etype = null)
    {
        $value = 0;
        if ($obj) {
            $value = 1;
        }
        $outStream -> WriteByte($value);
    }

    /**
     *
     * @param SCFInStream $inStream
     * @param String $defType
     * @return boolean
     */
    public function ReadObject($inStream, $defType, $etype = null)
    {
        return $inStream -> ReadByte() > 0;
    }
}