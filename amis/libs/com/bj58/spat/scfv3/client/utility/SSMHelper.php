<?php
namespace com\bj58\spat\scf\client\utility;

use com\bj58\spat\scf\client\configuration\scfmanager\SSMRespData;
use com\bj58\spat\scf\client\configuration\scfmanager\SSMRespForbidType;
class SSMHelper
{
    public static function cacheConfigData($configData)
    {
        try {
            if (null !== $configData) {
                $ssmRespData = new SSMRespData();
                $config = $configData['config'];
                $ssmRespData->setConfig($config);
                $configChanged = $configData['configChanged'];
                $ssmRespData->setConfigChanged($configChanged);
                $lastConfigTime = $configData['lastConfigTime'];
                $ssmRespData->setLastConfigTime($lastConfigTime);
                $serviceName = $configData['serviceName'];
                $ssmRespData->setServiceName($serviceName);
                $version = $configData['version'];
                $ssmRespData->setVersion($version);
                $flag = $configData['flag'];
                $ssmRespData->setFlag($flag);
                $forbidCode = $configData['forbidCode'];
                $ssmRespData->setForbidCode($forbidCode);
                return $ssmRespData;
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function getErrorMsg($ssmData, $keyContent = '') {
        $str = "cannot get config, cause ";
        if (is_array($ssmData)) {
            $forbidenType = $ssmData['forbidCode'];
            $warn = SSMRespForbidType::fromInt($forbidenType);
        }
        $str .= $warn;
        $content = '. key is : ' . $keyContent;
        $str .= $content;
        return $str;
    }

//     public static function cacheConfigData($configData)
//     {
//         try {
//             if (null !== $configData) {
//                 $ssmRespData = new SSMRespData();
//                 $config = $configData->{'config'};
//                 $ssmRespData->setConfig($config);
//                 $configChanged = $configData->{'configChanged'};
//                 $ssmRespData->setConfigChanged($configChanged);
//                 $lastConfigTime = $configData->{'lastConfigTime'};
//                 $ssmRespData->setLastConfigTime($lastConfigTime);
//                 $serviceName = $configData->{'serviceName'};
//                 $ssmRespData->setServiceName($serviceName);
//                 $version = $configData->{'version'};
//                 $ssmRespData->setVersion($version);
//                 $flag = $configData->{'flag'};
//                 $ssmRespData->setFlag($flag);
//                 $forbidCode = $configData->{'forbidCode'};
//                 $ssmRespData->setForbidCode($forbidCode);
//                 return $ssmRespData;
//             }
//         } catch (\Exception $e) {
//             throw $e;
//         }
//     }
}

?>