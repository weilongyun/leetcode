<?php
namespace com\bj58\spat\scf\serialize\component\helper;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\serialize\component\TypeMapV3;
use com\bj58\spat\scf\exception\ScfException;
class FieldTypeHelper
{
    public static function getFieldType($typeId, $isGeneric = false) {
        if ($isGeneric) {
            return SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED;
        }
        if ($typeId == SCFType::ARAY || $typeId == SCFType::MAP || $typeId == SCFType::LST || $typeId == SCFType::SET) {
            return SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED;
        }
        return TypeMapV3::getFormateId($typeId);
    }

    public static function readUnknownField($tag, $inStream) {
        try {
            if ($inStream->getLength() == 0) {
                throw new ScfException('read unknown field error, inStream is null');
            }

            $type = SCFTypeFormat::getTagSCFType($tag);
            switch ($type) {
                case SCFTypeFormat::SCFTYPE_VARINT:
                    throw new ScfException('PHP client cannot deserialize varint');
                    return false;
                case SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED:
                    $len = $inStream->ReadInt32();
                    $inStream->skip($len);
                    return true;
                case SCFTypeFormat::SCFTYPE_NULL:
                    return true;
                case SCFTypeFormat::SCFTYPE_FIXED64:
                    $inStream->skip(8);
                    return true;
                case SCFTypeFormat::SCFTYPE_FIXED32:
                    $inStream->skip(4);
                    return true;
                case SCFTypeFormat::SCFTYPE_FIXED16:
                    $inStream->skip(2);
                    return true;
                case SCFTypeFormat::SCFTYPE_FIXED8:
                    $inStream->skip(1);
                    return true;
                default:
                    throw new ScfException("scf php client not support this type. type is " . $type);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return false;
    }
}

?>