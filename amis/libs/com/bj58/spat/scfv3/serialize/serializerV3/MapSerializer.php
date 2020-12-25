<?php
namespace com\bj58\spat\scf\serialize\serializerV3;

use com\bj58\spat\scf\serialize\serializerV3\SerializerBase;
use com\bj58\spat\scf\serialize\serializerV3\SerializerFactory;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\serialize\component\helper\StrHelper;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\serialize\component\SCFType;

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
    public function WriteObject($obj, $outStream, $etype = null, $generic = false)
    {
        if ($obj === null) {
            $outStream->WriteInt32();
            return;
        }
        $index = $outStream->getLength();
        $outStream->reservedLen(4);
        if ($outStream->WriteRef($obj)) {
            $outStream->writeObjLen($outStream->getLength() - $index - 4, $index);
            return;
        }
        $len = count($obj);
        $outStream->WriteInt32($len);
        if ($len == 0) {
            $outStream->writeObjLen($outStream->getLength() - $index - 4, $index);
            return;
        }

        $keyElem = null;
        $valueElem = null;
        $keyTypeId = 0;
        $valueTypeId = 0;

        $initKeyObj = $this->getKey();
        if ($generic) {
            foreach ($obj as $key => $value) {
                self::getKeyTypeId($key, $etype, $keyTypeId);
                $outStream->WriteInt32($keyTypeId);
                SerializerFactory::GetSerializer($keyTypeId, $initKeyObj)->WriteObject($key, $outStream, $keyElem);

                if (null == $value) {
                    $outStream->WriteInt32(0);
                } else {
                    self::getValueTypeId($etype, $value, $valueTypeId);
                    $outStream->WriteInt32($valueTypeId);
                    SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, $valueElem);
                }
            }
        } else {
            foreach ($obj as $key => $value) {
                if ($key != null) {
                    self::getKeyTypeId($key, $etype, $keyTypeId);
                }
                if ($value != null) {
                    $valueElem = self::getValueTypeId($etype, $value, $valueTypeId);
                    break;
                }
            }
            $outStream->WriteInt32($keyTypeId);
            $outStream->WriteInt32($valueTypeId);

            if ($valueTypeId == 0) {
                foreach ($obj as $key => $value) {
                    SerializerFactory::GetSerializer($keyTypeId, $initKeyObj)->WriteObject($key, $outStream, $keyElem);
                }
            } else {
                foreach ($obj as $key => $value) {
                    SerializerFactory::GetSerializer($keyTypeId, $initKeyObj)->WriteObject($key, $outStream, $keyElem);
                    SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->WriteObject($value, $outStream, $valueElem);
                }
            }
        }

        $len = $outStream->getLength() - $index - 4;
        $outStream->writeObjLen($len, $index);
    }

    public static function getKeyTypeId($key, $etype, &$keyTypeId)
    {
        if ($etype === null || $etype['key'] === null) {
            $keyType = gettype($key);
            if ($keyType === "object") {
                $class = get_class($key);
                $keyType = StrHelper::getEntityNameV3($class);
                $keyElem = null;
            }
        } else {
            $keyType = $etype['key']['type'];
            $keyElem = array_key_exists('elem', $etype['key']) ? $etype['key']['elem'] : null;
        }

        if (gettype($keyType) === 'string') {
            $keyTypeId = TypeHelper::GetTypeIdV3($keyType);
        } else {
            $keyTypeId = $keyType;
        }
        return $keyElem;
    }

    public static function getValueTypeId($etype, $value, &$valueTypeId)
    {
        if ($etype === null || $etype['value'] === null) {
            $valueType = gettype($value);
            if ($valueType === "object") {
                $class = get_class($value);
                $valueType = StrHelper::getEntityNameV3($class);
                $valueElem = null;
            }
        } else {
            $valueType = $etype['value']['type'];
            if ($valueType == SCFType::OBJECT) {
                $valueElem = array_key_exists('elem', $etype['value']) ? $etype['value']['elem'] : null;
                if ($valueElem == null) {
                    $valueElem = $etype;
                }
            } else {
                $valueElem = array_key_exists('elem', $etype['value']) ? $etype['value']['elem'] : null;
            }
        }

        if (gettype($valueType) === 'string') {
            $valueTypeId = TypeHelper::GetTypeIdV3($valueType);
        } else {
            $valueTypeId = $valueType;
        }
        return $valueElem;
    }

    /**
     *
     * @param SCFInStream $inStream
     * @see \serialize\SerializerBase\SerializerBase::ReadObject()
     */
    public function ReadObject($inStream, $defType, $etype = null, $generic = false)
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
        $tempArray = array();
        if ($len == 0) {
            $inStream->SetRef($hashcode, $tempArray);
            return $tempArray;
        }

        $initKeyObj = $this->getKey();
        if ($generic) {
            for ($i = 0; $i < $len; $i ++) {
                $keyTypeId = $inStream->ReadInt32();
                $keyType = TypeHelper::GetTypeV3($keyTypeId);
                if (-1 == $keyType) {
                    throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class:map[key] ,type:" . $keyType);
                }
                $key = SerializerFactory::GetSerializer($keyTypeId, $initKeyObj)->ReadObject($inStream, $keyType);

                $valueTypeId = $inStream->ReadInt32();
                if ($valueTypeId == 0) {
                    $value = null;
                } else {
                    $valueType = TypeHelper::GetTypeV3($valueTypeId);
                    if (-1 == $valueType) {
                        throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class:map[][value] ,type:" . $valueType);
                    }
                    $value = SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->ReadObject($inStream, $valueType);
                }
                $tempArray[$key] = $value;
            }
        } else {
            $keyTypeId = $inStream->ReadInt32();
            $keyType = TypeHelper::GetTypeV3($keyTypeId);
            if (-1 == $keyType) {
                throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class:map[key] ,type:" . $keyType);
            }

            $valueTypeId = $inStream->ReadInt32();
            $valueType = TypeHelper::GetTypeV3($valueTypeId);
            if (-1 == $valueType) {
                throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class:map[][value] ,type:" . $valueType);
            }

            if ($valueTypeId == 0) {
                for ($i = 0; $i < $len; $i ++) {
                    $key = SerializerFactory::GetSerializer($keyTypeId, $initKeyObj)->ReadObject($inStream, $keyType);
                    $tempArray[$key] = null;
                }
            } else {
                for ($i = 0; $i < $len; $i ++) {
                    $key = SerializerFactory::GetSerializer($keyTypeId, $initKeyObj)->ReadObject($inStream, $keyType);
                    $value = SerializerFactory::GetSerializer($valueTypeId, $initKeyObj)->ReadObject($inStream, $valueType);
                    $tempArray[$key] = $value;
                }
            }
        }

        $inStream->SetRef($hashcode, $tempArray);
        return $tempArray;
    }
}