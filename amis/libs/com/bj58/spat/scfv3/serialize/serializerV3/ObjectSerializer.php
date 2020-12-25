<?php
namespace com\bj58\spat\scf\serialize\serializerV3;

use com\bj58\spat\scf\serialize\component\SCFOutStream;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\serialize\component\helper\StrHelper;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\client\utility\LogHelper;
use com\bj58\spat\scf\serialize\component\TypeMapV3;
use com\bj58\spat\scf\serialize\component\helper\SCFTypeFormat;
use com\bj58\spat\scf\serialize\component\helper\FieldTypeHelper;

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
    public function WriteObject($obj, $outStream, $etype = null, $generic = false)
    {
        if (null === $obj) {
            $outStream->WriteInt32(0);
            return;
        }
        $index = $outStream->getLength();
        $outStream->reservedLen(4);
        if ($outStream->WriteRef($obj)) {
            $outStream->WriteInt32(TypeMapV3::ENDTYPE);
            $outStream->writeObjLen($outStream->getLength() - $index - 4, $index);
            return;
        }
        $type = get_class($obj);
        if (! $type) {
            throw new ScfException("not a object");
        }

        $initKeyObj = $this->getKey();
        try {
            $typeInfo = self::GetTypeInfo($type, $initKeyObj);
        } catch (\Exception $e) {
            LogHelper::logErrorMsgException($e);
            throw $e;
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
            $keyOrderId = $keyField['orderId'];
            if (null === $value) {
                $outStream->writeTag($keyOrderId, SCFTypeFormat::SCFTYPE_NULL);
            } else {
                $outStream->writeTag($keyOrderId, SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED);
                SerializerFactory::GetSerializer(SCFType::STRING, $initKeyObj)->WriteObject($keyValue, $outStream);
            }

            $valueField = $Fields[1];
            $valueOrderId = $valueField['orderId'];
            $valueType = $value;
            $methodName = 'get' . ucfirst($valueField['var']);
            $class = new \ReflectionClass($obj);
            $ec = $class->getMethod($methodName);
            $value = $ec->invoke($obj);
            $elem = null;
            if (null === $value) {
                $valueTypeId = '';
                $defaultValue = TypeHelper::GetBasicPrimitiveTypeValueByType($valueType, $valueTypeId);
                if ($defaultValue == - 1) {
                    $outStream->writeTag($valueOrderId, SCFTypeFormat::SCFTYPE_NULL);
                } else {
                    $outStream->writeTag($valueOrderId, FieldTypeHelper::getFieldType($valueTypeId));
                    $tempIndex = $outStream->getLength();
                    $outStream->reservedLen(4);
                    $outStream->WriteInt32($valueTypeId);
                    SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($defaultValue, $outStream, $elem);
                    $outStream->writeObjLen($outStream->getLength() - $tempIndex - 4, $tempIndex);
                }
            } else {
                $res = self::getTypeAndEType($valueType, $value, $initKeyObj);
                $valueTypeId = $res['type'];
                $outStream->writeTag($valueOrderId, FieldTypeHelper::getFieldType($valueTypeId));
                $tempIndex = $outStream->getLength();
                $outStream->reservedLen(4);
                $outStream->WriteInt32($valueTypeId);
                if (TypeHelper::IsComplexType($valueTypeId)) {
                    SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, array_key_exists('elem', $res) ? $res['elem'] : null, true);
                } else {
                    SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, $valueTypeId, true);
                }
                $outStream->writeObjLen($outStream->getLength() - $tempIndex - 4, $tempIndex);
            }
        } else {
            foreach ($Fields as $field) {
                $methodName = 'get' . ucfirst($field['var']);
                $class = new \ReflectionClass($obj);
                $ec = $class->getMethod($methodName);
                $value = $ec->invoke($obj);
                $valueTypeId = $field['type'];
                $orderId = $field['orderId'];
                $isGeneric = $field['isGeneric'];
                $elem = null;
                if (null === $value) {
                    $defaultValue = TypeHelper::GetBasicPrimitiveTypeValue($valueTypeId);
                    if ($defaultValue == - 1) {
                        $outStream->writeTag($orderId, SCFTypeFormat::SCFTYPE_NULL);
                    } else {
                        $outStream->writeTag($orderId, FieldTypeHelper::getFieldType($valueTypeId, $isGeneric));
                        SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($defaultValue, $outStream, $elem);
                    }
                } else {
                    if (TypeHelper::IsObject($valueTypeId)) {
                        if (is_object($value)) {
                            $className = StrHelper::getEntityNameV3($value);
                        } else {
                            if (array_key_exists('elem', $field)) {
                                $temp = $field['elem'];
                                $className = StrHelper::getEntityNameV3($temp['class']);
                            }
                        }
                        $valueTypeId = TypeHelper::GetTypeIdV3($className);
                    }
                    $outStream->writeTag($orderId, FieldTypeHelper::getFieldType($valueTypeId, $isGeneric));
                    if (TypeHelper::IsComplexType($valueTypeId)) {
                        if ($valueTypeId == SCFType::MAP) {
                            $elem = array(
                                'key' => $field['key'],
                                'value' => $field['value']
                            );
                        } else {
                            $elem = array_key_exists('elem', $field) ? $field['elem'] : null;
                        }
                        if ($isGeneric) {
                            $tempIndex = $outStream->getLength();
                            $outStream->reservedLen(4);
                            $outStream->WriteInt32($valueTypeId);
                            SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, $elem);
                            $outStream->writeObjLen($outStream->getLength() - $tempIndex - 4, $tempIndex);
                        } else {
                            SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, $elem);
                        }
                    } else {
                        if ($isGeneric) {
                            $tempIndex = $outStream->getLength();
                            $outStream->reservedLen(4);
                            $outStream->WriteInt32($valueTypeId);
                            SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, $valueTypeId);
                            $outStream->writeObjLen($outStream->getLength() - $tempIndex - 4, $tempIndex);
                        } else {
                            SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, $valueTypeId);
                        }
                    }
                }
            }
        }
        $outStream->WriteInt32(TypeMapV3::ENDTYPE);
        $outStream->writeObjLen($outStream->getLength() - $index - 4, $index);
    }

    public static function getTypeAndEType($valueType, $value)
    {
        $result = array();
        $etype = array();
        if (strstr($valueType, '<')) {
            $type = substr($valueType, 0, strpos($valueType, '<'));
            $valueType = substr($valueType, strpos($valueType, '<') + 1, strlen($valueType) - strlen($type) - 2);
            $typeId = TypeMapV3::getTypeIdV3($type);
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
                if (empty($value)) {
                    $evalue = NULL;
                } else {
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
                $typeId = TypeMapV3::getTypeIdV3($valueType);
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
    public function ReadObject($inStream, $defType, $etype = null, $generic = false)
    {
        try {
            $initKeyObj = $this->getKey();
            $totalLen = $inStream->ReadInt32();
            if ($totalLen == 0) {
                return null;
            }
            $isRef = $inStream->ReadByte();
            $hashcode = $inStream->ReadInt32();
            if ($isRef > 0) {
                return $inStream->GetRef($hashcode);
            }
            $typeInfo = $this->GetTypeInfo($defType, $initKeyObj);
            $class = new \ReflectionClass($defType);
            $obj = $class->newInstance();
            $fields = $typeInfo->Fields;
            $tag = $inStream->ReadInt32();
            $num = 0;
            $fieldLen = count($fields);
            while ($tag != TypeMapV3::ENDTYPE) {
                if (strlen($inStream->getBuf()) === 0 || $inStream === null) {
                    break;
                }
                $orderId = SCFTypeFormat::getTagOrderId($tag);
                if ($num < $fieldLen) {
                    $field = $fields[$num];
                    if ($orderId == $field['orderId']) {
                        if (SCFTypeFormat::getTagSCFType($tag) == SCFTypeFormat::SCFTYPE_NULL) {
                            $methodName = 'set' . ucfirst($field['var']);
                            $ec = $class->getMethod($methodName);
                            $ec->invokeArgs($obj, array(
                                null
                            ));
                        } else {
                            $isGeneric = $field['isGeneric'];
                            if ($isGeneric) {
                                $inStream->ReadInt32();
                                $ptypeId = $inStream->ReadInt32();
                                $ptype = TypeHelper::GetTypeV3($ptypeId);
                                $fieldValue = SerializerFactory::GetSerializer($ptypeId, $initKeyObj)->ReadObject($inStream, $ptype, $etype, true);
                            } else {
                                $ptypeId = $field['type'];
                                if ($ptypeId == SCFType::OBJECT) {
                                    try {
                                        $ptype = $field['elem']['class'];
                                        $ptype = StrHelper::getEntityNameV3($ptype);
                                        $ptypeId = TypeHelper::GetTypeIdV3($ptype);
                                    } catch (\Exception $e) {
                                        throw new ScfException(__CLASS__ . " in line " . __LINE__ . "cannot analysis " . $field['var'] . " cause " . $e->getMessage());
                                    }
                                } else {
                                    $ptype = TypeHelper::GetTypeV3($ptypeId);
                                }
                                $fieldValue = SerializerFactory::GetSerializer($ptypeId, $initKeyObj)->ReadObject($inStream, $ptype);//$field['type']
                            }
                            $methodName = 'set' . ucfirst($field['var']);
                            $ec = $class->getMethod($methodName);
                            $ec->invokeArgs($obj, array(
                                $fieldValue
                            ));
                        }
                        $num ++;
                        $tag = $inStream->ReadInt32();
                    } else {
                        if ($orderId > $field['orderId']) {
                            $num ++;
                        } else {
                            FieldTypeHelper::readUnknownField($tag, $inStream);
                            $tag = $inStream->ReadInt32();
                        }
                    }
                } else {
                    FieldTypeHelper::readUnknownField($tag, $inStream);
                    $tag = $inStream->ReadInt32();
                }
            }
            $inStream->SetRef($hashcode, $obj);
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
            return SerializerV3::GetTypeInfo($type, $initObj);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
