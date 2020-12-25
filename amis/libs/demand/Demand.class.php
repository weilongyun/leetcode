<?php
namespace Libs\Demand;

use Gongyu\Packages\Base\WTableConst;
use Libs\Cache\NormalCacheBase;
use Libs\Log\ExceptionLog;
use WTable\client\WTableClient;
use WTable\exception\WTableException;

/**
 * Created by PhpStorm.
 * User: baihao
 * Date: 2016/9/6
 * Time: 20:56
 */
class DBExpressCommonToolHelper extends \Libs\DB\DBConnManager {
    const _DATABASE_ = 'dbwww58com_realhouse';
    static $readretry = 1;
}


class ExpressCommonCache extends NormalCacheBase {
    const PREFIX = 'ExpressCommonTool:';
    const TIMEOUT = 600;
}

class Demand {
    const PREFIX = 'Demand_';
    const COLKEY = 'Demand_contentId_';
    public static $express_common_tool_table = 't_realhouse_content_data';
    private static $singleton = NULL;
    private $config = NULL;
    private $wtableObj = array();

    /**
     * Singleton.
     */
    public static function instance($env = 'none') {
        $class = get_called_class();
        is_null(self::$singleton) && self::$singleton = new $class($env);
        return self::$singleton;
    }

    private function __construct($env) {
        is_null($this->config) && $this->config = WtableConfig::GetEnvTypeById($env);
        try {
            $this->wtableObj = new WTableClient(
                $this->config['bid'],
                $this->config['password'],
                $this->config['addr']
            );
            $this->wtableObj->init($this->config['timeout']);
        } catch (\Exception $ex) {
            ExceptionLog::Log($ex);
        }
    }

    public function getExpressInfoFromWtableByCid($code, $contentId) {
        $code = trim($code);
        $contentId = intval($contentId);
        if (empty($contentId) || empty($code)) {
            return array();
        }
        try {
            $wTableClient = $this->wtableObj;
            $wTableData = $wTableClient->get(WTableConst::TID_Demand, self::PREFIX . $code, self::COLKEY . $contentId);
            if (empty($wTableData) || empty($wTableData->value) || ($wTableData->errCode != 0)) {
                $value = $this->getExpressInfoByCid($contentId);
                return $value;
            }
            $value = json_decode($wTableData->value, true);
            if (empty($value)) {
                $value = array();
            }
            return $value;
        } catch (\Exception $ex) {
            ExceptionLog::Log($ex);
            return array();
        }
    }

    public function getExpressInfoFromWtableByPassword($code) {
        $code = trim($code);
        if (empty($code)) {
            return array();
        }
        try {
            $data = array();
            $wTableClient = $this->wtableObj;
            $wTableData = $wTableClient->scan(WTableConst::TID_Demand, self::PREFIX . $code);
            if (empty($wTableData) || empty($wTableData->kvs)) {
                $data = $this->getExpressInfoByPassword($code);
                return $data;
            }
            foreach ($wTableData->kvs as $item) {
                $value = json_decode($item->value, true);
                if (empty($value)) {
                    continue;
                }
                $data = array_merge($data, $value);
            }
            return $data;
        } catch (\Exception $ex) {
            ExceptionLog::Log($ex);
            return array();
        }
    }

    private function getExpressInfoByCid($contentId) {
        $contentId = intval($contentId);
        if (empty($contentId)) {
            return FALSE;
        }

        $h = date('H');
        $key = "ContentId:{$h}:" . $contentId;
        $data = ExpressCommonCache::instance()->getCache(array($key));
        if (!empty($data) && is_array($data) && $_GET['debug'] != 'x_cache') {
            return $data[$key];
        }
        $params = array('content_id' => $contentId);
        $dbData = self::getExpressInfo($params);

        if (!empty($dbData[0]['data_json'])) {
            $cacheData = array($key => $dbData);
            ExpressCommonCache::instance()->setCache($cacheData);
        }

        return $dbData;
    }

    private function getExpressInfoByPassword($password) {
        if (empty($password)) {
            return array();
        }
        $key = 'Password:' . date('H') . $password;
        $data = ExpressCommonCache::instance()->getCache(array($key));
        if (!empty($data) && is_array($data) && $_GET['debug'] != 'x_cache') {
            return $data[$key];
        }

        $params = array('password' => $password);
        $dbData = self::getExpressInfo($params);

        if (!empty($dbData)) {
            $cacheData = array($key => $dbData);
            ExpressCommonCache::instance()->setCache($cacheData);
        }

        return $dbData;
    }

    private function getExpressInfo($params, $cols = "*", $fromMaster = FALSE, $hashKey = NULL) {
        if (empty($params)) {
            return FALSE;
        }

        $selectSql = "SELECT $cols FROM " . self::$express_common_tool_table . " WHERE 1 = 1";
        $sqlData = array();
        foreach ($params as $paramKey => $paramValue) {
            if (is_array($paramValue)) {
                $selectSql .= " AND `$paramKey` IN ('" . implode("','", $paramValue) . "')";
            } else {
                $selectSql .= " AND `$paramKey` = :$paramKey";
                $sqlData[$paramKey] = $paramValue;
            }
        }
        $expressInfo = DBExpressCommonToolHelper::getConn()->read($selectSql, $sqlData, $fromMaster, $hashKey);
        return $expressInfo;
    }

}