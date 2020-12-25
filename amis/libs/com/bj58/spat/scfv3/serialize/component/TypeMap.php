<?php
namespace com\bj58\spat\scf\serialize\component;

use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;

class TypeMap
{

    public static function init($key)
    {
        global $SCFTypeIdMap;
        global $SCFIdTypeMap;
        global $SCFTypeInfoMap;
        global $SCFTypeNameEnumMap;
        global $SCFNameAliasesMap;
        $serializeMap = array();
        $SCFTypeIdMap = array(
            1 => "DBNull",
            2 => "Object",
            3 => "boolean",
            4 => "char",
            5 => "byte",
            7 => "short",
            9 => "int",
            11 => "long",
            13 => "float",
            14 => "double",
            15 => "BigDecimal",
            16 => "Date",
            18 => "String",
            19 => "List",
            22 => "GKeyValuePair",
            23 => "Array",
            24 => "Map",
            26 => "Set"
        );
        $SCFIdTypeMap = array(
            "DBNull" => 1,
            "Object" => 2,
            "object" => 2,
            "Boolean" => 3,
            "boolean" => 3,
            "Character" => 4,
            "char" => 4,
            "Byte" => 5,
            "byte" => 5,
            "Short" => 7,
            "short" => 7,
            "Integer" => 9,
            "integer" => 9,
            "int" => 9,
            "Long" => 11,
            "long" => 11,
            "Float" => 13,
            "float" => 13,
            "Double" => 14,
            "double" => 14,
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
        $serializeMap['SCFTypeIdMap'] = $SCFTypeIdMap;
        $serializeMap['SCFIdTypeMap'] = $SCFIdTypeMap;
        TypeMapV3::initTypeMapV3($serializeMap);
        apcu_store($key, $serializeMap);
        // Compatible with older versions. Global cache.
        @apcu_store('SCFTypeIdMap', $SCFTypeIdMap);
        @apcu_store('SCFIdTypeMap', $SCFIdTypeMap);
        $SCFTypeInfoMap = array();
        $SCFTypeNameEnumMap = array();
        $SCFNameAliasesMap = array();
    }

    /**
     *
     * @param unknown $type
     */
    public static function getTypeId($type)
    {
        try {
            if (is_array($GLOBALS['SCFIdTypeMap'])) {
                if (array_key_exists(strval($type), $GLOBALS["SCFIdTypeMap"])) {
                    return $GLOBALS["SCFIdTypeMap"][strval($type)];
                } else {
                    if (array_key_exists(strval($type), $GLOBALS['SCFNameAliasesMap'])) {
                        $type = $GLOBALS['SCFNameAliasesMap'][strval($type)];
                        if (array_key_exists(strval($type), $GLOBALS["SCFIdTypeMap"])) {
                            return $GLOBALS["SCFIdTypeMap"][strval($type)];
                        }
                    }
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
    public static function getType($type)
    {
        try {
            if (is_array($GLOBALS["SCFTypeIdMap"])) {
                if (array_key_exists($type, $GLOBALS["SCFTypeIdMap"])) {
                    return $GLOBALS["SCFTypeIdMap"][$type];
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
    public static function addTypeIdPair($type, $id)
    {
        $GLOBALS['SCFIdTypeMap'][$type] = $id;
        $GLOBALS['SCFTypeIdMap'][strval($id)] = $type;
    }
}