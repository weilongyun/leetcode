<?php
namespace com\bj58\spat\scf\client;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\client\utility\LogHelper;
use com\bj58\spat\scf\log\LogFactory;

$GLOBALS['SCF_GLOBAL_LOGHANDLER'] = '';
$GLOBALS['SCF_DEFAULT_SCFKEY_PATH'] = '';
$GLOBALS['SCF_IS_GLOBAL_PATH'] = '';
class SCFInit
{

    /**
     * init scfkey path
     * @param String $scfKeyPath
     * @throws ScfException
     */
    public static function InitScfKey($scfKeyPath)
    {
        try {
            if ($GLOBALS['SCF_IS_GLOBAL_PATH']) {
                LogHelper::logWarnMsg("can not init scfkey, scfKey has been set global, current scfkey path is " . $GLOBALS['SCF_DEFAULT_SCFKEY_PATH']);
            } else {
                if (null != $scfKeyPath) {
                    $initObj = new InitObj($scfKeyPath);
                    $GLOBALS['SCF_DEFAULT_SCFKEY_PATH'] = $scfKeyPath;
                    $GLOBALS['SCF_IS_GLOBAL_PATH'] = false;
                    $serivalizeKey = md5($scfKeyPath) . '_serializeMap';
                    $initObj->setSerivalizeKey($serivalizeKey);
                    return $initObj;
                } else {
                    throw new ScfException('scfkey path is null!');
                }
            }
            return null;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function InitScfKeyAndVersion($scfKeyPath, $version) {
        try {
            if ($GLOBALS['SCF_IS_GLOBAL_PATH']) {
                LogHelper::logWarnMsg("can not init scfkey, scfKey has been set global, current scfkey path is " . $GLOBALS['SCF_DEFAULT_SCFKEY_PATH']);
            } else {
                if (null != $scfKeyPath) {
                    $initObj = new InitObj($scfKeyPath);
                    $initObj->setEntityVersion($version);
                    $serivalizeKey = md5($scfKeyPath) . '_' . $version . '_serializeMap';
                    $initObj->setSerivalizeKey($serivalizeKey);
                    $GLOBALS['SCF_DEFAULT_SCFKEY_PATH'] = $scfKeyPath;
                    $GLOBALS['SCF_IS_GLOBAL_PATH'] = false;
                    return $initObj;
                } else {
                    throw new ScfException('scfkey path is null!');
                }
            }
            return null;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * init global scfkey
     * @param  $scfKeyPath
     * @throws ScfException
     * @throws Exception
     */
    public static function InitGlobalScfKey($scfKeyPath) {
        try {
            if ($GLOBALS['SCF_IS_GLOBAL_PATH']) {
                LogHelper::logWarnMsg("can not init global scfkey again, scfKey has been set global, current scfkey path is " . $GLOBALS['SCF_DEFAULT_SCFKEY_PATH']);
            } else {
                if (null != $scfKeyPath) {
                    $initObj = new InitObj($scfKeyPath);
                    $GLOBALS['SCF_DEFAULT_SCFKEY_PATH'] = $scfKeyPath;
                    $GLOBALS['SCF_IS_GLOBAL_PATH'] = true;
                    return $initObj;
                } else {
                    throw new ScfException('scfkey path is null!');
                }
            }
            return null;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function InitGlobalLog($logHandler) {
        try {
            if ($GLOBALS['SCF_GLOBAL_LOGHANDLER']) {
                LogHelper::logWarnMsg("cann't init global log handler, log handler has been set global.");
            } else {
                $GLOBALS['SCF_GLOBAL_LOGHANDLER'] = $logHandler;
                LogFactory::registerLog($logHandler);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function InitLog($logHandler) {
        try {
            if ($GLOBALS['SCF_GLOBAL_LOGHANDLER']) {
                LogHelper::logWarnMsg("cann't init log handler, log handler has been set global.");
            } else {
                LogFactory::registerLog($logHandler);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function IsManager()
    {
        return $this->isManager;
    }
}