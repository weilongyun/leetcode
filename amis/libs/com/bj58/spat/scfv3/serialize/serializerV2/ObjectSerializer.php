<?php
namespace com\bj58\spat\scf\serialize\serializerV2;

use com\bj58\spat\scf\serialize\component\SCFOutStream;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\serialize\component\helper\StrHelper;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\serialize\component\TypeMap;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\client\utility\LogHelper;

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
            SerializerFactory::GetSerializer(null)->WriteObject(null, $outStream);
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
            $keyField = $Fields[1];
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
            $outStream->WriteInt32($keyField['sortId']);
            if (null === $value) {
                SerializerFactory::GetSerializer(null, $initKeyObj)->WriteObject(null, $outStream);
            } else {
                SerializerFactory::GetSerializer(SCFType::STRING, $initKeyObj)->WriteObject($keyValue, $outStream);
            }
            $valueField = $Fields[2];
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
                $outStream->WriteInt32($valueField['sortId']);
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
                $sortId = $field['sortId'];
                if (null === $value) {
                    if (! TypeHelper::IsObject($valueTypeId) && ! TypeHelper::IsComplexType($valueTypeId) && $valueTypeId != SCFType::STRING) {
                        $outStream->WriteInt32($valueTypeId);
                        $outStream->WriteInt32($sortId);
                        SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream);
                    } else {
                        $outStream->WriteInt32(0);
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
                    $outStream->WriteInt32($sortId);
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

    public static function getTypeAndEType($valueType, $value)
    {
        $result = array();
        $etype = array();
        if (strstr($valueType, '<')) {
            $type = substr($valueType, 0, strpos($valueType, '<'));
            $valueType = substr($valueType, strpos($valueType, '<') + 1, strlen($valueType) - strlen($type) - 2);
            $typeId = TypeMap::getTypeId($type);
            if ($typeId === - 1) {
                $typeInfo = ObjectSerializer::GetTypeInfo($value);
                $typeId = $typeInfo->TypeId;
            }
            $result['type'] = $typeId;
            if ($typeId === SCFType::MAP) {
                if ($value != null) {
                    $current = current($value);
                    $evalue = array(
                        array_search($current, $value) => $current
                    );
                    $key = substr($valueType, strpos($valueType, 'key =') + 6, strpos($valueType, 'value =') - 8);
                    $value = substr($valueType, strpos($valueType, 'value =') + 8);
                    foreach ($evalue as $k => $v) {
                        $etype['ktype'] = self::getTypeAndEType($key, $k);
                        $etype['vtype'] = self::getTypeAndEType($value, $v);
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
                $etype['type'] = self::getTypeAndEType($valueType, $evalue);
                $result['elem'] = $etype['type'];
            }
        } else
            if (strstr($valueType, '[]')) {
                $valueType = substr($valueType, 0, strpos($valueType, '['));
                $evalue = $value[0];
                $result['type'] = SCFType::ARAY;
                $etype['type'] = self::getTypeAndEType($valueType, $evalue);
                $result['elem'] = $etype['type'];
            } else {
                $typeId = TypeMap::getTypeId($valueType);
                if ($typeId === - 1) {
                    $typeInfo = ObjectSerializer::GetTypeInfo($value);
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
        try {
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
            try {
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

                    $sortId = $inStream->ReadInt32();
                    $ptype = TypeHelper::GetType($ptypeId);
                    if (null === $ptype) {
                        throw new ScfException("Cannot find class with typId,target class: " . $field['type'] . ",typeId: " . $ptypeId);
                    }
                    $fieldValue = SerializerFactory::GetSerializer($ptypeId, $initKeyObj)->ReadObject($inStream, $field['type']);
                    if (null !== $fieldValue) {
                        $field = $fields[$sortId];
                        $methodName = 'set' . ucfirst($field['var']);
                        $ec = $class->getMethod($methodName);
                        $ec->invokeArgs($obj, array(
                            $fieldValue
                        ));
                    }
                }
            } catch (\Exception $e) {
                if ($typeId == 2100563169) {
                    $count = count($fields);
                    for ($i = $count - 1; $i >= 0; $i --) {
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

                        $sortId = $inStream->ReadInt32();
                        $ptype = TypeHelper::GetType($ptypeId, $initKeyObj);
                        if (null === $ptype) {
                            throw new ScfException("Cannot find class with typId,target class: " . $field['type'] . ",typeId: " . $ptypeId);
                        }
                        $fieldValue = SerializerFactory::GetSerializer($ptypeId, $initKeyObj)->ReadObject($inStream, $field['type']);
                        if (null !== $fieldValue) {
                            $field = $fields[$sortId];
                            $methodName = 'set' . ucfirst($field['var']);
                            $ec = $class->getMethod($methodName);
                            $ec->invokeArgs($obj, array(
                                $fieldValue
                            ));
                        }
                    }
                } else {
                    throw $e;
                }
            }
            return $obj;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @param TypeInfo $type
     */
    public static function GetTypeInfo($type, $initObj = '')
    {
        try {
            return Serializer::GetTypeInfo($type, $initObj);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
