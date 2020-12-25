<?php
namespace com\bj58\spat\umc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\spat\umc\entity\CreditItem;
use com\bj58\spat\umc\entity\UserV2;

class UserV2Service {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function get($uid = '', $ps = '') {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@long' => $uid,
			'2@Integer[]' => $ps,
		);
		$res = $this->ps->invoke('get', $value);
		return $res;
	}

	public function getByName($name = '', $ps = '') {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@String' => $name,
			'2@Integer[]' => $ps,
		);
		$res = $this->ps->invoke('getByName', $value);
		return $res;
	}

	public function getByEmail($email = '', $ps = '') {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@String' => $email,
			'2@Integer[]' => $ps,
		);
		$res = $this->ps->invoke('getByEmail', $value);
		return $res;
	}

	public function getByMobile($mobile = '', $ps = '') {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@String' => $mobile,
			'2@Integer[]' => $ps,
		);
		$res = $this->ps->invoke('getByMobile', $value);
		return $res;
	}

	public function getByMobileAll($mobile = '', $ps = '') {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@String' => $mobile,
			'2@Integer[]' => $ps,
		);
		$res = $this->ps->invoke('getByMobileAll', $value);
		return $res;
	}

	public function getMulti($uids = '', $ps = '') {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@Long[]' => $uids,
			'2@Integer[]' => $ps,
		);
		$res = $this->ps->invoke('getMulti', $value);
		return $res;
	}

	public function update($user = '') {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@UserV2' => $user,
		);
		$res = $this->ps->invoke('update', $value);
		return $res;
	}

	public function addCredit($uid = '', $count = '', $action = '', $description = '') {
		$value = array(
			'1@long' => $uid,
			'2@int' => $count,
			'3@int' => $action,
			'4@String' => $description,
		);
		$res = $this->ps->invoke('addCredit', $value);
		return $res;
	}

	public function getCreditHistory($uid = '', $pageSize = '', $currentPage = '') {
		ObjectSerializer::GetTypeInfo(new CreditItem());
		$value = array(
			'1@long' => $uid,
			'2@int' => $pageSize,
			'3@int' => $currentPage,
		);
		$res = $this->ps->invoke('getCreditHistory', $value);
		return $res;
	}

	public function getByFaceVerified($startTime = '', $endTime = '', $faceVerified = '', $pageSize = '', $currentPage = '', $ps = '') {
		ObjectSerializer::GetTypeInfo(new UserV2());
		$value = array(
			'1@Date' => $startTime,
			'2@Date' => $endTime,
			'3@Boolean' => $faceVerified,
			'4@int' => $pageSize,
			'5@int' => $currentPage,
			'6@Integer[]' => $ps,
		);
		$res = $this->ps->invoke('getByFaceVerified', $value);
		return $res;
	}

	public function removeUserCache($uid = '') {
		$value = array(
			'1@long' => $uid,
		);
		$res = $this->ps->invoke('removeUserCache', $value);
		return $res;
	}

	public function initUserData($uid = '') {
		$value = array(
			'1@long' => $uid,
		);
		$res = $this->ps->invoke('initUserData', $value);
		return $res;
	}

}