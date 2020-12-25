<?php
namespace com\bj58\ipserver\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\ipserver\domain\IpInfo;
use com\bj58\ipserver\domain\IpLocal;

class IIpService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function getIpLocal($ipAddress = '') {
		ObjectSerializer::GetTypeInfo(new IpLocal());
		$value = array(
			'1@String' => $ipAddress,
		);
		$res = $this->ps->invoke('getIpLocal', $value);
		return $res;
	}

	public function getIpInfo($ipAddress = '') {
		ObjectSerializer::GetTypeInfo(new IpInfo());
		$value = array(
			'1@String' => $ipAddress,
		);
		$res = $this->ps->invoke('getIpInfo', $value);
		return $res;
	}

}