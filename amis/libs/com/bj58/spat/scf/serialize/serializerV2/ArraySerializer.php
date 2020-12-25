<?php
namespace com\bj58\spat\scf\serialize\serializerV2;

use com\bj58\spat\scf\serialize\serializerV2\SerializerBase;
use com\bj58\spat\scf\serialize\serializerV2\SerializerFactory;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\serialize\component\helper\ByteHelper;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\exception\ScfException;
class ArraySerializer extends SerializerBase
{

    /**
     *
     * @param unknown $obj
     * @param SCFOutStream $outStream
     */
    public function WriteObject($obj, $outStream, $etype = null)
    {
        if (null === $obj) {
            SerializerFactory::GetSerializer(null)->WriteObject(null, $outStream);
            return ;
        }
        $typeId = $etype['type'];
        $outStream->WriteInt32($typeId);
        if ($outStream->WriteRef($obj)) {
            return ;
        }

        $outStream->WriteInt32(count($obj));
        if (TypeHelper::IsPrimitive($typeId)) {
            if ($typeId === SCFType::CHAR) {
                foreach ($obj as $char) {
                    SerializerFactory::GetSerializer($typeId)->WriteObject($char, $outStream);
                }
                return ;
            } else if ($typeId === SCFType::I16) {
                foreach ($obj as $short) {
                    SerializerFactory::GetSerializer($typeId)->WriteObject($short, $outStream);
                }
                return ;
            } else if ($typeId === SCFType::I32) {
                foreach ($obj as $int) {
                    SerializerFactory::GetSerializer($typeId)->WriteObject($int, $outStream);
                }
                return ;
            } else if ($typeId === SCFType::FLOAT) {
                foreach ($obj as $float) {
                    SerializerFactory::GetSerializer($typeId)->WriteObject($float, $outStream);
                }
                return ;
            } else if ($typeId === SCFType::I64) {
                foreach ($obj as $long) {
                    SerializerFactory::GetSerializer($typeId)->WriteObject($long, $outStream);
                }
                return ;
            } else if ($typeId === SCFType::DOUBLE) {
                foreach ($obj as $double) {
                    SerializerFactory::GetSerializer($typeId)->WriteObject($double, $outStream);
                }
                return ;
            } else if ($typeId === SCFType::BOOL) {
                foreach ($obj as $bool) {
                    SerializerFactory::GetSerializer($typeId)->WriteObject($bool, $outStream);
                }
                return ;
            } else if ($typeId === SCFType::BYTE) {
                foreach ($obj as $byte) {
                    SerializerFactory::GetSerializer($typeId)->WriteObject($byte, $outStream);
                }
                $outStream->write($obj);
                return ;
            }
        }

        foreach ($obj as $item) {
            if (null === $item) {
                SerializerFactory::GetSerializer(null)-> WriteObject(null, $outStream);
            } else {
                if ($etype === null) {
                    $itemType = get_class($item);
                    if (!$itemType) {
                        $itemType = gettype($item);
                    }
                    $itemTypeId = TypeHelper::GetTypeId($itemType);
                    $elem = null;
                } else {
                    $itemTypeId = $etype['type'];
                    if(array_key_exists('elem', $etype)) {
                        $elem = $etype['elem'];
                    } else {
                        $elem = null;
                    }
                }
                $outStream->WriteInt32($itemTypeId);
                SerializerFactory::GetSerializer($itemTypeId)->WriteObject($item, $outStream, $elem);
            }
        }
    }

    /**
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
            throw new ScfException("StreamException: Data length overflow.");
        }
        $type = TypeHelper::GetType($typeId);
        if (null === $type) {
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
                for ($i = 0; $i < $len; $i++) {
                    $data = $inStream->ReadInt16();
                    $buffer = ByteHelper::GetBytesFromInt16($data);
                    $tempArray[] = ByteHelper::GetCharFromBytes($buffer);
                }
                return $tempArray;
            } else if ($type === "short") {
                for ($i = 0; $i < $len; $i ++) {
                    $shortValue = $inStream->ReadInt16();
                    $tempArray[] = $shortValue;
                }
                return $tempArray;
            } else if ($type === "long") {
                for ($i = 0; $i < $len; $i ++) {
                    $longValue = $inStream->ReadInt64();
                    $tempArray[] = $longValue;
                }
                return $tempArray;
            } else if ($type === "int") {
                for ($i = 0; $i < $len; $i ++) {
                    $intValue = $inStream->ReadInt32();
                    $tempArray[] = $intValue;
                }
                return $tempArray;
            } else if ($type === "boolean") {
                for ($i = 0; $i < $len; $i ++) {
                    $tempArray[] = $inStream->read(1) > 0;
                }
                return $tempArray;
            } else if ($type === "byte") {
                for ($i = 0; $i < $len; $i ++) {
                    $tempArray[] = $inStream->read(1);
                }
                return $tempArray;
            } else if ($type === "double") {
                for ($i = 0; $i < $len; $i ++) {
                    $doubleValue = SerializerFactory::GetSerializer($typeId)->ReadObject($inStream, $defType);
                    $tempArray[] = $doubleValue;
                }
                return $tempArray;
            } else if ($type === "float") {
                for ($i = 0; $i < $len; $i ++) {
                    $floatValue = SerializerFactory::GetSerializer($typeId)->ReadObject($inStream, $defType);
                    $tempArray[] = $floatValue;
                }
                return $tempArray;
            }
        }
        for($i = 0; $i < $len; $i ++) {
            $itemTypeId = $inStream->ReadInt32();
            if ($itemTypeId === 0) {
                $tempArray[i] = null;
            } else {
                $itemType = TypeHelper::GetType($itemTypeId);
                if (null === $itemType) {
                    throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class:" . $defType . ",typeId:" . $typeId);
                }
                $value = SerializerFactory::GetSerializer($itemTypeId)->ReadObject($inStream, $defType);
                $tempArray[] = $value;
            }
        }
        $inStream->SetRef($hashcode, $tempArray);
        return $tempArray;
    }
}