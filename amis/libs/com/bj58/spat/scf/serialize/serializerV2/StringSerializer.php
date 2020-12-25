<?php
namespace com\bj58\spat\scf\serialize\serializerV2;


use com\bj58\spat\scf\serialize\serializerV2\SerializerBase;
use com\bj58\spat\scf\serialize\component\helper\ByteHelper;
use com\bj58\spat\scf\serialize\component\helper\StrHelper;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\exception\ScfException;
class StringSerializer extends SerializerBase
{

    /**
     *
     * @param Object $obj
     * @param SCFOutStream $outStream
     */
    public function WriteObject($obj, $outStream, $etype = null)
    {
        try {
            $obj = strval($obj);
            if ($outStream->WriteRef($obj)) {
                return;
            }
            $bLen = ByteHelper::GetBytesFromInt32(strlen($obj));
            $outStream->write($bLen);
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
    public function ReadObject($inStream, $defType, $etype = null)
    {
        try {
            $isRef = $inStream->ReadByte();
            $hashcode = $inStream->ReadInt32();
            if ($isRef > 0) {
                $obj = $inStream->GetRef($hashcode);
                if (null === $obj) {
                    return StrHelper::$EmptyString;
                }
                return $obj;
            }
            $len = $inStream -> ReadInt32();
            if ($len > SCFInStream::$MAX_DATA_LEN) {
                throw new ScfException("StreamException: Data length overflow.");
            }
            if ($len === 0) {
                $inStream ->SetRef($hashcode, StrHelper::$EmptyString);
                return StrHelper::$EmptyString;
            }
            $str = $inStream->read($len);
            $inStream->SetRef($hashcode, $str);
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