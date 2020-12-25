<?php
namespace com\bj58\spat\scf\serialize\serializerV3;

use com\bj58\spat\scf\serialize\serializerV3\SerializerBase;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\serialize\component\helper\StrHelper;

class EnumSerializer extends SerializerBase
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
        $index = $outStream->getLength();
        $outStream->reservedLen(4);
        $outStream->WriteInt32($etype);
        $obj = strval($obj);
        $outStream->write($obj);
        $len = $outStream->getLength() - $index - 4;
        $outStream->writeObjLen($len, $index);
    }

    /**
     *
     * @param SCFInStream $inStream
     * @param String $defType
     */
    public function ReadObject($inStream, $defType, $etype = null, $generic = false)
    {
        $totalLen = $inStream->ReadInt32();
        $typeId = $inStream->ReadInt32();
        $type = TypeHelper::GetTypeV3($typeId);
        if (null === $type) {
            throw new ScfException("deserializer enum error. typeId is " . $typeId . ", can not get valid type. ");
        }
        $typeNameMap = @apcu_fetch('SCFTypeNameMap');
        if (null != $typeNameMap) {
            if (array_key_exists($type, $typeNameMap)) {
                $type = $typeNameMap[$type];
            }
        }
        $class = new \ReflectionClass($type);
        $len = $totalLen - 4;
        if ($len === 0) {
            return StrHelper::$EmptyString;
        }
        $value = $inStream->read($len);
        $constants = $class->getConstants();
        if (null == $constants) {
            throw new ScfException('deserializer enum error, enum is ' . $type . ' constants is null');
        }
        $res = array_search($value, $constants);
        $pro = $class->getProperty("_SCFNAME");
        $obj = $pro->getValue() . '::' . $res;
        return $obj;
    }
}