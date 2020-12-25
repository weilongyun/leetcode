<?php
namespace com\bj58\spat\scf\serialize\serializerV2;

use com\bj58\spat\scf\serialize\serializerV2\SerializerBase;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;

class EnumSerializer extends SerializerBase
{

    /**
     *
     * @param Object $obj
     * @param SCFOutStream $outStream
     */
    public function WriteObject($obj, $outStream, $etype = null)
    {
        $outStream->WriteInt32($etype);
        SerializerFactory::GetSerializer(SCFType::STRING)->WriteObject($obj, $outStream);
    }

    /**
     *
     * @param SCFInStream $inStream
     * @param String $defType
     */
    public function ReadObject($inStream, $defType, $etype = null)
    {
        $typeId = $inStream->ReadInt32();
        $type = TypeHelper::GetType($typeId);
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
        $value = SerializerFactory::GetSerializer(SCFType::STRING)->ReadObject($inStream, null);
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