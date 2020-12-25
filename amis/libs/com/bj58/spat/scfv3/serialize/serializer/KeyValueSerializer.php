<?php
namespace com\bj58\spat\scf\serialize\serializer;

use com\bj58\spat\scf\serialize\serializer\SerializerBase;
use com\bj58\spat\scf\serialize\serializer\SerializerFactory;
use com\bj58\spat\scf\serialize\classes\GKeyValuePair;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\exception\ScfException;

class KeyValueSerializer extends SerializerBase
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
     * @param GKeyValuePair $obj
     * @param SCFOutStream $outStream
     * @see \serialize\SerializerBase\SerializerBase::WriteObject()
     */
    public function WriteObject($obj, $outStream, $etype = null)
    {
        if (null === $obj) {
            SerializerFactory::GetSerializer(null)->WriteObject(null, $outStream);
        }
        // $type = get_class($obj);
        $typeId = SCFType::GKEYVALUEPAIR;
        $outStream->WriteInt32($typeId);
        if ($outStream->WriteRef($obj)) {
            return;
        }
        $key = $obj->getKey();
        $value = $obj->getValue();
        if (null === $etype) {
            $itemKeyTypeId = $key;
        } else
            if ($etype['key'] === null) {
                $itemKeyType = gettype($key);
                if ($itemKeyType === "object") {
                    $itemKeyType = get_class($key);
                }
            } else {
                $itemKeyType = $etype['key'];
            }
        $itemKeyTypeId = TypeHelper::GetTypeId($itemKeyType);
        $outStream->WriteInt32($itemKeyTypeId);
        SerializerFactory::GetSerializer($itemKeyTypeId)->WriteObject($key, $outStream);

        if (null === $value) {
            SerializerFactory::GetSerializer(null)->WriteObject(null, $outStream);
        } else {
            if (null === $etype) {
                $itemValueType = gettype($value);
                if ($itemValueType === "object") {
                    $itemValueType = get_class($value);
                }
            } else
                if ($etype['value'] === null) {
                    $itemValueType = gettype($value);
                    if ($itemValueType === "object") {
                        $itemValueType = get_class($value);
                    }
                } else {
                    $itemValueType = $etype['value'];
                }
            $itemValueTypeId = TypeHelper::GetTypeId($itemValueType);
            $outStream->WriteInt32($itemValueTypeId);
            SerializerFactory::GetSerializer($itemValueTypeId)->WriteObject($value, $outStream);
        }
    }

    /**
     *
     * @param SCFInStream $inStream
     * @see \serialize\SerializerBase\SerializerBase::ReadObject()
     */
    public function ReadObject($inStream, $defType, $etype = null)
    {
        $typeId = $inStream->ReadInt32();
        if ($typeId === 0) {
            return null;
        }
        $isRef = $inStream->ReadByte();
        $hashcode = $inStream->ReadInt32();
        if ($isRef > 0) {
            return $inStream->GetRef($hashcode);
        }
        $itemKeyTypeId = $inStream->ReadInt32();
        $itemKeyType = TypeHelper::GetType($itemKeyTypeId);
        if (null === $itemKeyType) {
            throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class:KeyValue[key]" + ",typeId:" + $itemKeyTypeId);
        }
        $key = SerializerFactory::GetSerializer($itemKeyTypeId)->ReadObject($inStream, $itemKeyType);

        $itemValueTypeId = $inStream->ReadInt32();
        $value = null;
        if ($itemValueTypeId !== 0) {
            $itemValueType = TypeHelper::GetType($itemValueTypeId);
            if (null === $itemKeyType) {
                throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class:KeyValue[value]" + ",typeId:" + $itemValueTypeId);
            }
            $value = SerializerFactory::GetSerializer($itemValueTypeId)->ReadObject($inStream, $itemValueType);
        }
        $kv = new GKeyValuePair($key, $value);
        $inStream->SetRef($hashcode, $kv);
        return $kv;
    }
}