<?php
namespace com\bj58\spat\scf\client\utility;

class ClientApcuUtil
{

    public static function clearAllInApcu($scfKeyPath, $serviceName, $version = '')
    {
        $scfKeyPathMd5 = md5($scfKeyPath . $serviceName);
        $configkey = $scfKeyPathMd5 . '_srvmgr_config';
        apcu_delete($configkey);

        $transKey = md5($scfKeyPath) . $serviceName;
        apcu_delete($transKey);
        apcu_delete($transKey . _local);

        $scfkey = $scfKeyPathMd5 . '_keyContent';
        apcu_delete($scfkey);

        if(null == $version) {
            apcu_delete("SCFTypeIdMap");
            apcu_delete("SCFIdTypeMap");
            apcu_delete("SCFTypeInfoMap");
            apcu_delete("SCFTypeNameMap");
            apcu_delete("SCFTypeNameEnumMap");
            apcu_delete("SCFParentAndChildObj");
        } else {
            $serivalizeKey = md5($scfKeyPath) . '_' . $version . '_serializeMap';
            apcu_delete($serivalizeKey);
        }
    }

    public static function clearScfkeyInApcu($scfKeyPath, $serviceName)
    {
        $scfKeyPathMd5 = md5($scfKeyPath . $serviceName);
        $scfkey = $scfKeyPathMd5 . '_keyContent';
        apcu_delete($scfkey);
    }

    public static function clearConfigInApcu($scfKeyPath, $serviceName)
    {
        //清除配置文件
        $scfKeyPathMd5 = md5($scfKeyPath . $serviceName);
        $configkey = $scfKeyPathMd5 . '_srvmgr_config';
        apcu_delete($configkey);
        //清除transprot
        $transKey = md5($scfKeyPath) . $serviceName;
        apcu_delete($transKey);
        apcu_delete($transKey . _local);
    }

    public static function clearSerializerInApcuByVer($scfKeyPath, $version = '')
    {
        $serivalizeKey = md5($scfKeyPath) . '_' . $version . '_serializeMap';
        $res = apcu_fetch($serivalizeKey);
    }

    public static function clearSerializerInApcu()
    {
        apcu_fetch("SCFTypeIdMap");
        apcu_fetch("SCFIdTypeMap");
        apcu_fetch("SCFTypeInfoMap");
        apcu_fetch("SCFTypeNameMap");
        apcu_fetch("SCFTypeNameEnumMap");
        apcu_fetch("SCFParentAndChildObj");
    }
}

?>