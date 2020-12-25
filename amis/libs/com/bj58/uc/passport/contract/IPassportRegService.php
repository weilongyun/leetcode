<?php
namespace com\bj58\uc\passport\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;

use com\bj58\uc\passport\entry\ParterAuth;
use com\bj58\uc\passport\entry\reg\MobileRegUser;
use com\bj58\uc\passport\entry\RequestInfo;
use com\bj58\uc\passport\contract\result\RegResult;

class IPassportRegService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function mobileRegister($parterAuth = '', $mobileRegUser = '', $requestInfo = '') {
		ObjectSerializer::GetTypeInfo(new MobileRegUser());
		ObjectSerializer::GetTypeInfo(new RegResult());
		ObjectSerializer::GetTypeInfo(new ParterAuth());
		ObjectSerializer::GetTypeInfo(new RequestInfo());
		$value = array(
			'1@ParterAuth' => $parterAuth,
			'2@MobileRegUser' => $mobileRegUser,
			'3@RequestInfo' => $requestInfo,
		);
		$res = $this->ps->invoke('mobileRegister', $value);
		return $res;
	}

}