<?php
namespace com\bj58\spat\scf\serialize\serializerV3;

use com\bj58\spat\scf\serialize\component\SCFOutStream;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\client\utility\LogHelper;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\serialize\utility\SerializeApcuUtil;

class SerializerV3
{

    private $_Encoder = "UTF-8";

    function _construct()
    {}

    public function Serialize($obj, $initObj = '')
    {
        $stream = null;
        try {
            $stream = new SCFOutStream();
            $stream->WriteInt16(3);
            if (null === $obj) {
                $stream->WriteByte(0);
            } else {
                $stream->WriteByte(1);
                if (is_object($obj)) {
                    $type = get_class($obj);
                } else {
                    $type = TypeHelper::GetTypeIdV3(gettype($obj));
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
            $stream->ReadInt16();
            $isNull = $stream->ReadByte();
            if ($isNull === 0) {
                return null;
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
            $serializeMap = array();
            $SCFTypeNameEnumMap = array();
            $hasEnum = false;
            $typeInfo = array();
            $key = '';
            if (is_object($initObj)) {
                $key = $initObj->getSerivalizeKey();
                if (! empty($key)) {
                    if (SerializeApcuUtil::getTypeInfoMapByKeyV3($key, $className, $serializeMap, $typeInfo, 'SCFV3')) {
                        return $typeInfo;
                    }
                } else {
                    if (SerializeApcuUtil::getTypeInfoV3($className, $typeInfo, 'SCFV3')) {
                        return $typeInfo;
                    }
                }
            } else {
                if (SerializeApcuUtil::getTypeInfoV3($className, $typeInfo, 'SCFV3')) {
                    return $typeInfo;
                }
            }

            $typeId = TypeHelper::GetTypeIdV3($className);
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
            $indexIds = array();
            $len = count($properties);
            for ($i = $len - 1; $i >= 0; $i --) {
                $protoerty = $properties[$i];
                $values = $protoerty->getValue();
                if (is_array($values[1]) && !array_key_exists("orderId", $values[1])) {
                    LogHelper::logWarnMsg("class " . $className . " field " . $values[1]['var'] . " not contain orderId. regist to scfv3 entity failed!!");
                    return ;
                }
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
                        LogHelper::logWarnMsg("regist " . $className . " into SCFV3 enum map. current map is " . json_encode($temp));
                    } else {
                        if (array_key_exists('SCFTypeNameEnumMap', $serializeMap)) {
                            $SCFTypeNameEnumMap = $serializeMap['SCFTypeNameEnumMap'];
                            $SCFTypeNameEnumMap[$className] = $type;
                        } else {
                            $SCFTypeNameEnumMap = $GLOBALS['SCFTypeNameEnumMap'];
                        }
                        LogHelper::logWarnMsg("regist " . $className . " into SCFV3 enum map with key. key is " . $key . " current map is " . json_encode($SCFTypeNameEnumMap));
                    }
                    break;
                }
                foreach ($values as $value) {
                    $orderId = $value['orderId'];
                    $indexIds[] = $orderId;
                    $type = $value['type'];
                    if ($type == SCFType::MAP) {
                        $elemType = $value['value']['type'];
                        $valueElem = $value['value'];
                        if ($elemType == SCFType::OBJECT) {
                            $elem = $valueElem['class'];
                            $value['value']['type'] = self::GetTypeInfo($elem, $initObj)->TypeId;
                        } else {
                            if (array_key_exists('elem', $valueElem)) {
                                $elem = $valueElem['elem'];
                                self::getElemType($elem, $className, $initObj, $serializeMap, $value['value']);
                            }
                        }
                    } else {
                        if (array_key_exists('elem', $value)) {
                            $elem = $value['elem'];
                            self::getElemType($elem, $className, $initObj, $serializeMap, $value);
                        }
                        if (array_key_exists('class', $value)) {
                            $elem = $value['class'];
                            $value['type'] = self::GetTypeInfo($elem, $initObj)->TypeId;
                        }
                    }
                    $mapFields[$orderId] = $value;
                }
            }

            //sorting
            $indexlen = count($indexIds);
            for ($i = 0; $i < $indexlen; $i++ ) {
                for ($j = $i + 1; $j < $indexlen; $j ++) {
                    $item = $indexIds[$j];
                    if ($indexIds[$i] > $item) {
                        $indexIds[$j] = $indexIds[$i];
                        $indexIds[$i] = $item;
                    }
                }
            }

            foreach($indexIds as $sortID) {
                $typeInfo->Fields[] = $mapFields[$sortID];
            }

            if (empty($key)) {
                SerializeApcuUtil::updateSerializeMap($className, $typeInfo, 'SCFV3');
                LogHelper::logWarnMsg("regist " . $className . " into SCFV3 entity map.");
            } else {
                $serializeMap = SerializeApcuUtil::updateSerializeMapByKey($key, $className, $typeInfo, 'SCFV3');
                if ($hasEnum) {
                    $serializeMap['SCFTypeNameEnumMap'] = $SCFTypeNameEnumMap;
                }
                apcu_store($key, $serializeMap);
                LogHelper::logWarnMsg("regist " . $className . " into SCFV3 entity map with key, key is " . $key);
            }
            return $typeInfo;
        } catch (\Exception $e) {
            LogHelper::logErrorMsgException($e);
            throw $e;
        }
    }

    public static function getElemType($elem, $className = '', $initObj = '', &$serializeMap = '', &$value = '')
    {
        try {
            if (array_key_exists('type', $elem)) {
                $type = $elem['type'];
                if ($type === SCFType::OBJECT) {
                    if (array_key_exists('class', $elem)) {
                        $class = $elem['class'];
                        if ($class !== 'this') {
                            $typeInfo = self::GetTypeInfo($class, $initObj);
                            $value['etype'] = $typeInfo->TypeId;
                            self::registerChildParentObj($className, $class, $serializeMap);
                        }
                    }
                } else
                    if ($type === SCFType::SET || $type === SCFType::LST || $type === SCFType::ARAY) {
                        self::getElemType($elem['elem'], $className, $initObj, $serializeMap);
                    } else
                        if ($type === SCFType::MAP) {
                            self::getElemType($elem['key'], $className, $initObj, $serializeMap);
                            self::getElemType($elem['value'], $className, $initObj, $serializeMap);
                        }
            } else {
                $class = $elem['class'];
                if ($class !== 'this') {
                    $typeInfo = self::GetTypeInfo($class, $initObj);
                    $value['etype'] = $typeInfo->TypeId;
                    self::registerChildParentObj($className, $class, $serializeMap);
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function registerChildParentObj($parentClassName, $child, &$serializeMap = '')
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
                TypeHelper::GetTypeIdV3($className);
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