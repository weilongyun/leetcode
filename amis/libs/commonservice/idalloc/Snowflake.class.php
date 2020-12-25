<?php

namespace Libs\CommonService\IdAlloc;

/**
 * Copyright 2015
 *
 * PHP implementation of Twitter's Snowflake Unique ID generation service
 *
 * @author skey <skey@115.com>
 * @see https://github.com/golangfan/phpsnowflake
 */
define ( "SNOWFLAKE_WORKERID_BITS", 5 );
define ( "SNOWFLAKE_DATACENTERID_BITS", 5 );
define ( "SNOWFLAKE_SEQUENCE_BITS", 12 );
define ( "SNOWFLAKE_MAX_WORKERID", - 1 ^ (- 1 << SNOWFLAKE_WORKERID_BITS) );
define ( "SNOWFLAKE_MAX_DATACENTERID", - 1 ^ (- 1 << SNOWFLAKE_DATACENTERID_BITS) );
define ( "SNOWFLAKE_WORKERID_SHIFT", SNOWFLAKE_SEQUENCE_BITS );
define ( "SNOWFLAKE_DATACENTERID_SHIFT", SNOWFLAKE_SEQUENCE_BITS + SNOWFLAKE_WORKERID_BITS );
define ( "SNOWFLAKE_TIMESTAMPLEFT_SHIFT", SNOWFLAKE_SEQUENCE_BITS + SNOWFLAKE_WORKERID_BITS + SNOWFLAKE_DATACENTERID_BITS );
define ( "SNOWFLAKE_SEQUENCE_MASK", - 1 ^ (- 1 << SNOWFLAKE_SEQUENCE_BITS) );
define ( "SNOWFLAKE_EPOCH", 1420041600000 );	//2015-01-01 00:00:00

class Snowflake {
	private $workerid;
	private $datacenterid;
	private $sequence = 0;
	private $last_timestamp = 1;
	
	public function __construct($workerid = 1, $datacenerid = 1) {
		$workerid = floor ( $workerid );
		$datacenerid = floor ( $datacenerid );
		if ($workerid > SNOWFLAKE_MAX_WORKERID || $workerid < 0) {
			trigger_error ( sprintf ( "workerid can't be greater than %d or less than 0", $workerid ) );
			return false;
		}
		if ($datacenerid > SNOWFLAKE_MAX_DATACENTERID || $datacenerid < 0) {
			trigger_error ( sprintf ( "datacenterid can't be greater than %d or less than 0", $workerid ) );
			return false;
		}
		$this->workerid = $workerid;
		$this->datacenterid = $datacenerid;
	}
	public function get_nextid() {
		$timestamp = $this->get_timestamp ();
		if ($timestamp < $this->last_timestamp) {
			trigger_error ( sprintf ( "Clock is moving backwards. Rejecting requests until %d.", $timestamp ) );
			return false;
		}
		if ($timestamp == $this->last_timestamp) {
			$this->sequence = $this->sequence + 1 & SNOWFLAKE_SEQUENCE_MASK;
			if ($this->sequence == 0) {
				$next_timestamp = $this->get_timestamp ();
				while ( $next_timestamp <= $timestamp ) {
					$next_timestamp = $this->get_timestamp ();
				}
				$timestamp = $next_timestamp;
			}
		} else {
			$this->sequence = 0;
		}
		$this->last_timestamp = $timestamp;
		return (($this->last_timestamp - SNOWFLAKE_EPOCH) << SNOWFLAKE_TIMESTAMPLEFT_SHIFT) | ($this->datacenterid << SNOWFLAKE_DATACENTERID_SHIFT) | ($this->workerid << SNOWFLAKE_WORKERID_SHIFT) | $this->sequence;
	}
	public function get_wokerid() {
		return $this->workerid;
	}
	public function get_sequence() {
		return $this->sequence;
	}
	public function get_timestamp() {
		return floor ( microtime ( true ) * 1000 );
	}
	
	public static function getMaxWorkerId(){
		return SNOWFLAKE_MAX_WORKERID;
	}
	public static function getMaxDatacenterId(){
		return SNOWFLAKE_MAX_DATACENTERID;
	}
}
