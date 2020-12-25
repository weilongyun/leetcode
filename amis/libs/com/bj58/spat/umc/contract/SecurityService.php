<?php
namespace com\bj58\spat\umc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;

class SecurityService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function register($name = '', $password = '', $email = '', $ip = '', $cityid = '', $source = '') {
		$value = array(
			'1@String' => $name,
			'2@String' => $password,
			'3@String' => $email,
			'4@String' => $ip,
			'5@int' => $cityid,
			'6@String' => $source,
		);
		$res = $this->ps->invoke('register', $value);
		return $res;
	}

	public function login($name = '', $password = '', $ip = '', $cityid = '', $source = '') {
		$value = array(
			'1@String' => $name,
			'2@String' => $password,
			'3@String' => $ip,
			'4@int' => $cityid,
			'5@String' => $source,
		);
		$res = $this->ps->invoke('login', $value);
		return $res;
	}

	public function loginByEmail($email = '', $password = '', $ip = '', $cityid = '', $source = '') {
		$value = array(
			'1@String' => $email,
			'2@String' => $password,
			'3@String' => $ip,
			'4@int' => $cityid,
			'5@String' => $source,
		);
		$res = $this->ps->invoke('loginByEmail', $value);
		return $res;
	}

	public function loginByMobile($mobile = '', $password = '', $ip = '', $cityid = '', $source = '') {
		$value = array(
			'1@String' => $mobile,
			'2@String' => $password,
			'3@String' => $ip,
			'4@int' => $cityid,
			'5@String' => $source,
		);
		$res = $this->ps->invoke('loginByMobile', $value);
		return $res;
	}

	public function login_PHP_2($uid = '', $ip = '', $cityid = '', $source = '') {
		$value = array(
			'1@long' => $uid,
			'2@String' => $ip,
			'3@int' => $cityid,
			'4@String' => $source,
		);
		$res = $this->ps->invoke('login_PHP_2', $value);
		return $res;
	}

	public function changePassword($uid = '', $oldPassword = '', $newPassword = '') {
		$value = array(
			'1@long' => $uid,
			'2@String' => $oldPassword,
			'3@String' => $newPassword,
		);
		$res = $this->ps->invoke('changePassword', $value);
		return $res;
	}

	public function changePassword_PHP_2($uid = '', $newPassword = '') {
		$value = array(
			'1@long' => $uid,
			'2@String' => $newPassword,
		);
		$res = $this->ps->invoke('changePassword_PHP_2', $value);
		return $res;
	}

	public function changePasswordSalt($uid = '', $newPassword = '') {
		$value = array(
			'1@long' => $uid,
			'2@String' => $newPassword,
		);
		$res = $this->ps->invoke('changePasswordSalt', $value);
		return $res;
	}

	public function setAgent($uid = '', $cateId = '') {
		$value = array(
			'1@long' => $uid,
			'2@int' => $cateId,
		);
		$res = $this->ps->invoke('setAgent', $value);
		return $res;
	}

	public function cancelAgent($uid = '', $cateId = '') {
		$value = array(
			'1@long' => $uid,
			'2@int' => $cateId,
		);
		$res = $this->ps->invoke('cancelAgent', $value);
		return $res;
	}

	public function checkPwd($uid = '', $pwd = '', $features = '') {
		$value = array(
			'1@long' => $uid,
			'2@String' => $pwd,
			'3@String' => $features,
		);
		$res = $this->ps->invoke('checkPwd', $value);
		return $res;
	}

}