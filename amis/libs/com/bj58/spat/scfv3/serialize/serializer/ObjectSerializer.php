<?php
namespace com\bj58\spat\scf\serialize\serializer;

use com\bj58\spat\scf\serialize\component\SCFOutStream;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\serialize\component\helper\StrHelper;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\serialize\component\TypeMap;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\client\utility\LogHelper;
use com\bj58\spat\scf\serialize\utility\EntityUtil;
use com\bj58\spat\scf\serialize\utility\SerializeApcuUtil;
use com\bj58\spat\scf\log\LogFactory;
use com\bj58\spat\scf\client\SCFInit;
use com\bj58\spat\scf\log\SCFNoLog;

class ObjectSerializer extends SerializerBase
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
        $initKeyObj = $this->getKey();
        if (null === $obj) {
            SerializerFactory::GetSerializer(null, $initKeyObj)->WriteObject(null, $outStream);
            return;
        }
        $type = get_class($obj);
        if (! $type) {
            throw new ScfException("not a object");
        }
        try {
            $typeInfo = self::GetTypeInfo($type, $initKeyObj);
        } catch (\Exception $e) {
            LogHelper::logErrorMsgException($e);
            throw $e;
        }
        $outStream->WriteInt32($typeInfo->TypeId);
        if ($outStream->WriteRef($obj)) {
            return;
        }
        $Fields = $typeInfo->Fields;
        if (strstr($type, "KeyValuePair")) {
            $keyField = $Fields[0];
            $methodName = 'get' . ucfirst($keyField['var']);
            $class = new \ReflectionClass($obj);
            $ec = $class->getMethod($methodName);
            $value = $ec->invoke($obj);
            if (strstr($value, 'key = ') || strstr($value, 'value = ')) {
                $keyValue = str_replace('key = ', '', $value);
                $keyValue = str_replace(' value = ', '', $keyValue);
            } else
                if (strstr($value, '[]') && strstr($value, 'List')) {
                    $keyValue = str_replace('[]', ';', $value);
                } else {
                    $keyValue = $value;
                }
            $outStream->WriteInt32(SCFType::STRING);
            if (null === $value) {
                SerializerFactory::GetSerializer(null, $initKeyObj)->WriteObject(null, $outStream);
            } else {
                SerializerFactory::GetSerializer(SCFType::STRING, $initKeyObj)->WriteObject($keyValue, $outStream);
            }
            $valueField = $Fields[1];
            $valueType = $value;
            $methodName = 'get' . ucfirst($valueField['var']);
            $class = new \ReflectionClass($obj);
            $ec = $class->getMethod($methodName);
            $value = $ec->invoke($obj);
            if (null === $value) {
                SerializerFactory::GetSerializer(null, $initKeyObj)->WriteObject(null, $outStream);
            } else {
                $res = self::getTypeAndEType($valueType, $value, $initKeyObj);
                $valueTypeId = $res['type'];
                $outStream->WriteInt32($valueTypeId);
                if (TypeHelper::IsComplexType($valueTypeId)) {
                    SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, array_key_exists('elem', $res) ? $res['elem'] : null);
                } else {
                    SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, $valueTypeId);
                }
            }
        } else {
            foreach ($Fields as $field) {
                $methodName = 'get' . ucfirst($field['var']);
                $class = new \ReflectionClass($obj);
                $ec = $class->getMethod($methodName);
                $value = $ec->invoke($obj);
                $valueTypeId = $field['type'];
                if (null === $value) {
                    if (! TypeHelper::IsObject($valueTypeId) && ! TypeHelper::IsComplexType($valueTypeId) && $valueTypeId != SCFType::STRING) {
                        $outStream->WriteInt32($valueTypeId);
                        SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream);
                    } else {
                        SerializerFactory::GetSerializer(null, $initKeyObj)->WriteObject(null, $outStream);
                    }
                } else {
                    if (TypeHelper::IsObject($valueTypeId)) {
                        $realName = '';
                        if (is_object($value)) {
                            $className = StrHelper::getEntityName($value, $realName);
                        } else {
                            if (array_key_exists('elem', $field)) {
                                $temp = $field['elem'];
                                $className = StrHelper::getEntityName($temp['class'], $realName);
                            }
                        }
                        $valueTypeId = TypeHelper::GetTypeId($className, $realName);
                    }
                    $outStream->WriteInt32($valueTypeId);
                    if (TypeHelper::IsComplexType($valueTypeId)) {
                        if ($valueTypeId == SCFType::MAP) {
                            $elem = array(
                                'key' => $field['key'],
                                'value' => $field['value']
                            );
                        } else {
                            $elem = array_key_exists('elem', $field) ? $field['elem'] : null;
                        }
                        SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, $elem);
                    } else {
                        SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, $valueTypeId);
                    }
                }
            }
        }
    }

    public static function getTypeAndEType($valueType, $value, $initObj = '')
    {
        $result = array();
        $etype = array();
        if (strstr($valueType, '<')) {
            $type = substr($valueType, 0, strpos($valueType, '<'));
            $valueType = substr($valueType, strpos($valueType, '<') + 1, strlen($valueType) - strlen($type) - 2);
            $typeId = TypeMap::getTypeId($type);
            if ($typeId === - 1) {
                $typeInfo = ObjectSerializer::GetTypeInfo($value, $initObj);
                $typeId = $typeInfo->TypeId;
            }
            $result['type'] = $typeId;
            if ($typeId === SCFType::MAP) {
                if (null != $value) {
                    $current = current($value);
                    $evalue = array(
                        array_search($current, $value) => $current
                    );
                    $key = substr($valueType, strpos($valueType, 'key =') + 6, strpos($valueType, 'value =') - 8);
                    $value = substr($valueType, strpos($valueType, 'value =') + 8);
                    foreach ($evalue as $k => $v) {
                        $etype['ktype'] = self::getTypeAndEType($key, $k, $initObj);
                        $etype['vtype'] = self::getTypeAndEType($value, $v, $initObj);
                        $result['elem']['key'] = $etype['ktype'];
                        $result['elem']['value'] = $etype['vtype'];
                    }
                }
            } else {
//                 $evalue = $value[0];
                if (empty($value)) {
                    $evalue = NULL;
                }else {
                    $evalue = $value[0];
                }
                $etype['type'] = self::getTypeAndEType($valueType, $evalue, $initObj);
                $result['elem'] = $etype['type'];
            }
        } else
            if (strstr($valueType, '[]')) {
                $valueType = substr($valueType, 0, strpos($valueType, '['));
                $evalue = $value[0];
                $result['type'] = SCFType::ARAY;
                $etype['type'] = self::getTypeAndEType($valueType, $evalue, $initObj);
                $result['elem'] = $etype['type'];
            } else {
                $typeId = TypeMap::getTypeId($valueType);
                if ($typeId === - 1) {
                    $typeInfo = ObjectSerializer::GetTypeInfo($value, $initObj);
                    $typeId = $typeInfo->TypeId;
                }
                $result['type'] = $typeId;
                $result['elem'] = null;
            }
        return $result;
    }

    /**
     *
     * @param SCFInStream $inStream
     * @see \serialize\SerializerBase\SerializerBase::ReadObject()
     */
    public function ReadObject($inStream, $defType, $etype = null)
    {
        $initKeyObj = $this->getKey();
        $typeId = $inStream->ReadInt32();
        if ($typeId === 0) {
            return null;
        }
        $type = TypeHelper::GetType($typeId);
        if (-1 == $type) {
            throw new ScfException("Cannot find class with typId,target class:" . $defType . ",typeId:" . $typeId);
        }
        $isRef = $inStream->ReadByte();
        $hashcode = $inStream->ReadInt32();
        if ($isRef > 0) {
            return $inStream->GetRef($hashcode);
        }
        $typeNameMap = @apcu_fetch('SCFTypeNameMap');
        if (null != $typeNameMap) {
            if (array_key_exists($type, $typeNameMap)) {
                $type = $typeNameMap[$type];
            }
        }
        $typeInfo = $this->GetTypeInfo($type, $initKeyObj);
        $class = new \ReflectionClass($type);
        $obj = $class->newInstance();
        $fields = $typeInfo->Fields;
        foreach ($fields as $field) {
            if (strlen($inStream->getBuf()) === 0 || $inStream === null) {
                break;
            }
            $ptypeId = $inStream->ReadInt32();
            if ($ptypeId === 0) {
                $methodName = 'set' . ucfirst($field['var']);
                $ec = $class->getMethod($methodName);
                $ec->invokeArgs($obj, array(
                    null
                ));
                continue;
            }

            $ptype = TypeHelper::GetType($ptypeId);
            if (null === $ptype) {
                throw new ScfException("Cannot find class with typId,target class: " . $field['type'] . ",typeId: " . $ptypeId);
            }
            $fieldValue = SerializerFactory::GetSerializer($ptypeId, $initKeyObj)->ReadObject($inStream, $field['type']);
            if (null !== $fieldValue) {
                $methodName = 'set' . ucfirst($field['var']);
                $ec = $class->getMethod($methodName);
                $ec->invokeArgs($obj, array(
                    $fieldValue
                ));
            }
        }
        return $obj;
    }

    private static $SCFTypeInfoMap = array();

    /**
     *
     * @param TypeInfo $type
     */
    public static function GetTypeInfo($type, $initObj = '')
    {
        try {
            if (LogFactory::getLog() === null) {
                SCFInit::InitLog(SCFNoLog::getInstance());
            }
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
                if (!empty($key)) {
                    if (SerializeApcuUtil::getTypeInfoMapByKey($key, $className, $sname, $serializeMap, $typeInfo, 'SCFV1')) {
                        return $typeInfo;
                    }
                } else {
                    if (SerializeApcuUtil::getTypeInfo($className, $sname, $typeInfo, 'SCFV1')) {
                        return $typeInfo;
                    }
                }
            } else {
                if (SerializeApcuUtil::getTypeInfo($className, $sname, $typeInfo, 'SCFV1')) {
                    return $typeInfo;
                }
            }

            $typeId = TypeHelper::GetTypeId($sname, $className);
            $typeInfo = new TypeInfo($typeId);
            $properties = array();
            $extends = false;
            while (true) {
                $pro = $typeClass->getProperty("_TSPEC");
                $superClass = $typeClass->getParentClass();
                $properties[] = $pro;
                if (false === $superClass) {
                    break;
                }
                $superClass->newInstanceArgs();
                $typeClass = $superClass;
                $extends = true;
            }
            $mapFields = array();
            if ($extends) {
                $indexIds = array();
                foreach ($properties as $protoerty) {
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
                            LogHelper::logWarnMsg("regist " . $className . " into SCFV1 enum map. current map is " . json_encode($temp));
                        } else {
                            if (array_key_exists('SCFTypeNameEnumMap', $serializeMap)) {
                                $SCFTypeNameEnumMap = $serializeMap['SCFTypeNameEnumMap'];
                                $SCFTypeNameEnumMap[$className] = $type;
                            } else {
                                $SCFTypeNameEnumMap = $GLOBALS['SCFTypeNameEnumMap'];
                            }
                            LogHelper::logWarnMsg("regist " . $className . " into SCFV1 enum map with key. key is " . $key . " current map is " . json_encode($SCFTypeNameEnumMap));
                        }
                        break;
                    }
                    foreach ($protoerty->getValue() as $value) {
                        $name = $value['var'];
                        if ($name[0] === "#") {
                            $indexId = 0x7fffffff;
                        } else {
                            $indexId = StrHelper::GetHashcode(strtolower($name));
                        }
                        $indexIds[] = $indexId;
                        if (! array_key_exists($indexId, $mapFields)) {
                            $mapFields[$indexId] = $value;
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
                }
                sort($indexIds);
                foreach ($indexIds as $id) {
                    array_push($typeInfo->Fields, $mapFields[$id]);
                }
            } else {
                foreach ($properties as $protoerty) {
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
                            LogHelper::logWarnMsg("regist " . $className . " into SCFV1 enum map. current map is " . json_encode($temp));
                        } else {
                            if (array_key_exists('SCFTypeNameEnumMap', $serializeMap)) {
                                $SCFTypeNameEnumMap = $serializeMap['SCFTypeNameEnumMap'];
                                $SCFTypeNameEnumMap[$className] = $type;
                            } else {
                                $SCFTypeNameEnumMap = $GLOBALS['SCFTypeNameEnumMap'];
                            }
                            LogHelper::logWarnMsg("regist " . $className . " into SCFV1 enum map with key. key is " . $key . " current map is " . json_encode($SCFTypeNameEnumMap));
                        }
                        break;
                    }
                    foreach ($values as $value) {
                        $name = $value['var'];
                        if ($name[0] === "#") {
                            $indexId = 0x7fffffff;
                        } else {
                            $indexId = StrHelper::GetHashcode(strtolower($name));
                        }

                        $mapFields[$indexId] = $value;
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
                ksort($mapFields);
                foreach ($mapFields as $f) {
                    array_push($typeInfo->Fields, $f);
                }
            }
            if (empty($key)) {
                SerializeApcuUtil::updateSerializeMap($className, $typeInfo, 'SCFV1');
                if (apcu_exists('SCFTypeNameMap')) {
                    $typeNameMap = apcu_fetch('SCFTypeNameMap');
                }
                $typeNameMap[$className] = $type;
                apcu_store('SCFTypeNameMap', $typeNameMap);
                $GLOBALS['SCFNameAliasesMap'][$sname] = $className;
                LogHelper::logWarnMsg("regist " . $className . " into SCFV1 entity map.");
                EntityUtil::registerEntity($type);
            } else {
                $serializeMap = SerializeApcuUtil::updateSerializeMapByKey($key, $className, $typeInfo, 'SCFV1');
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
                LogHelper::logWarnMsg("regist " . $className . " into SCFV1 entity map with key, key is " . $key);
                EntityUtil::registerEntity($type, $initObj);
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
                if (is_object($elem)) {
                    self::GetTypeInfo($elem, $initObj);
                    self::registerChildParentObj($className, $elem, $serializeMap);
                } else {
                    $class = $elem['class'];
                    if ($class !== 'this') {
                        self::GetTypeInfo($class, $initObj);
                        self::registerChildParentObj($className, $class, $serializeMap);
                    }
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function registerChildParentObj($parentClassName, $child, &$serializeMap = '')
    {
        if (empty($serializeMap)) {
            if (apcu_exists('SCFParentAndChildObj')) {
                $SCFParentAndChildObj = apcu_fetch('SCFParentAndChildObj');
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
            apcu_store('SCFParentAndChildObj', $SCFParentAndChildObj);
        } else {
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
                $serializeMap['SCFParentAndChildObj'] = $SCFParentAndChildObj;
            }
        }
    }

    public static function getChildObj($parentClassName, &$serializeMap = '')
    {
        if (empty($serializeMap)) {
            if (apcu_exists('SCFParentAndChildObj')) {
                $SCFParentAndChildObj = apcu_fetch('SCFParentAndChildObj');
                self::registerChildObj($SCFParentAndChildObj, $parentClassName);
            }
        } else {
            if (is_array($serializeMap) && array_key_exists('SCFParentAndChildObj', $serializeMap)) {
                $SCFParentAndChildObj = $serializeMap['SCFParentAndChildObj'];
                self::registerChildObj($SCFParentAndChildObj, $parentClassName);
            }
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
