<?php
namespace com\bj58\spat\umc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\spat\umc\entity\UserV2;

class AuthorizedFangchanV2Service {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function getUsersByUid($uids = '', $ps = '', $data = array()) {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@Long[]' => $uids,
			'2@Integer[]' => $ps,
			'3@Map<key = String, value = String>' => $data,
		);
		$res = $this->ps->invoke('getUsersByUid', $value);
		return $res;
	}

	public function getUserByName($str = '', $ps = '', $data = array()) {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@String' => $str,
			'2@Integer[]' => $ps,
			'3@Map<key = String, value = String>' => $data,
		);
		$res = $this->ps->invoke('getUserByName', $value);
		return $res;
	}

	public function getUserByEmail($str = '', $ps = '', $data = array()) {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@String' => $str,
			'2@Integer[]' => $ps,
			'3@Map<key = String, value = String>' => $data,
		);
		$res = $this->ps->invoke('getUserByEmail', $value);
		return $res;
	}

	public function getUserByMobile($str = '', $ps = '', $data = array()) {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@String' => $str,
			'2@Integer[]' => $ps,
			'3@Map<key = String, value = String>' => $data,
		);
		$res = $this->ps->invoke('getUserByMobile', $value);
		return $res;
	}

	public function getUsersByMobileAll($str = '', $ps = '', $data = array()) {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@String' => $str,
			'2@Integer[]' => $ps,
			'3@Map<key = String, value = String>' => $data,
		);
		$res = $this->ps->invoke('getUsersByMobileAll', $value);
		return $res;
	}

	public function addUserTag($uid = '', $level1CateId = '') {
		$value = array(
			'1@long' => $uid,
			'2@int' => $level1CateId,
		);
		$res = $this->ps->invoke('addUserTag', $value);
		return $res;
	}

	public function removeUserTag($uid = '', $level1CateId = '') {
		$value = array(
			'1@long' => $uid,
			'2@int' => $level1CateId,
		);
		$res = $this->ps->invoke('removeUserTag', $value);
		return $res;
	}

}
