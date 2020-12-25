<?php
namespace Libs\Storage;

use Libs\Log\WTableLogHelper;
use Libs\Wmonitor\WMonitorRBI;
use \WTable\client\WTableClient;
use \WTable\exception\WTableException;
use \Libs\Log\ExceptionLog;

class Wtable {

    private static $singleton = NULL;
    private static $LogObj = NULL;

    /**
     * Singleton.
     */
    public static function instance() {
        $class = get_called_class();
        is_null(self::$singleton) && self::$singleton = new $class();
        return self::$singleton;
    }
    
    private static function getLogObj() {
        is_null(self::$LogObj) && self::$LogObj = new \Libs\Log\BasicLogWriter();
        return self::$LogObj;       
    } 

    public $config = NULL;

    /**
     * Connection pools.
     *
     * @var array
     */
    private $wtableObj = array();

    /**
     * Constructor.
     */
    protected function __construct() {
        is_null($this->config) && $this->config = \Frame\ConfigFilter::instance()->getConfig('wtable');
        try {
            $this->wtableObj = new WTableClient(
                    $this->config['bid'], 
                    $this->config['password'], 
                    $this->config['addr'],
                    WTableLogHelper::getInstance()
                );
            $this->wtableObj->init($this->config['timeout']);
        } catch (\Exception $ex) {
            ExceptionLog::Log($ex);          
        }
    }

    public function __call($method, $arguments) {
        WMonitorRBI::setRBI(WMonitorRBI::WMONITOR_GONG_WTABLE_COUNT, 1);

        $result = false;
        try {
            $result = call_user_func_array(array($this->wtableObj,$method), $arguments);
        } catch (WTableException $ex) {
            WMonitorRBI::setRBI(WMonitorRBI::WMONITOR_GONG_WTABLE_ERROR, 1);
            ExceptionLog::Log($ex);
        }

        if (is_object($result) && empty($result->value)) {
            WMonitorRBI::setRBI(WMonitorRBI::WMONITOR_GONG_WTABLE_ERROR, 1);
        }

        return $result;
    }

}

