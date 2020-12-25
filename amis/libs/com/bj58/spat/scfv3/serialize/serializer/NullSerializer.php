<?php
namespace com\bj58\spat\scf\serialize\serializer;

use com\bj58\spat\scf\serialize\serializer\SerializerBase;
class NullSerializer extends SerializerBase
{
    private $initObj;

    function __construct($initObj) {
        $this->initObj = $initObj;
    }

    function getKey() {
        return $this->initObj;
    }
    /**
     *
     * @see \serialize\SerializerBase\SerializerBase::WriteObject()
     */
    public function WriteObject($obj, $outStream, $etype = null)
    {
        $outStream->WriteInt32(0);
    }

    /**
     * SCFInStream
     * @see \serialize\SerializerBase\SerializerBase::ReadObject()
     */
    public function ReadObject($inStream, $defType, $etype = null)
    {
        return null;
    }
}