<?php
namespace com\bj58\spat\scf\serialize\serializerV2;

use com\bj58\spat\scf\serialize\component\SCFOutStream;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\serialize\component\helper\UseVersion;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\client\utility\LogHelper;
use com\bj58\spat\scf\serialize\component\SCFType;

class Serializer
{

    private $_Encoder = "UTF-8";

    function _construct()
    {}

    public function Serialize($obj)
    {
        $stream = null;
        try {
            $stream = new SCFOutStream();
            $stream->WriteInt16(UseVersion::$version);
            $stream->WriteInt32(0);
            if (null === $obj) {
                SerializerFactory::GetSerializer(null)->WriteObject(null, $stream);
            } else {
                if (is_object($obj)) {
                    $type = get_class($obj);
                } else {
                    $type = TypeHelper::GetTypeId(gettype($obj));
                }
                SerializerFactory::GetSerializer($type)->WriteObject($obj, $stream);
            }
            return $stream;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function Derialize($buffer, $type)
    {
        try {
            $stream = new SCFInStream($buffer);
            $version = $stream->ReadInt16();
            $exVersion = $stream->ReadInt32();
            if ($exVersion != 0 && $version != UseVersion::$version) {
                throw new ScfException('Please use serializer SCFV' . UseVersion::$version);
            }
            return SerializerFactory::GetSerializer($type)->ReadObject($stream, $type);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function registerEntity($functionName) {

    }

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
    public static function GetTypeInfo($type)
    {
        try {
            $typeClass = new \ReflectionClass($type);
            $className = $typeClass->name;
            $sname = $typeClass->getProperty("_SCFNAME")->getValue();
            if (apcu_exists('SCFTypeInfoMap')) {
                $typeInfoMap = apcu_fetch('SCFTypeInfoMap');
                if (array_key_exists('SCFV2', $typeInfoMap) && array_key_exists($className, $typeInfoMap['SCFV2'])) {
                    $typeId = TypeHelper::GetTypeId($sname, $className);
                    $GLOBALS['SCFNameAliasesMap'][$sname] = $className;
                    self::getChildObj($className);
                    if (apcu_exists('SCFTypeNameEnumMap')) {
                        $GLOBALS['SCFTypeNameEnumMap'] = apcu_fetch('SCFTypeNameEnumMap');
                    }
                    return $typeInfoMap['SCFV2'][$className];
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
                    $typeInfo->Fields[1] = 'Enum';
                    $GLOBALS['SCFTypeNameEnumMap'][$className] = $type;
                    apcu_store('SCFTypeNameEnumMap', $GLOBALS['SCFTypeNameEnumMap']);
                    break;
                }
                foreach ($values as $value) {
                    $sortId = $value['sortId'];
                    $mapFields[$sortId] = $value;
                    if (array_key_exists('elem', $value)) {
                        $elem = $value['elem'];
                        self::getElemType($elem);
                    }
                    if (array_key_exists('value', $value)) {
                        $elem = $value['value'];
                        self::getElemType($elem, $className);
                    }
                }
            }
            $typeInfo->Fields = $mapFields;

            if (apcu_exists('SCFTypeInfoMap')) {
                $typeInfoMap = apcu_fetch('SCFTypeInfoMap');
                if (array_key_exists('SCFV2', $typeInfoMap)) {
                    if (array_key_exists($className, $typeInfoMap['SCFV2'])) {
                        LogHelper::logWarnMsg('redefine class. class is ' . $className);
                    } else {
                        $typeInfoMap['SCFV2'][$className] = $typeInfo;
                    }
                } else {
                    $infoMap = array(
                        $className => $typeInfo
                    );
                    $typeInfoMap['SCFV2'] = $infoMap;
                }
            } else {
                $infoMap = array(
                    $className => $typeInfo
                );
                $typeInfoMap['SCFV2'] = $infoMap;
            }
            apcu_store('SCFTypeInfoMap', $typeInfoMap);

            if (apcu_exists('SCFTypeNameMap')) {
                $typeNameMap = apcu_fetch('SCFTypeNameMap');
            }
            $typeNameMap[$className] = $type;
            apcu_store('SCFTypeNameMap', $typeNameMap);
            $GLOBALS['SCFNameAliasesMap'][$sname] = $className;
            return $typeInfo;
        } catch (\Exception $e) {
            LogHelper::logErrorMsgException($e);
            throw $e;
        }
    }

    public static function getElemType($elem, $className = '')
    {
        try {
            if (array_key_exists('type', $elem)) {
                $type = $elem['type'];
                if ($type === SCFType::OBJECT) {
                    if (array_key_exists('class', $elem)) {
                        $class = $elem['class'];
                        if ($class !== 'this') {
                            self::GetTypeInfo($class);
                            self::registerChildParentObj($className, $class);
                        }
                    }
                } else
                    if ($type === SCFType::SET || $type === SCFType::LST || $type === SCFType::ARAY) {
                        self::getElemType($elem['elem'], $className);
                    } else
                        if ($type === SCFType::MAP) {
                            self::getElemType($elem['key'], $className);
                            self::getElemType($elem['value'], $className);
                        }
            } else {
                $class = $elem['class'];
                if ($class !== 'this') {
                    self::GetTypeInfo($class);
                    self::registerChildParentObj($className, $class);
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function registerChildParentObj($parentClassName, $child) {
        if (apcu_exists('SCFParentAndChildObj')) {
            $SCFParentAndChildObj = apcu_fetch('SCFParentAndChildObj');
            if (array_key_exists($parentClassName, $SCFParentAndChildObj)) {
                $SCFParentAndChildObj[$parentClassName][] = $child;
            } else {
                $temp = array($child);
                $SCFParentAndChildObj[$parentClassName] = $temp;
            }
        } else {
            $temp = array($child);
            $SCFParentAndChildObj = array(
                $parentClassName => $temp
            );
        }
        apcu_store('SCFParentAndChildObj', $SCFParentAndChildObj);
    }

    public static function getChildObj($parentClassName) {
        if (apcu_exists('SCFParentAndChildObj')) {
            $SCFParentAndChildObj = apcu_fetch('SCFParentAndChildObj');
            self::registerChildObj($SCFParentAndChildObj, $parentClassName);
        }
    }

    public static function registerChildObj($SCFParentAndChildObj, $parentClassName) {
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