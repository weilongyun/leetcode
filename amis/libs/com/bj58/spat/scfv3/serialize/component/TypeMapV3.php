<?php
namespace com\bj58\spat\scf\serialize\component;

use com\bj58\spat\scf\serialize\component\helper\SCFTypeFormat;
use com\bj58\spat\scf\exception\ScfException;

class TypeMapV3
{

    const ENDTYPE = 0;

    public static function initTypeMapV3(&$serializeMap)
    {
        global $SCFTypeFixedFormateMap;
        global $SCFTypeIdMapV3;
        global $SCFIdTypeMapV3;
        $SCFTypeIdMapV3 = array(
            1 => "DBNull",
            2 => "Object",
            3 => "Boolean",
            4 => "Character",
            5 => "Byte",
            7 => "Short",
            9 => "Integer",
            11 => "Long",
            13 => "Float",
            14 => "Double",
            15 => "BigDecimal",
            16 => "Date",
            18 => "String",
            19 => "List",
            22 => "GKeyValuePair",
            23 => "Array",
            24 => "Map",
            26 => "Set",
            29 => "boolean",
            30 => "char",
            31 => "byte",
            32 => "short",
            33 => "int",
            34 => "long",
            35 => "float",
            36 => "double"
        );

        $SCFIdTypeMapV3 = array(
            "DBNull" => 1,
            "Object" => 2,
            "object" => 2,
            "Boolean" => 3,
            "boolean" => 29,
            "Character" => 4,
            "char" => 30,
            "Byte" => 5,
            "byte" => 31,
            "Short" => 7,
            "short" => 32,
            "Integer" => 9,
            "integer" => 9,
            "int" => 33,
            "Long" => 11,
            "long" => 34,
            "Float" => 13,
            "float" => 35,
            "Double" => 14,
            "double" => 36,
            "BigDecimal" => 15,
            "Date" => 16,
            "java.sql.Date" => 16,
            "java.sql.Time" => 16,
            "java.sql.Timestamp" => 16,
            "String" => 18,
            "string" => 18,
            "List" => 19,
            "list" => 19,
            "ArrayList" => 19,
            "LinkedList" => 19,
            "GKeyValuePair" => 22,
            "Array" => 23,
            "array" => 23,
            "Map" => 24,
            "map" => 24,
            "HashMap" => 24,
            "Set" => 26,
            "set" => 26,
            "HashSet" => 26
        );

        $SCFTypeFixedFormateMap = array(
            "DBNull" => SCFTypeFormat::SCFTYPE_NULL,
            "Object" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "object" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "Boolean" => SCFTypeFormat::SCFTYPE_FIXED8,
            "boolean" => SCFTypeFormat::SCFTYPE_FIXED8,
            "Character" => SCFTypeFormat::SCFTYPE_FIXED8,
            "char" => SCFTypeFormat::SCFTYPE_FIXED8,
            "Byte" => SCFTypeFormat::SCFTYPE_FIXED8,
            "byte" => SCFTypeFormat::SCFTYPE_FIXED8,
            "Short" => SCFTypeFormat::SCFTYPE_FIXED16,
            "short" => SCFTypeFormat::SCFTYPE_FIXED16,
            "Integer" => SCFTypeFormat::SCFTYPE_FIXED32,
            "integer" => SCFTypeFormat::SCFTYPE_FIXED32,
            "int" => SCFTypeFormat::SCFTYPE_FIXED32,
            "Long" => SCFTypeFormat::SCFTYPE_FIXED64,
            "long" => SCFTypeFormat::SCFTYPE_FIXED64,
            "Float" => SCFTypeFormat::SCFTYPE_FIXED32,
            "float" => SCFTypeFormat::SCFTYPE_FIXED32,
            "Double" => SCFTypeFormat::SCFTYPE_FIXED64,
            "double" => SCFTypeFormat::SCFTYPE_FIXED64,
            "BigDecimal" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "Date" => SCFTypeFormat::SCFTYPE_FIXED64,
            "java.sql.Date" => SCFTypeFormat::SCFTYPE_FIXED64,
            "java.sql.Time" => SCFTypeFormat::SCFTYPE_FIXED64,
            "java.sql.Timestamp" => SCFTypeFormat::SCFTYPE_FIXED64,
            "String" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "string" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "List" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "list" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "ArrayList" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "LinkedList" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "GKeyValuePair" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "Array" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "array" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "Map" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "map" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "HashMap" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "Set" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "set" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED,
            "HashSet" => SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED
        );
        $serializeMap['SCFTypeFixedFormateMap'] = $SCFTypeFixedFormateMap;
        $serializeMap['SCFIdTypeMapV3'] = $SCFIdTypeMapV3;
        $serializeMap['SCFTypeIdMapV3'] = $SCFTypeIdMapV3;
    }

    public static function getFormateId($typeId)
    {
        try {
            $type = TypeMapV3::getTypeV3($typeId);
            if (is_array($GLOBALS['SCFTypeFixedFormateMap'])) {
                if (array_key_exists(strval($type), $GLOBALS["SCFTypeFixedFormateMap"])) {
                    return $GLOBALS["SCFTypeFixedFormateMap"][strval($type)];
                } else {
                    throw new ScfException("scfV3 not support this type. type is " . $type);
                }
            } else {
                throw new ScfException("do not init serialize SCFIdTypeMap.");
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @param unknown $type
     */
    public static function getTypeIdV3($type)
    {
        try {
            if (is_array($GLOBALS['SCFIdTypeMapV3'])) {
                if (array_key_exists(strval($type), $GLOBALS["SCFIdTypeMapV3"])) {
                    return $GLOBALS["SCFIdTypeMapV3"][strval($type)];
                } else {
                    return - 1;
                }
            } else {
                throw new ScfException("do not init serialize SCFIdTypeMap.");
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @param unknown $param
     */
    public static function getTypeV3($type)
    {
        try {
            if (is_array($GLOBALS["SCFTypeIdMapV3"])) {
                if (array_key_exists($type, $GLOBALS["SCFTypeIdMapV3"])) {
                    return $GLOBALS["SCFTypeIdMapV3"][$type];
                } else {
                    return - 1;
                }
            } else {
                throw new ScfException("do not init serialize SCFTypeIdMap.");
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @param unknown $type
     * @param unknown $id
     */
    public static function addTypeIdPairV3($type, $id)
    {
        $GLOBALS['SCFIdTypeMapV3'][$type] = $id;
        $GLOBALS['SCFTypeIdMapV3'][strval($id)] = $type;
        $GLOBALS['SCFTypeFixedFormateMap'][$type] = SCFTypeFormat::SCFTYPE_LENGTH_DELIMITED;
    }
}

?>