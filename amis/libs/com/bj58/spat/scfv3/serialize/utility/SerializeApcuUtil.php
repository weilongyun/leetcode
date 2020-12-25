<?php
namespace com\bj58\spat\scf\serialize\utility;

use com\bj58\spat\scf\serialize\component\helper\TypeHelper;
use com\bj58\spat\scf\client\utility\LogHelper;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
class SerializeApcuUtil
{
    public static function getTypeInfoMapByKey($key, $className, $sname, &$serializeMap, &$typeInfo, $ver) {
        if (apcu_exists($key)) {
            $serializeMap = apcu_fetch($key);
            if (array_key_exists("SCFTypeInfoMap", $serializeMap)) {
                $typeInfoMap = $serializeMap['SCFTypeInfoMap'];
                if (array_key_exists($ver, $typeInfoMap) && array_key_exists($className, $typeInfoMap[$ver])) {
                    TypeHelper::GetTypeId($sname, $className);
                    $GLOBALS['SCFNameAliasesMap'][$sname] = $className;
                    ObjectSerializer::getChildObj($className, $serializeMap);
                    if (array_key_exists('SCFTypeNameEnumMap', $serializeMap)) {
                        $GLOBALS['SCFTypeNameEnumMap'] = $serializeMap['SCFTypeNameEnumMap'];
                    }
                    $typeInfo = $typeInfoMap[$ver][$className];
                    return true;
                }
            }
        }
        return false;
    }

    public static function getTypeInfoMapByKeyV3($key, $className, &$serializeMap, &$typeInfo, $ver){
        if (apcu_exists($key)) {
            $serializeMap = apcu_fetch($key);
            if (array_key_exists("SCFTypeInfoMap", $serializeMap)) {
                $typeInfoMap = $serializeMap['SCFTypeInfoMap'];
                if (array_key_exists($ver, $typeInfoMap) && array_key_exists($className, $typeInfoMap[$ver])) {
                    TypeHelper::GetTypeIdV3($className);
                    ObjectSerializer::getChildObj($className, $serializeMap);
                    if (array_key_exists('SCFTypeNameEnumMap', $serializeMap)) {
                        $GLOBALS['SCFTypeNameEnumMap'] = $serializeMap['SCFTypeNameEnumMap'];
                    }
                    $typeInfo = $typeInfoMap[$ver][$className];
                    return true;
                }
            }
        }
        return false;
    }

    public static function getTypeInfo($className, $sname, &$typeInfo, $ver) {
        if (apcu_exists('SCFTypeInfoMap')) {
            $typeInfoMap = apcu_fetch('SCFTypeInfoMap');
            if (array_key_exists($ver, $typeInfoMap) && array_key_exists($className, $typeInfoMap[$ver])) {
                TypeHelper::GetTypeId($sname, $className);
                $GLOBALS['SCFNameAliasesMap'][$sname] = $className;
                ObjectSerializer::getChildObj($className);
                if (apcu_exists('SCFTypeNameEnumMap')) {
                    $GLOBALS['SCFTypeNameEnumMap'] = apcu_fetch('SCFTypeNameEnumMap');
                }
                $typeInfo = $typeInfoMap[$ver][$className];
                return true;
            }
        }
        return false;
    }

    public static function getTypeInfoV3($className, &$typeInfo, $ver) {
        if (apcu_exists('SCFTypeInfoMap')) {
            $typeInfoMap = apcu_fetch('SCFTypeInfoMap');
            if (array_key_exists($ver, $typeInfoMap) && array_key_exists($className, $typeInfoMap[$ver])) {
                TypeHelper::GetTypeIdV3($className);
                ObjectSerializer::getChildObj($className);
                if (apcu_exists('SCFTypeNameEnumMap')) {
                    $GLOBALS['SCFTypeNameEnumMap'] = apcu_fetch('SCFTypeNameEnumMap');
                }
                $typeInfo = $typeInfoMap[$ver][$className];
                return true;
            }
        }
        return false;
    }

    public static function getEnumMapByKey($key, &$serializeMap, &$SCFTypeNameEnumMap) {
        ;
    }

    public static function updateSerializeMapByKey($key, $className, $typeInfo, $ver) {
        if (apcu_exists($key)) {
            $serializeMap = apcu_fetch($key);
            if (array_key_exists("SCFTypeInfoMap", $serializeMap)) {
                $typeInfoMap = $serializeMap['SCFTypeInfoMap'];
                if (array_key_exists($ver, $typeInfoMap)) {
                    if (array_key_exists($className, $typeInfoMap[$ver])) {
                        LogHelper::logWarnMsg('redefine class. class is ' . $className);
                    } else {
                        $typeInfoMap[$ver][$className] = $typeInfo;
                    }
                } else {
                    $infoMap = array(
                        $className => $typeInfo
                    );
                    $typeInfoMap[$ver] = $infoMap;
                }
            } else {
                $infoMap = array(
                    $className => $typeInfo
                );
                $typeInfoMap[$ver] = $infoMap;
                $serializeMap['SCFTypeInfoMap'] = $typeInfoMap;
            }
        } else {
            $infoMap = array(
                $className => $typeInfo
            );
            $typeInfoMap[$ver] = $infoMap;
            $serializeMap['SCFTypeInfoMap'] = $typeInfoMap;
        }
        $serializeMap['SCFTypeInfoMap'] = $typeInfoMap;
        return $serializeMap;
    }

    public static function updateSerializeMap($className, $typeInfo, $ver) {
        if (apcu_exists('SCFTypeInfoMap')) {
            $typeInfoMap = apcu_fetch('SCFTypeInfoMap');
            if (array_key_exists($ver, $typeInfoMap)) {
                if (array_key_exists($className, $typeInfoMap[$ver])) {
                    LogHelper::logWarnMsg('redefine class. class is ' . $className);
                } else {
                    $typeInfoMap[$ver][$className] = $typeInfo;
                }
            } else {
                $infoMap = array(
                    $className => $typeInfo
                );
                $typeInfoMap[$ver] = $infoMap;
            }
        } else {
            $infoMap = array(
                $className => $typeInfo
            );
            $typeInfoMap[$ver] = $infoMap;
        }
        apcu_store('SCFTypeInfoMap', $typeInfoMap);
        return $typeInfoMap;
    }

}

?>