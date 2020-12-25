<?php
namespace com\bj58\xxzl\captcha\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;

class IVoiceService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function callPhone($getRequest = '', $responseid = '') {
		$value = array(
			'1@CaptchaRequestV2' => $getRequest,
			'2@String' => $responseid,
		);
		$res = $this->ps->invoke('callPhone', $value);
		return $res;
	}

	public function getVerifyCode($telNum = '') {
		$value = array(
			'1@String' => $telNum,
		);
		$res = $this->ps->invoke('getVerifyCode', $value);
		return $res;
	}

	public function callbackHW($ret = '') {
		$value = array(
			'1@Map<key = String, value = String[]>' => $ret,
		);
		$res = $this->ps->invoke('callbackHW', $value);
		return $res;
	}

}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */