<?php
namespace Libs\Cache;

use \wcacheclient\WcacheClient;
use \wcacheclient\exception\WcacheException;
use \Libs\Log\ExceptionLog;
use \Libs\Cache\ApcuCache;

class Memcache {

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
    private $wcacheObj = array();

    /**
     * Constructor.
     */
    protected function __construct() {
        if (!class_exists('Memcached')) {
            $this->wcacheObj = new ApcuCache();
            return;
        } 
        is_null($this->config) && $this->config = \Frame\ConfigFilter::instance()->getConfig('memcache');
        $this->wcacheObj = new WcacheClient(
                $this->config['cluster_Id'], 
                $this->config['key_prefix'], 
                $this->config['timeout'], 
                $this->config['addr'],
                $this->config['port']);
    }

    public function __call($method, $arguments) {
        try {
            return $this->$method($arguments);            
        } catch (\Exception $ex) {
            ExceptionLog::Log($ex);
            return FALSE;
        }
    }

    /**
     * Delete an item.
     *
     * @param string $key The key to be deleted.
     * @param int $time The amount of time the server will wait to delete
     * the item.
     *
     * @return Returns TRUE on success or FALSE on failure.
     */
    protected function delete($args) {
        $key = $args[0];
        if (!isset($args[1])) {
            $args[1] = 0;
        }
        $time = $args[1];
        $result = TRUE;
        $result = $result && $this->wcacheObj->delete($key, $time);
        return $result;
    }

    /**
     * Store an item.
     *
     * @param string $key The key under which to store the value.
     * @param mixed $value The value to store.
     * @param int $expiration The expiration time, defaults to 0.
     *
     * @return Returns TRUE on success or FALSE on failure.
     */
    protected function set($args) {
        $key = $args[0];
        $value = $args[1];
        if (!isset($args[2])) {
            $args[2] = 0;
        }
        $expiration = $args[2];
        $result = TRUE;
        $result = $result && $this->wcacheObj->set($key, $value, $expiration);
        return $result;
    }

    /**
     * Retrieve an item.
     *
     * @param string $key The key of the item to retrieve.
     *
     * @return Returns the value stored in the cache or FALSE otherwise.
     */
    protected function get($args) {
        $key = $args[0];
        $result = FALSE;
        $result = $this->wcacheObj->get($key);

        return $result;
    }

    /**
     * Increment numeric item's value.
     */
    protected function increment($args) {
        $key = $args[0];
        if (!isset($args[1])) {
            $args[1] = 1;
        }
        $offset = $args[1];
        $result = FALSE;
        $result = $this->wcacheObj->increment($key, $offset);
        return $result;
    }

    /**
     * Decrement numeric item's value.
     */
    protected function decrement($args) {
        $key = $args[0];
        if (!isset($args[1])) {
            $args[1] = 1;
        }
        $offset = $args[1];
        $result = FALSE;
        $result = $this->wcacheObj->decrement($key, $offset);
        return $result;
    }

    /**
     * Retrieve multiple items.
     */
    protected function getMulti($args) {
        $keys = $args[0];
        if (empty($keys) || !is_array($keys)) {
            return FALSE;
        }

        if (count($keys) > 10) {
            return $this->wcacheObj->getMulti($keys);
        }

        $values = array();
        foreach ($keys as $key) {
            $val = $this->wcacheObj->get($key);
            if ($val !== FALSE) {
                $values[$key] = $val;
            }
        }
        return $values;
    }

    /**
     * Store multiple items.
     */
    protected function setMulti($args) {
        $items = $args[0];
        if (!isset($args[1])) {
            $args[1] = 0;
        }
        $expiration = $args[1];
        $result = $this->wcacheObj->setMulti($items, $expiration);
        return $result;
    }

    /**
     * 返回最后一次操作的结果代码
     */
    protected function getResultCode() {
        return $this->wcacheObj->getResultCode();
    }
}
