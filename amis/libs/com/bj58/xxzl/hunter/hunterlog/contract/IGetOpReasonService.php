<?php
namespace com\bj58\xxzl\hunter\hunterlog\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;

class IGetOpReasonService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function getDeleteReasonByInfoId($userId = '', $infoId = '', $opType = '') {
//		$key = $this->ps->getInitObj();
		$value = array(
			'1@String' => $userId,
			'2@String' => $infoId,
			'3@int' => $opType,
		);
		$res = $this->ps->invoke('getDeleteReasonByInfoId', $value, true);
		return $res;
	}

}