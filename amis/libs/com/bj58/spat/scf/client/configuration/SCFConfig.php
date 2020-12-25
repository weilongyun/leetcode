<?php
namespace com\bj58\spat\scf\client\configuration;

use com\bj58\spat\scf\client\utility\keyload\KeyLoad;
use com\bj58\spat\scf\client\configuration\scfmanager\ServiceConfigManager;
use com\bj58\spat\scf\client\utility\XMLHelper;
use com\bj58\spat\scf\client\utility\SSMHelper;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\client\utility\APCuCache;
use com\bj58\spat\scf\client\utility\LogHelper;
$GLOBALS['scf_keyContent'] = '';
class SCFConfig
{

    public static $config = array();

    public static $keyContent = '';

    public static function loadConfigByScfKey($scfKeyPath, $serviceName, $time)
    {
        try {
            $retry = 3;
            $scfKeyPathMd5 = md5($scfKeyPath . $serviceName);
            $key = $scfKeyPathMd5 . '_srvmgr_config';
            $configCache = new APCuCache($serviceName);
            $configCache->init();
            while ($retry) {
                $retry --;
                $configData = '';
                if (true === $configCache->get($key, $configData)) {
                    $GLOBALS[$scfKeyPath]['scf_config'][$serviceName] = $configData;
                    return;
                }

                if (false === $configCache->wLock($key, true)) {
                    if (null != $configData) {
                        $GLOBALS[$scfKeyPath]['scf_config'][$serviceName] = $configData;
                    } else {
                        usleep(20000);
                        continue;
                    }
                    return;
                }

                if (true === $configCache->get($key, $configData)) {
                    $configCache->unWLock($key);
                    $GLOBALS[$scfKeyPath]['scf_config'][$serviceName] = $configData;
                    return;
                }

                $succ = '';
                $keyContent = apcu_fetch($scfKeyPathMd5 . '_keyContent', $succ);
                if (! $succ) {
                    $keyContent = KeyLoad::getKeyContent($scfKeyPath, $scfKeyPathMd5 . '_keyContent');
                    $GLOBALS[$scfKeyPath]['scf_keyContent'] = $keyContent;
                }
                if (null != $keyContent) {
                    try {
                        $ssmData = ServiceConfigManager::INSTANCE()->getRespData($serviceName, $time, $keyContent);
                        $ssmRespData = SSMHelper::cacheConfigData($ssmData);
                        if (null!= $ssmRespData && $ssmRespData->getConfigChanged()) {
                            $configStr = $ssmRespData->getConfig();
                            if (null != $configStr) {
                                $value = self::getXMLStrConfig($scfKeyPath, $configStr);
                                $configCache->put($key, $value[$serviceName], 60000);
                            } else {
                                throw new ScfException('');
                            }
                        } else {
                            if (null == $configData) {
                                $configCache->unWLock($key);
                                continue;
                            } else {
                                $configCache->put($key, $configData, 60000);
                            }
                        }
                    } catch (\Exception $e) {
                        LogHelper::logErrorMsg($e->getMessage() . ' in ' . $e->getFile() . ' at ' . $e->getLine());
                        if (null == $configData) {
                            $configCache->unWLock($key);
                            continue;
                        } else {
                            $configCache->put($key, $configData, 60000);
                        }
                    }
                }
                $configCache->unWLock($key);
                return;
            }
        } catch (\Exception $e) {
            $configCache->unWLock($key);
            throw $e;
        }
    }

    public static function readXML($path, $serviceName)
    {
        try {
               if (apcu_exists($path)) {
                   $servs = @apcu_fetch($path);
                   $GLOBALS[$path]['scf_config'] = $servs;
               } else {
                   self::readXMLFromLocal($path);
                   @apcu_add($path, $GLOBALS[$path]['scf_config']);
               }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function readXMLFromLocal($path)
    {
        try {
            $doc = new \DOMDocument();
            $doc->load($path);
            self::getConfig($doc, $path);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @param unknown $configStr
     *            string
     */
    public static function getConfig($doc, $path = '')
    {
        try {
            if (null !== $doc) {
                $services = $doc->getElementsByTagName("Service");
                $servs = array();
                foreach ($services as $service) {
                    $serviceName = $service->attributes->item(0)->nodeValue;
                    $servs['servicename'] = $serviceName;
                    $slen = $service->attributes->length;
                    $num = 1;
                    while ($num < $slen) {
                        $name = $service->attributes->item($num)->name;
                        $value = $service->attributes->item($num)->nodeValue;
                        $servs[$name] = $value;
                        $num ++;
                    }
                    $socketPool = $service->getElementsByTagName('SocketPool');
                    $splen = $socketPool->item(0)->attributes->length;
                    $num = 0;
                    while ($num < $splen) {
                        $name = $socketPool->item(0)->attributes->item($num)->name;
                        $value = $socketPool->item(0)->attributes->item($num)->nodeValue;
                        ;
                        $servs[$name] = $value;
                        $num ++;
                    }
                    $protocol = $service->getElementsByTagName('Protocol');
                    $plen = $protocol->item(0)->attributes->length;
                    $num = 0;
                    while ($num < $plen) {
                        $name = $protocol->item(0)->attributes->item($num)->name;
                        $value = $protocol->item(0)->attributes->item($num)->nodeValue;
                        ;
                        $servs[$name] = $value;
                        $num ++;
                    }

                    $serv = array();
                    $temp = array();
                    $servers = $service->getElementsByTagName("add");
                    foreach ($servers as $server) {
                        $serv['weight'] = '1';
                        $len = $server->attributes->length;
                        $num = 0;
                        while ($num < $len) {
                            $name = $server->attributes->item($num)->name;
                            $value = $server->attributes->item($num)->nodeValue;
                            $serv[$name] = $value;
                            $num ++;
                        }
                        $temp[] = $serv;
                    }
                    $servs['servers'] = $temp;
                    $GLOBALS[$path]['scf_config'][$serviceName] = $servs;
                }
            }
            return $GLOBALS[$path]['scf_config'];
        } catch (\Exception $e) {
            throw $e;
        }
        return null;
    }

    public static function getXMLStrConfig($path, $xmlStr)
    {
        try {
            $doc = XMLHelper::getXMLDocFromStr($xmlStr);
            return self::getConfig($doc, $path);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function getServerConfig($path, $serviceName)
    {
        try {
            $serverConfig = array();
            $serviceConfig = $GLOBALS[$path]['scf_config'][$serviceName];
            $sendTimeOut = self::changeTime($serviceConfig['sendTimeout']);
            $receiveTimeOut = self::changeTime($serviceConfig['receiveTimeout']);
            $serverConfig['sendTimeout'] = $sendTimeOut;
            $serverConfig['receiveTimeout'] = $receiveTimeOut;
            $serverConfig['hosts'] = $serviceConfig['servers'];

            $serverConfig['sendTimeout'] = 300;
            $serverConfig['receiveTimeout'] = 500;
            return $serverConfig;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function changeTime($time)
    {
        try {
            if (strstr($time, ':')) {
                $times = explode(':', $time);
                $size = count($times);
                switch ($size) {
                    case 2:
                        $res = ($times[0] * 3600 + $times[1] * 60) * 1000;
                        break;
                    case 3:
                        $res = ($times[0] * 3600 + $times[1] * 60 + $times[2]) * 1000;
                        break;
                    default:
                        throw new ScfException('config sendTimeOut or receiveTimeOut format error, is ' . $time);
                        break;
                }
                return $res;
            } else {
                return $time;
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
