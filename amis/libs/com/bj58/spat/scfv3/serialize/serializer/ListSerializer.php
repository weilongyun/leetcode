<?php
namespace com\bj58\spat\scf\serialize\serializer;

use com\bj58\spat\scf\serialize\serializer\SerializerBase;
use com\bj58\spat\scf\serialize\component\SCFOutStream;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\serialize\component\helper\StrHelper;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\exception\ScfException;

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
    public function WriteObject($obj, $outStream, $etype = null)
    {
        if (null === $obj) {
            SerializerFactory::GetSerializer(null)->WriteObject(null, $outStream);
        }
        $typeId = SCFType::LST;
        $outStream->WriteInt32($typeId);
        if ($outStream->WriteRef($obj)) {
            return;
        }
        $outStream->WriteInt32(count($obj));
        $initKeyObj = $this->getKey();
        foreach ($obj as $item) {
            if (null === $item) {
                $outStream->WriteInt32(0);
            } else {
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
                $outStream->WriteInt32($itemType);
                SerializerFactory::GetSerializer($itemType, $initKeyObj)->WriteObject($item, $outStream, $et);
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
            throw new ScfException("StreamException: Data length overflow.");
        }
        $type = TypeHelper::GetType($typeId);
        if (null === $type) {
            throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class: " . $defType . ",typeId:" . $typeId);
        }
        if ($type !== "List") {
            throw new ScfException("ClassNotMatchException: Class must be list! type: " . type);
        }
        $tempArray = array();
        for ($i = 0; $i < $len; $i ++) {
            $itemTypeId = $inStream->ReadInt32();
            if ($itemTypeId === 0) {
                $tempArray[] = null;
            } else {
                $itemType = TypeHelper::GetType($itemTypeId);
                if (null === $itemType) {
                    throw new ScfException("ClassNotFoundException: Cannot find class with typId,target class: " . $defType . ",typeId:" . $typeId);
                }
                $value = SerializerFactory::GetSerializer($itemTypeId)->ReadObject($inStream, $defType, $etype);
                $tempArray[] = $value;
            }
        }
        $inStream->SetRef($hashcode, $tempArray);
        return $tempArray;
    }
}