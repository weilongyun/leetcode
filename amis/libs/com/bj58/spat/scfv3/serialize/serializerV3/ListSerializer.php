<?php
namespace com\bj58\spat\scf\serialize\serializerV3;

use com\bj58\spat\scf\serialize\serializerV3\SerializerBase;
use com\bj58\spat\scf\serialize\component\SCFOutStream;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\serialize\component\helper\StrHelper;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\serialize\component\SCFType;

class ListSerializer extends SerializerBase
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
            $outStream->WriteInt32(0);
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
        $itemTypeId = 0;
        $et = null;
        foreach ($obj as $item) {
            if ($item != null) {
                if ($etype === null) {
                    $itemType = gettype($item);
                    $itemTypeId = TypeHelper::GetTypeIdV3($itemType);
                } else {
                    $itemType = $etype['type'];
                    if ($itemType == SCFType::MAP) {
                        $et = $etype;
                    } else {
                        $et = array_key_exists('elem', $etype) ? $etype['elem'] : null;
                    }
                    $itemTypeId = $itemType;
                }
                if (TypeHelper::IsObject($itemType) || $itemType === 'object') {
                    $class = get_class($item);
                    $itemType = StrHelper::getEntityNameV3($class);
                    $itemTypeId = TypeHelper::GetTypeIdV3($itemType);
                }
                break;
            }
        }

        $initKeyObj = $this->getKey();
        if ($generic) {
            foreach ($obj as $item) {
                if ($item == null) {
                    $outStream->WriteInt32(0);
                } else {
                    $outStream->WriteInt32($itemTypeId);
                    SerializerFactory::GetSerializer($itemTypeId, $initKeyObj)->WriteObject($item, $outStream, $et);
                }
            }
        } else {
            $outStream->WriteInt32($itemTypeId);
            if ($itemTypeId != 0) {
                foreach ($obj as $item) {
                    SerializerFactory::GetSerializer($itemTypeId, $initKeyObj)->WriteObject($item, $outStream, $et);
                }
            }
        }
        $len = $outStream->getLength() - $index - 4;
        $outStream->writeObjLen($len, $index);
    }

    public static function getItemType($etype, $item, &$itemType)
    {
        $et = null;
        if ($etype === null) {
            $itemType = gettype($item);
        } else {
            $itemType = $etype['type'];
            $et = array_key_exists('elem', $etype) ? $etype['elem'] : null;
        }
        if (TypeHelper::IsObject($itemType) || $itemType === 'object') {
            $class = get_class($item);
            $realName = '';
            $type = StrHelper::getEntityName($class, $realName);
            $itemType = TypeHelper::GetTypeId($type, $realName);
        }
        return $et;
    }

    /**
     *
     * @param SCFInStream $inStream
     * @see \serialize\SerializerBase\SerializerBase::ReadObject()
     */
    public function ReadObject($inStream, $defType, $etype = null, $generic = false)
    {
        $totalLen = $inStream->ReadInt32();
        if ($totalLen === 0) {
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
        $tempArray = array();
        if ($len == 0) {
            $inStream->SetRef($hashcode, $tempArray);
            return $tempArray;
        }

        $initKeyObj = $this->getKey();
        if ($generic) {
            for ($i = 0; $i < $len; $i ++) {
                $typeId = $inStream->ReadInt32();
                $type = TypeHelper::GetTypeV3($typeId);
                if ($type == - 1 || $type == null) {
                    throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class: " . $defType . ",typeId:" . $typeId);
                }
                if($typeId == 0) {
                    $value = null;
                } else {
                    $value = SerializerFactory::GetSerializer($typeId, $initKeyObj)->ReadObject($inStream, $type, $etype);
                }
                $tempArray[] = $value;
            }
        } else {
            $typeId = $inStream->ReadInt32();
            if ($typeId == 0) {
                for ($i = 0; $i < $len; $i ++) {
                    $tempArray[] = null;
                }
            } else {
                $type = TypeHelper::GetTypeV3($typeId);
                if ($type == - 1 || $type == null) {
                    throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class: " . $defType . ",typeId:" . $typeId);
                }

                for ($i = 0; $i < $len; $i ++) {
                    $value = SerializerFactory::GetSerializer($typeId, $initKeyObj)->ReadObject($inStream, $type, $etype);
                    $tempArray[] = $value;
                }
            }
        }

        $inStream->SetRef($hashcode, $tempArray);
        return $tempArray;
    }
}