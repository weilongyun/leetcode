<?php
namespace com\bj58\spat\scf\client\utility;

use com\bj58\spat\scf\client\monitor\ServiceMoniter;
use com\bj58\spat\scf\client\Version;
class MonitorHelper
{
    public static function reportVersion($scfKeyPath) {
        if (!isset($GLOBALS[$scfKeyPath]['scf_keyContent'])) {
            return;
        }  
        $date = 'SCFMonitor:' . date("y-m-d",time());
        $scfkeyContent = $GLOBALS[$scfKeyPath]['scf_keyContent'];
        if (apcu_exists($date)) {
            $reportArray = apcu_fetch($date);
            if (array_key_exists($scfkeyContent, $reportArray)) {
                return ;
            }
        }
        $reportArray[$scfkeyContent] = 1;
        $content = self::createMonitorContent($scfkeyContent);
        ServiceMoniter::INSTANCE()->sendReqData($content);
        apcu_store($date, $reportArray, 86400);
    }

    public static function createMonitorContent($keyContent) {
        $content = '{"version": "' . Version::$ID . '", ';
        $content .= '"keyConent": "' . $keyContent . '", ';
        $content .= '"local_ip": "' . gethostbyname($_ENV['COMPUTERNAME']) . '"}';
        LogHelper::logInfoMsg("report version message is " + $content);
        return $content;
    }
}

?>