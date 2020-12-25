<?php
namespace Libs\Cache;

class ApcuCache {

    private $mc;
    private $keyPrefix;
    private $timeout;

    public function __construct() {
        if (!function_exists('apcu_exists')) {
            $this->mc = NULL;
            return;
        }
        $this->mc = TRUE;
    }

    private function setOption($keyPrefix, $timeout) {
        if (is_null($this->mc)) {
            return;
        }
        $this->keyPrefix = $keyPrefix;
        $this->timeout = $timeout;
    }

    public function __destruct() {
        
    }

    public function add($key, $value, $expiration) {
        if (is_null($this->mc)) {
            return false;
        }
        return apcu_add($key, $value, $expiration);
    }

    /**
     *
     * @param String $key            
     * @throws WcacheException
     * @return boolean|unknown
     */
    public function delete($key) {
        if (is_null($this->mc)) {
            return false;
        }
        return apcu_delete($key);
    }

    public function set($key, $value, $expiration) {
        if (is_null($this->mc)) {
            return false;
        }
        $res = apcu_store($key, $value, $expiration);
        return $res;
    }

    public function setMulti($items, $expiration) {
        if (is_null($this->mc)) {
            return false;
        }

        foreach ($items as $key => $value) {
            $rest = $this->set($key, $value, $expiration);
        }
        return $res;
    }

    public function get($key) {
        if (is_null($this->mc)) {
            return NULL;
        }
        $res = apcu_fetch($key);
        return $res;
    }

    /**
     *
     * @param Array $items , key-arrary .            
     * @throws WcacheException
     * @return array
     */
    public function getMulti($items) {
        if (is_null($this->mc)) {
            return NULL;
        }
        $res = array();
        foreach ($items as $key) {
            $data = $this->get($key);
            if (empty($data)) {
                continue;
            }
            $res[$key] = $data;
        }
        return $res;
    }

    public function increment($key, $offset = 1) {
        if (is_null($this->mc)) {
            return false;
        }
        return apcu_inc($key, $offset);
    }

    public function decrement($key, $offset = 1) {
        if (is_null($this->mc)) {
            return false;
        }
        return apcu_dec($key, $offset);
    }

    public function getResultCode() {
        if (is_null($this->mc)) {
            return false;
        }
        return TRUE;
    }
}
