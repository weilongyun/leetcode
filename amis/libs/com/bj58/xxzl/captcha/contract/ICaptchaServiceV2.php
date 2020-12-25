<?php
namespace com\bj58\xxzl\captcha\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\xxzl\captcha\entityV2\CaptchaResponseV2;
use com\bj58\xxzl\captcha\entityV2\CaptchaCheckResultV2;

class ICaptchaServiceV2 {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function getCaptchaV2($request = '') {
		ObjectSerializer::GetTypeInfo(new CaptchaResponseV2());
		$value = array(
			'1@CaptchaRequestV2' => $request,
		);
		$res = $this->ps->invoke('getCaptchaV2', $value);
		return $res;
	}

	public function checkCaptchaV2($request = '', $checkedCount = '') {
		ObjectSerializer::GetTypeInfo(new CaptchaCheckResultV2());
		$value = array(
			'1@CaptchaCheckRequestV2' => $request,
			'2@Integer' => $checkedCount,
		);
		$res = $this->ps->invoke('checkCaptchaV2', $value);
		return $res;
	}

	public function getEncryRequest($request = '') {
		$value = array(
			'1@CaptchaRequestV2' => $request,
		);
		$res = $this->ps->invoke('getEncryRequest', $value);
		return $res;
	}

}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */