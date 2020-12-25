<?php
namespace com\bj58\spat\scf\serialize\serializerV3;

use com\bj58\spat\scf\serialize\serializerV3\SerializerBase;
use com\bj58\spat\scf\serialize\component\helper\ByteHelper;
use com\bj58\spat\scf\serialize\component\helper\StrHelper;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\exception\ScfException;

class StringSerializer extends SerializerBase
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
        try {
            $obj = strval($obj);
            $outStream->WriteInt32(strlen($obj));
            $outStream->write($obj);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @param SCFInStream $inStream
     * @param String $defType
     */
    public function ReadObject($inStream, $defType, $etype = null, $generic = false)
    {
        try {
            $len = $inStream->ReadInt32();
            if ($len > SCFInStream::$MAX_DATA_LEN) {
                throw new ScfException("StreamException: Data length overflow.");
            }
            if ($len === 0) {
                return StrHelper::$EmptyString;
            }
            $str = $inStream->read($len);
            return $str;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @param String $str
     */
    private function StrToBytes($str)
    {
        $bytes = array();
        for ($i = 0; $i < strlen($str); $i ++) {
            $bytes[$i] = ord($str[$i]);
        }
        return $bytes;
    }

    /**
     *
     * @param byte[] $str
     */
    private function BytesToStr($bytes)
    {
        $str = "";
        for ($i = 0; $i < count($bytes); $i ++) {
            $str .= chr($bytes[$i]);
        }
        return $str;
    }
}