<?php
namespace com\bj58\spat\scf\serialize\component\helper;

use com\bj58\spat\scf\serialize\component\helper\StrHelper;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\serialize\component\TypeMap;
class TypeHelper {

    /**
     * judger $type is primitive
     * return true/false
     * @param int $type
     */
    public static function IsPrimitive($type) {
        switch ($type) {
            case SCFType::BYTE:
                return true;
            case SCFType::STRING:
                return true;
            case SCFType::BOOL:
                return true;
            case SCFType::I16:
                return true;
            case SCFType::I32:
                return true;
            case SCFType::I64:
                return true;
            case SCFType::DOUBLE:
                return true;
            case SCFType::FLOAT:
                return true;
            case SCFType::CHAR:
                return true;
                default:return false;
        }
    }

    /**
     *
     * @param String $type
     */
    public static function IsSCFType($type) {
        if(strcasecmp($type, 'byte')) {
            return SCFType::BYTE;
        } else if (strcasecmp($type, 'string')) {
            return SCFType::STRING;
        } else if (strcasecmp($type, 'int') || strcasecmp($type, 'integer')) {
            return SCFType::I32;
        } else if (strcasecmp($type, 'short')) {
            return SCFType::I16;
        } else if (strcasecmp($type, 'long')) {
            return SCFType::I64;
        } else if (strcasecmp($type, 'float')) {
            return SCFType::FLOAT;
        } else if (strcasecmp($type, 'double')) {
            return SCFType::DOUBLE;
        } else if (strcasecmp($type, 'bool') || strcasecmp($type, 'boolean')) {
            return SCFType::BOOL;
        } else if (strcasecmp($type, 'bigdecimal')) {
            return SCFType::BIGDECIMAL;
        } else if (strcasecmp($type, 'array')) {
            return SCFType::ARAY;
        } else if (strcasecmp($type, 'date') || strcasecmp($type, 'java.sql.Date') || strcasecmp($type, 'java.sql.Time') || strcasecmp($type, 'java.sql.Timestamp')) {
            return SCFType::DATE;
        } else if (strcasecmp($type, 'set') || strcasecmp($type, 'hashset')) {
            return SCFType::SET;
        } else if (strcasecmp($type, 'list') || strcasecmp($type, 'arraylist')) {
            return SCFType::LST;
        } else if (strcasecmp($type, 'map') || strcasecmp($type, 'hashmap')) {
            return SCFType::MAP;
        } else if (strcasecmp($type, 'char') || strcasecmp($type, 'character')) {
            return SCFType::CHAR;
        }else {
            return false;
        }
    }


    public static function IsComplexType($typeId) {
        switch ($typeId) {
            case SCFType::ARAY:
                return true;
            case SCFType::LST:
                return true;
            case SCFType::MAP:
                return true;
            case SCFType::GKEYVALUEPAIR:
                return true;
            case SCFType::SET:
                return true;
            case SCFType::OBJECT:
                return true;
            default:
                return false;
        }
    }

    public static function IsEnum($typeId) {
        if (array_key_exists($typeId, $GLOBALS['SCFTypeNameEnumMap'])) {
            return true;
        }
    }

    public static function IsObject($typeId) {
        if ($typeId === SCFType::OBJECT) {
            return true;
        } else {
            return false;
        }
    }

    public static function IsNeedInitType($typeId) {
        if ($typeId == SCFType::I16 || $typeId == SCFType::I32 || $typeId == SCFType::I64 || $typeId == SCFType::BYTE ||
            $typeId == SCFType::FLOAT || $typeId == SCFType::DOUBLE) {
                return true;
            } else {
                return false;
            }
    }
    /**
     *
     * @param String $type
     */
    public static function GetTypeId($type, $realName = '') {
        $typeId = TypeMap::getTypeId($type);
        if ($typeId && $typeId != -1) {
            return $typeId;
        } else {
            $hashcode = StrHelper::GetHashcode($type);
            if (null == $realName) {
                TypeMap::addTypeIdPair($type, $hashcode);
            } else {
                TypeMap::addTypeIdPair($realName, $hashcode);
            }
            return $hashcode;
        }
    }

    public static function GetType($typeId) {
        return TypeMap::getType($typeId);
    }
}