<?php
namespace com\bj58\spat\scf\serialize\serializerV3;

use com\bj58\spat\scf\serialize\serializerV3\SerializerBase;
use com\bj58\spat\scf\serialize\serializerV3\SerializerFactory;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\serialize\component\helper\ByteHelper;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\exception\ScfException;

class ArraySerializer extends SerializerBase
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
     * @param unknown $obj
     * @param SCFOutStream $outStream
     */
    public function WriteObject($obj, $outStream, $etype = null, $generic = false)
    {
        if ($obj === null) {
            $outStream->WriteInt32(0);
            return;
        }
        $index = $outStream->getLength();
        $outStream->reservedLen(4);
        if ($outStream->WriteRef($obj)) {
            $outStream->writeObjLen($outStream->getLength - $index - 4, $index);
            return;
        }
        $initKeyObj = $this->getKey();
        $typeId = $etype['type'];
        if ($typeId == SCFType::OBJECT) {
            $elem = $etype['class'];
            $typeId = SerializerV3::GetTypeInfo($elem, $initKeyObj)->TypeId;
        }
        $outStream->WriteInt32($typeId);
        $outStream->WriteInt32(count($obj));

        if (TypeHelper::IsBasicPrimitiveType($typeId)) {
            switch ($typeId) {
                case SCFType::BCHAR:
                    foreach ($obj as $char) {
                        SerializerFactory::GetSerializer($typeId)->WriteObject($char, $outStream);
                    }
                    $len = $outStream->getLength() - $index - 4;
                    $outStream->writeObjLen($len, $index);
                    return;
                case SCFType::BSHORT:
                    foreach ($obj as $short) {
                        SerializerFactory::GetSerializer($typeId)->WriteObject($short, $outStream);
                    }
                    $len = $outStream->getLength() - $index - 4;
                    $outStream->writeObjLen($len, $index);
                    return;
                case SCFType::BINT:
                    foreach ($obj as $int) {
                        SerializerFactory::GetSerializer($typeId)->WriteObject($int, $outStream);
                    }
                    $len = $outStream->getLength() - $index - 4;
                    $outStream->writeObjLen($len, $index);
                    return;
                case SCFType::BFLOAT:
                    foreach ($obj as $float) {
                        SerializerFactory::GetSerializer($typeId)->WriteObject($float, $outStream);
                    }
                    $len = $outStream->getLength() - $index - 4;
                    $outStream->writeObjLen($len, $index);
                    return;
                case SCFType::BLONG:
                    foreach ($obj as $long) {
                        SerializerFactory::GetSerializer($typeId)->WriteObject($long, $outStream);
                    }
                    $len = $outStream->getLength() - $index - 4;
                    $outStream->writeObjLen($len, $index);
                    return;
                case SCFType::BDOUBLE:
                    foreach ($obj as $double) {
                        SerializerFactory::GetSerializer($typeId)->WriteObject($double, $outStream);
                    }
                    $len = $outStream->getLength() - $index - 4;
                    $outStream->writeObjLen($len, $index);
                    return;
                case SCFType::BBOOL:
                    foreach ($obj as $bool) {
                        SerializerFactory::GetSerializer($typeId)->WriteObject($bool, $outStream);
                    }
                    $len = $outStream->getLength() - $index - 4;
                    $outStream->writeObjLen($len, $index);
                    return;
                case SCFType::BBYTE:
                    foreach ($obj as $byte) {
                        SerializerFactory::GetSerializer($typeId)->WriteObject($byte, $outStream);
                    }
                    $len = $outStream->getLength() - $index - 4;
                    $outStream->writeObjLen($len, $index);
                    return;

                default:
                    ;
                    break;
            }
        }

        $initKeyObj = $this->getKey();
        $itemTypeId = '';
        if (TypeHelper::IsPrimitive(TypeHelper::GetType($typeId))) {
            foreach ($obj as $item) {
                if (null === $item) {
                    throw new ScfException('basic type in array can not null!');
                } else {
                    $elem = self::getItemTypeId($item, $etype, $itemTypeId);
                    SerializerFactory::GetSerializer($itemTypeId, $initKeyObj)->WriteObject($item, $outStream, $elem);
                }
            }
        } else {
            if ($generic) {
                foreach ($obj as $item) {
                    if (null === $item) {
                        $outStream->WriteInt32(0);
                    } else {
                        $elem = self::getItemTypeId($item, $etype, $itemTypeId);
                        $outStream->WriteInt32($itemTypeId);
                        SerializerFactory::GetSerializer($itemTypeId, $initKeyObj)->WriteObject($item, $outStream, $elem);
                    }
                }
            } else {
                foreach ($obj as $item) {
                    if (null === $item) {
                        $outStream->WriteInt32(0);
                    } else {
                        $elem = self::getItemTypeId($item, $etype, $itemTypeId);
                        SerializerFactory::GetSerializer($itemTypeId, $initKeyObj)->WriteObject($item, $outStream, $elem);
                    }
                }
            }
        }

        $len = $outStream->getLength() - $index - 4;
        $outStream->writeObjLen($len, $index);
    }

    public static function getItemTypeId($item, $etype, &$itemTypeId)
    {
        if ($etype === null) {
            $itemType = get_class($item);
            if (! $itemType) {
                $itemType = gettype($item);
            }
            $itemTypeId = TypeHelper::GetTypeId($itemType);
            $elem = null;
        } else {
            $itemTypeId = $etype['type'];
            if (array_key_exists('elem', $etype)) {
                $elem = $etype['elem'];
            } else {
                $elem = null;
            }
        }
        return $elem;
    }

    /**
     *
     * @param SCFInStream $inStream
     * @see \serialize\SerializerBase\SerializerBase::ReadObject()
     */
    public function ReadObject($inStream, $defType, $etype = null, $generic = false)
    {
        $totalLen = $inStream->ReadInt32();
        if ($totalLen == 0) {
            return null;
        }
        $isRef = $inStream->ReadByte();
        $hashcode = $inStream->ReadInt32();
        if ($isRef > 0) {
            return $inStream->GetRef($hashcode);
        }
        $typeId = $inStream->ReadInt32();
        $len = $inStream->ReadInt32();
        if ($len > SCFInStream::$MAX_DATA_LEN) {
            throw new ScfException("StreamException: Data length overflow.");
        }
        $type = TypeHelper::GetTypeV3($typeId);
        if ($type == - 1) {
            throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class:" . $defType . ",typeId:" . $typeId);
        }
        if ($type === "byte") {
            $buffer = $inStream->read($len);
            $buffer = unpack('c*', $buffer);
            return $buffer;
        }
        $tempArray = array();
        if (TypeHelper::IsPrimitive($typeId)) {
            if ($type === "char") {
                for ($i = 0; $i < $len; $i ++) {
                    $data = $inStream->ReadInt16();
                    $buffer = ByteHelper::GetBytesFromInt16($data);
                    $tempArray[] = ByteHelper::GetCharFromBytes($buffer);
                }
                return $tempArray;
            } else
                if ($type === "short") {
                    for ($i = 0; $i < $len; $i ++) {
                        $shortValue = $inStream->ReadInt16();
                        $tempArray[] = $shortValue;
                    }
                    return $tempArray;
                } else
                    if ($type === "long") {
                        for ($i = 0; $i < $len; $i ++) {
                            $longValue = $inStream->ReadInt64();
                            $tempArray[] = $longValue;
                        }
                        return $tempArray;
                    } else
                        if ($type === "int") {
                            for ($i = 0; $i < $len; $i ++) {
                                $intValue = $inStream->ReadInt32();
                                $tempArray[] = $intValue;
                            }
                            return $tempArray;
                        } else
                            if ($type === "boolean") {
                                for ($i = 0; $i < $len; $i ++) {
                                    $tempArray[] = $inStream->read(1) > 0;
                                }
                                return $tempArray;
                            } else
                                if ($type === "byte") {
                                    for ($i = 0; $i < $len; $i ++) {
                                        $tempArray[] = $inStream->read(1);
                                    }
                                    return $tempArray;
                                } else
                                    if ($type === "double") {
                                        for ($i = 0; $i < $len; $i ++) {
                                            $doubleValue = SerializerFactory::GetSerializer($typeId)->ReadObject($inStream, $defType);
                                            $tempArray[] = $doubleValue;
                                        }
                                        return $tempArray;
                                    } else
                                        if ($type === "float") {
                                            for ($i = 0; $i < $len; $i ++) {
                                                $floatValue = SerializerFactory::GetSerializer($typeId)->ReadObject($inStream, $defType);
                                                $tempArray[] = $floatValue;
                                            }
                                            return $tempArray;
                                        }
        }

        $initKeyObj = $this->getKey();

        if ($generic) {
            for ($i = 0; $i < $len; $i ++) {
                $typeId = $inStream->ReadInt32();
                if ($typeId == 0) {
                    $value = null;
                } else {
//                     $type = TypeHelper::GetTypeV3($typeId);
//                     if ($type == - 1) {
//                         throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class:" . $defType . ",typeId:" . $typeId);
//                     }
                    $value = SerializerFactory::GetSerializer($typeId, $initKeyObj)->ReadObject($inStream, $type);
                }
                $tempArray[] = $value;
            }
        } else {
            for ($i = 0; $i < $len; $i ++) {
                $value = SerializerFactory::GetSerializer($typeId, $initKeyObj)->ReadObject($inStream, $type);
                $tempArray[] = $value;
            }
        }

        $inStream->SetRef($hashcode, $tempArray);
        return $tempArray;
    }
}