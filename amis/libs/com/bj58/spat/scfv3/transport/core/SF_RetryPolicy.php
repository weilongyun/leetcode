<?php
namespace com\bj58\spat\scf\transport\core;
class SF_RetryPolicy {
	public static  $DEFAULT_INTERVAL=0;
	public static  $DEFAULT_RETRY_TIMES=3;
	/**
	 * 重试次数
	 * @var unknown
	 */
	private  $retryTimes;
	/**
	 * 重试的时间间隔
	 * @var unknown
	 */
	private  $retryInterval = 1;

	function __construct($retryTimes,$retryInterval) {
		$this->retryTimes = $retryTimes;
		$this->retryInterval = $retryInterval;
	}

	function times() {
		return $this->retryTimes;
	}

	function interval() {
		return $this->retryInterval;
	}

	function  __set($field, $value) {
		$this->$field=$value;
	}
}