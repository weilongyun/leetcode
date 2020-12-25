<?php
namespace com\bj58\spat\scf\serialize\serializerV2;

use com\bj58\spat\scf\serialize\serializerV2\SerializerBase;
use com\bj58\spat\scf\serialize\component\helper\ByteHelper;

class DateTimeSerializer extends SerializerBase
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
    public function WriteObject($obj, $outStream, $etype = null)
    {
        $buffer = $this->ConverToBinary($obj);
        $outStream->write($buffer);
    }

    /**
     *
     * @param SCFInStream $inStream
     * @see \serialize\SerializerBase\SerializerBase::ReadObject()
     */
    public function ReadObject($inStream, $defType, $etype = null)
    {
        $buffer = array();
        $buffer = $inStream->read(8);
        $date = $this->GetDateTime($buffer);
        return $date;
    }

    // const TimeZone = 8 * 60 * 60 * 1000;

    /**
     *
     * @param \DateTime $date
     */
    private function ConverToBinary($date)
    {
        if (is_object($date)) {
            $dt = $date->getTimestamp();
        } else {
            $dt = $date;
        }
        $dt = $dt * 1000 + 8 * 60 * 60 * 1000;
        return ByteHelper::GetBytesFromInt64($dt);
    }

    /**
     *
     * @param byte[] $buffer
     */
    private function GetDateTime($buffer)
    {
        try {
            $dt = ByteHelper::ToInt64($buffer);
            $dt = $dt - (8 * 60 * 60 * 1000);
            $dt = round($dt / 1000);
            return @getdate($dt);
        } catch (\OutOfRangeException $e) {
            throw $e;
        }
    }
}