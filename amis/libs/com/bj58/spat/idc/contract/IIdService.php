<?php
namespace com\bj58\spat\idc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;

class IIdService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function get() {
		$value = array(
		);
		$res = $this->ps->invoke('get', $value);
		return $res;
	}

	public function get_PHP_2($businessid = '') {
		$value = array(
			'1@long' => $businessid,
		);
		$res = $this->ps->invoke('get_PHP_2', $value);
		return $res;
	}

}