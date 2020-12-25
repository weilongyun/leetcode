<?php

namespace Libs\CommonService\IdAlloc;

class IdAllocClient {
	const EPOCH = 1420041600000; // 2015-01-01 00:00:00
	private $workerId = null;
	private $localSnowflake = null;
	
	/**
	 */
	private function __construct($config = array()) {
		if (is_array ( $config ) && isset ( $config ['worker_id'] )) {
			$workerId = $config ['worker_id'];
		}
		
		if (is_array ( $config ) && isset ( $config ['datacenter_id'] )) {
			$datacenterId = $config ['datacenter_id'];
		}
		
		$this->localSnowflake = $this->getLocalSnowflake ( $workerId, $datacenterId );
	}
	
	/**
	 *
	 * @param array $config        	
	 * @return \Libs\CommonService\IdAlloc\IdAllocClient
	 */
	public static function getClient($config) {
		return new self ( $config );
	}
	
	/**
	 * generate a local snowflake instance
	 *
	 * @param string $workerId        	
	 * @return unknown
	 */
	private function getLocalSnowflake($workerId = null, $datacenterId = null) {
		if (! $workerId) {
			$workerId = getmypid ();
		}
		if ($workerId > Snowflake::getMaxWorkerId ()) {
			$workerId = $workerId % Snowflake::getMaxWorkerId ();
		}
		
		if (! $dataCenterId) {
			$dataCenterId = ip2long ( $_SERVER ['SERVER_ADDR'] );
		}
		if ($dataCenterId > Snowflake::getMaxDatacenterId ()) {
			$dataCenterId = $dataCenterId % Snowflake::getMaxDatacenterId ();
		}
		
		$sn = new Snowflake ( $workerId, $dataCenterId );
		return $sn;
	}
	/**
	 * get the next unique id
	 *
	 * @return int
	 */
	public function getId() {
		$id = $this->getIdBySnowflakeService ();
		if (! $id) {
			$id = $this->getIdByLocalSnowflake ();
		}
		
		return $id;
	}
	private function getIdBySnowflakeService() {
		return null;
	}
	private function getIdByLocalSnowflake() {
		$sn = $this->localSnowflake;
		$id = $sn->get_nextid ();
		return $id;
	}
}