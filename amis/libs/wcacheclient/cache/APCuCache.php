<?php
namespace wcacheclient\cache;
use wcacheclient\helper\Log;

class APCuCache{
	const UMASK = 0777; 
	const LOCK_DIR = "/tmp/apcu-lock";
	private $fps;
	private $srvName;
	
	/** Constructor
	 *  @param int ttl The time-to-live seconds of record, default 0.
	 */
	public function __construct($srvName) {
		$this->srvName = $srvName;
		$this->fps = array();
	}
	/**  Destructor
	 */
	public function __destruct(){
		foreach($this->fps as $fp) {
			if($fp != Null) {
				@fclose($fp);
			}
		}
		unset($this->fps);
	}
	private function getLockFile($key) {
		return self::LOCK_DIR."/".$this->srvName."/".$key.".lock";
	}
	private function openLockFile($key) {
		if(true === array_key_exists($key, $this->fps)){
			return $this->fps[$key];
		}
		$file = $this->getLockFile($key);
		if(false === file_exists($file)) {
			@touch($file);
		}
		if(false === ($fp = fopen($file, "r+"))) {
			return false;
		}
		$this->fps[$key] = $fp;
		return $fp;
	}
	public function init(){
		$lockDir = dirname($this->getLockFile("dir"));
		if(false === file_exists($lockDir)) {
			mkdir($lockDir,self::UMASK, true);
		}
		return true;
	}
	/** Get lock.
	 *  @param str  The key of record.
	 *  @param bool nowait Indicate f set lock is non-block.
	 *  @return bool True:succ;False:fail.
	 */
	public function wLock($key, $nowait = false) {
		$flag = LOCK_EX;
		if($nowait) {		
			$flag |= LOCK_NB;
		}
		if(false === ($fp = $this->openLockFile($key))) {
			return false;
		}
		return @flock($fp, $flag);
	}
	/** Release lock. 
	 *  @param str The key of record;
	 *  @return bool True:succ;False:fail.
	 */
	public function unWLock($key) {
		if(false === array_key_exists($key, $this->fps)) {
			return false;
		}
		$ret = @flock($this->fps[$key], LOCK_UN);
		unset($this->fps[$key]);
		return $ret;
	}
	/** Get value by one key.
	 *  @param str key The key of record in share memory.
	 *  @param mixed value The reference var for getting a value.
	 *  @param bool If succ, return true and value has return value;
	 				If record was not exist, return false, and value is reset to Null;
	 				If record was timeout, return false, and value is timeout-value.
	 */
	public function get($key, &$value) {
		$s_key = $this->srvName.(string)$key;
		if(false === ($v = @\apcu_fetch($s_key))) {
			if (false === ($s_value = @file_get_contents($this->getLockFile($key)))) {
				$value = Null;
				return false;
			}
			if(false === ($v = unserialize($s_value))) {
				$value = Null;
				return false;
			}
			$value = $v['value'];
			$timestamp = (int)(microtime(true)*1000);
			if($v['timestamp'] != 0) {
				//timeout
				if($v['timestamp'] <= $timestamp) {
					return false;
				}
			} else {
			    @\apcu_store($s_key, $value, 0);
			    return true;
			}
			$apcu_ttl = (int)(($v['timestamp'] - $timestamp)/1000);
			if($apcu_ttl > 0) {
			    @\apcu_store($s_key, $value, $apcu_ttl);
			}
			return true;
			
		}else {
			$value = $v;
			return true;
		}
	}
	/** Put value by one key.Need to wLock before put in multiprocess env.
	 *  @param str key The key of record in cache.
	 *  @param mixed value The value of record in cache.
	 *  @param int ttl The millisecond of record time-to-live, default is 0
	 *  @return bool True:succ;False:fail.
	 */
	public function put($key, $value, $ttl=0){
		$s_key = $this->srvName.(string)$key;
		if($ttl < 0) {
		    return;
		}
		$apcu_ttl = (int)($ttl/1000);
		if($apcu_ttl != 0) {
		    @\apcu_store($s_key, $value, $apcu_ttl);
		}
		$timestamp = 0;
		if($ttl > 0) {
			$timestamp = (int)(microtime(true)*1000) + $ttl;
		}
		$s_value = serialize(array('timestamp'=>$timestamp,'value'=>($value)));
		$tmp_file = $this->getLockFile(".tmp".$s_key);
		@file_put_contents($tmp_file,$s_value);
		@rename($tmp_file, $this->getLockFile($key));
		return true;		
	}
	public function exist($key) {
		return $this->get($key, $value);
	}
	public function delete($key) {
		$s_key = $this->srvName.(string)$key;
		$ret = @\apcu_delete($s_key);
		$ret &= @unlink($this->getLockFile($key));
		return $ret;
	}
}

