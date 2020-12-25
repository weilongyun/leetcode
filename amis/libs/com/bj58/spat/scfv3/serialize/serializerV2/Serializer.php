<?php
namespace com\bj58\spat\scf\serialize\serializerV2;

use com\bj58\spat\scf\serialize\component\SCFOutStream;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\serialize\component\helper\UseVersion;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\client\utility\LogHelper;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\serialize\utility\SerializeApcuUtil;

class Serializer
{

    private $_Encoder = "UTF-8";

    function _construct()
    {}

    public function Serialize($obj, $initObj = '')
    {
        $stream = null;
        try {
            $stream = new SCFOutStream();
            $stream->WriteInt16(UseVersion::$version);
            $stream->WriteInt32(0);
            if (null === $obj) {
                SerializerFactory::GetSerializer(null, $initObj)->WriteObject(null, $stream);
            } else {
                if (is_object($obj)) {
                    $type = get_class($obj);
                } else {
                    $type = TypeHelper::GetTypeId(gettype($obj));
                }
                SerializerFactory::GetSerializer($type, $initObj)->WriteObject($obj, $stream);
            }
            return $stream;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function Derialize($buffer, $type, $initObj = '')
    {
        try {
            $stream = new SCFInStream($buffer);
            $version = $stream->ReadInt16();
            $exVersion = $stream->ReadInt32();
            if ($exVersion != 0 && $version != UseVersion::$version) {
                throw new ScfException('Please use serializer SCFV' . UseVersion::$version);
            }
            return SerializerFactory::GetSerializer($type, $initObj)->ReadObject($stream, $type);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function registerEntity($functionName)
    {}

    public function getEncoder()
    {
        return $this->_Encoder;
    }

    public function setEncoder($_Encoder)
    {
        $this->_Encoder = $_Encoder;
        return $this;
    }

    /**
     *
     * @param TypeInfo $type
     */
    public static function GetTypeInfo($type, $initObj = '')
    {
        try {
            $typeClass = new \ReflectionClass($type);
            $className = $typeClass->name;
            $sname = $typeClass->getProperty("_SCFNAME")->getValue();
            $serializeMap = array();
            $SCFTypeNameEnumMap = array();
            $hasEnum = false;
            $typeInfo = array();
            $key = '';
            if (is_object($initObj)) {
                $key = $initObj->getSerivalizeKey();
                if (! empty($key)) {
                    if (SerializeApcuUtil::getTypeInfoMapByKey($key, $className, $sname, $serializeMap, $typeInfo, 'SCFV2')) {
                        return $typeInfo;
                    }
                } else {
                    if (SerializeApcuUtil::getTypeInfo($className, $sname, $typeInfo, 'SCFV2')) {
                        return $typeInfo;
                    }
                }
            } else {
                if (SerializeApcuUtil::getTypeInfo($className, $sname, $typeInfo, 'SCFV2')) {
                    return $typeInfo;
                }
            }

            $typeId = TypeHelper::GetTypeId($sname, $className);
            $typeInfo = new TypeInfo($typeId);
            $properties = array();
            while (true) {
                $pro = $typeClass->getProperty("_TSPEC");
                $superClass = $typeClass->getParentClass();
                $properties[] = $pro;
                if (false === $superClass) {
                    break;
                }
                $typeClass = $superClass;
            }
            $mapFields = array();
            $len = count($properties);
            for ($i = $len - 1; $i >= 0; $i --) {
                $protoerty = $properties[$i];
                $values = $protoerty->getValue();
                if ($values[1] === 'Enum') {
                    $hasEnum = true;
                    $typeInfo->Fields[1] = 'Enum';
                    $GLOBALS['SCFTypeNameEnumMap'][$className] = $type;
                    if (empty($key)) {
                        if (apcu_exists('SCFTypeNameEnumMap')) {
                            $temp = apcu_fetch('SCFTypeNameEnumMap');
                            $temp[$className] = $type;
                        } else {
                            $temp = $GLOBALS['SCFTypeNameEnumMap'];
                        }
                        apcu_store('SCFTypeNameEnumMap', $temp);
                        LogHelper::logWarnMsg("regist " . $className . " into SCFV2 enum map. current map is " . json_encode($temp));
                    } else {
                        if (array_key_exists('SCFTypeNameEnumMap', $serializeMap)) {
                            $SCFTypeNameEnumMap = $serializeMap['SCFTypeNameEnumMap'];
                            $SCFTypeNameEnumMap[$className] = $type;
                        } else {
                            $SCFTypeNameEnumMap = $GLOBALS['SCFTypeNameEnumMap'];
                            LogHelper::logWarnMsg("regist " . $className . " into SCFV2 enum map with key. key is " . $key . " current map is " . json_encode($temp));
                        }
                    }
                    break;
                }
                foreach ($values as $value) {
                    $sortId = $value['sortId'];
                    $mapFields[$sortId] = $value;
                    if (array_key_exists('elem', $value)) {
                        $elem = $value['elem'];
                        self::getElemType($elem, $className, $initObj, $serializeMap);
                    }
                    if (array_key_exists('value', $value)) {
                        $elem = $value['value'];
                        self::getElemType($elem, $className, $initObj, $serializeMap);
                    }
                }
            }
            $typeInfo->Fields = $mapFields;

            if (empty($key)) {
                SerializeApcuUtil::updateSerializeMap($className, $typeInfo, 'SCFV2');
                if (apcu_exists('SCFTypeNameMap')) {
                    $typeNameMap = apcu_fetch('SCFTypeNameMap');
                }
                $typeNameMap[$className] = $type;
                apcu_store('SCFTypeNameMap', $typeNameMap);
                $GLOBALS['SCFNameAliasesMap'][$sname] = $className;
                LogHelper::logWarnMsg("regist " . $className . " into SCFV2 entity map!");
            } else {
                $serializeMap = SerializeApcuUtil::updateSerializeMapByKey($key, $className, $typeInfo, 'SCFV2');
                if ($hasEnum) {
                    $serializeMap['SCFTypeNameEnumMap'] = $SCFTypeNameEnumMap;
                }

                if (array_key_exists('SCFTypeNameMap', $serializeMap)) {
                    $typeNameMap = $serializeMap['SCFTypeNameMap'];
                }
                $typeNameMap[$className] = $type;
                $serializeMap['SCFTypeNameMap'] = $typeNameMap;
                $GLOBALS['SCFNameAliasesMap'][$sname] = $className;
                apcu_store($key, $serializeMap);
                LogHelper::logWarnMsg("regist " . $className . " into SCFV2 entity map with key. key is " . $key);
            }
            return $typeInfo;
        } catch (\Exception $e) {
            LogHelper::logErrorMsgException($e);
            throw $e;
        }
    }

    public static function getElemType($elem, $className = '', $initObj = '', &$serializeMap = '')
    {
        try {
            if (array_key_exists('type', $elem)) {
                $type = $elem['type'];
                if ($type === SCFType::OBJECT) {
                    if (array_key_exists('class', $elem)) {
                        $class = $elem['class'];
                        if ($class !== 'this') {
                            self::GetTypeInfo($class, $initObj);
                            self::registerChildParentObj($className, $class, $serializeMap);
                        }
                    }
                } else
                    if ($type === SCFType::SET || $type === SCFType::LST || $type === SCFType::ARAY) {
                        self::getElemType($elem['elem'], $className, $serializeMap);
                    } else
                        if ($type === SCFType::MAP) {
                            self::getElemType($elem['key'], $className, $initObj, $serializeMap);
                            self::getElemType($elem['value'], $className, $initObj, $serializeMap);
                        }
            } else {
                $class = $elem['class'];
                if ($class !== 'this') {
                    self::GetTypeInfo($class, $initObj);
                    self::registerChildParentObj($className, $class, $serializeMap);
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function registerChildParentObj($parentClassName,$child , &$serializeMap = '')
    {
        if (is_array($serializeMap) && array_key_exists('SCFParentAndChildObj', $serializeMap)) {
            $SCFParentAndChildObj = $serializeMap['SCFParentAndChildObj'];
            if (array_key_exists($parentClassName, $SCFParentAndChildObj)) {
                $SCFParentAndChildObj[$parentClassName][] = $child;
            } else {
                $temp = array(
                    $child
                );
                $SCFParentAndChildObj[$parentClassName] = $temp;
            }
        } else {
            $temp = array(
                $child
            );
            $SCFParentAndChildObj = array(
                $parentClassName => $temp
            );
        }
        $serializeMap['SCFParentAndChildObj'] = $SCFParentAndChildObj;
    }

    public static function getChildObj($parentClassName, &$serializeMap = '')
    {
        if (is_array($serializeMap) && array_key_exists('SCFParentAndChildObj', $serializeMap)) {
            $SCFParentAndChildObj = $serializeMap['SCFParentAndChildObj'];
            self::registerChildObj($SCFParentAndChildObj, $parentClassName);
        }
    }

    public static function registerChildObj($SCFParentAndChildObj, $parentClassName)
    {
        if (array_key_exists($parentClassName, $SCFParentAndChildObj)) {
            $childClassList = $SCFParentAndChildObj[$parentClassName];
            foreach ($childClassList as $child) {
                $typeClass = new \ReflectionClass($child);
                $className = $typeClass->name;
                $sname = $typeClass->getProperty("_SCFNAME")->getValue();
                TypeHelper::GetTypeId($sname, $className);
                $GLOBALS['SCFNameAliasesMap'][$sname] = $className;
                if (array_key_exists($className, $SCFParentAndChildObj)) {
                    $className = self::registerChildObj($SCFParentAndChildObj, $className);
                }
            }
        }
    }
}

class TypeInfo
{

    public $TypeId;

    public $Fields = array();

    function __construct($typeId)
    {
        $this->TypeId = $typeId;
    }

    public function setTypeId($typeId)
    {
        $this->TypeId = $typeId;
    }

    public function getTypeId()
    {
        return $this->TypeId;
    }
}