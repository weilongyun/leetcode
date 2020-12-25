<?php
namespace WTable\util;

class Blacklist{
	const BLACKLIST_TTL = 600;
	const DEFAULT_THRESHOLD = 3;
	private $srvName;
	private $threshold;
	
	public function __construct($srvName,$threshold=self::DEFAULT_THRESHOLD) {
		$this->srvName = $srvName;
		$this->threshold = $threshold;
	}

	public function reset($key) {
		$s_key = $this->srvName.(string)$key;
		@\apcu_store($s_key, 0, self::BLACKLIST_TTL);
	}
	
	public function inc($key) {
		$s_key = $this->srvName.(string)$key;
		if (@\apcu_exists($s_key)){
			$ret = @\apcu_inc($s_key);
			//echo  date('Y-m-d H:i:s')."</br>";
			//echo "apcu inc = ".$ret.PHP_EOL;
		} else {
			@\apcu_store($s_key, 1, self::BLACKLIST_TTL);
			//echo  date('Y-m-d H:i:s')."</br>";
			//echo "apcu store = 1".PHP_EOL;
		}
	}
	
	public function invalid($key) {
		$s_key = $this->srvName.(string)$key;
		if(false === ($v = @\apcu_fetch($s_key))) {
			return false;
		}
		if ($v >= $this->threshold) {
			//echo "blocklist key=".$s_key.",value=".$v."</br>";
			return true;
		}
		return false;
	}
}
