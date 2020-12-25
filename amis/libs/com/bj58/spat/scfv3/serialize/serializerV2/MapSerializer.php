<?php
namespace com\bj58\spat\scf\serialize\serializerV2;

use com\bj58\spat\scf\serialize\serializerV2\SerializerBase;
use com\bj58\spat\scf\serialize\serializerV2\SerializerFactory;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\serialize\component\helper\StrHelper;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\exception\ScfException;

class MapSerializer extends SerializerBase
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
        if (null === $obj) {
            SerializerFactory::GetSerializer(null)->WriteObject(null, $outStream);
        }
        $typeId = SCFType::MAP;
        $outStream->WriteInt32($typeId);
        if ($outStream->WriteRef($obj)) {
            return;
        }
        $outStream->WriteInt32(count($obj));
        $initKeyObj = $this->getKey();
        $keyElem = null;
        $valueElem = null;
        foreach ($obj as $key => $value) {
            if ($etype === null || $etype['key'] === null) {
                $keyType = gettype($key);
                if ($keyType === "object") {
                    $class = get_class($key);
                    $keyType = StrHelper::getEntityName($class);
                    $keyElem = null;
                }
            } else {
                $keyType = $etype['key']['type'];
                $keyElem = array_key_exists('elem', $etype['key']) ? $etype['key']['elem'] : null;
            }

            if (gettype($keyType) === 'string') {
                $keyTypeId = TypeHelper::GetTypeId($keyType);
            } else {
                $keyTypeId = $keyType;
            }
            $outStream->WriteInt32($keyTypeId);
            SerializerFactory::GetSerializer($keyTypeId, $initKeyObj)->WriteObject($key, $outStream, $keyElem);

            if (null === $value) {
                SerializerFactory::GetSerializer(null)->WriteObject(null, $outStream);
            } else {
                $realName = '';
                if ($etype === null || $etype['value'] === null) {
                    $valueType = gettype($value);
                    if ($valueType === "object") {
                        $class = get_class($value);
                        $valueType = StrHelper::getEntityName($class, $realName);
                        $valueElem = null;
                    }
                } else {
                    $valueType = $etype['value']['type'];
                    $valueElem = array_key_exists('elem', $etype['value']) ? $etype['value']['elem'] : null;
                }

                if (gettype($valueType) === 'string') {
                    $valueTypeId = TypeHelper::GetTypeId($valueType, $realName);
                } else {
                    $valueTypeId = $valueType;
                }
                $outStream->WriteInt32($valueTypeId);
                SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, $valueElem);
            }
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
        $len = $inStream->ReadInt32();
        if ($len > SCFInStream::$MAX_DATA_LEN) {
            throw new ScfException("Data length overflow.");
        }
        $type = TypeHelper::GetType($typeId);
        if (null === $type) {
            throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class:" . $defType . ",typeId:" . $typeId);
        }
        if ($type !== "Map") {
            throw new ScfException("ClassNotMatchException: Class must be list! type: " . type);
        }
        $tempArray = array();
        $initKeyObj = $this->getKey();
        for ($i = 0; $i < $len; $i ++) {
            $keyTypeId = $inStream->ReadInt32();
            $keyType = TypeHelper::GetType($keyTypeId);
            if (null === $keyType) {
                throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class:map[key] ,typeId:" . keyTypeId);
            }
            $key = SerializerFactory::GetSerializer($keyTypeId, $initKeyObj)->ReadObject($inStream, $keyType);

            $valueTypeId = $inStream->ReadInt32();
            $valueType = TypeHelper::GetType($valueTypeId);
            if ($valueType !== null) {
                $value = SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->ReadObject($inStream, $valueType);
            }
            $tempArray[$key] = $value;
        }
        $inStream->SetRef($hashcode, $tempArray);
        return $tempArray;
    }
}