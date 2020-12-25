<?php
namespace com\bj58\dia\recommend\displayservice\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\dia\recommend\displayservice\entity\RecommendBusinessRequestEntity;
use com\bj58\dia\recommend\displayservice\entity\RecommendOutputEntity;
use com\bj58\dia\recommend\displayservice\entity\RecommendCommonRequestEntity;

class IRecommendDisplayService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function getRecommend($commonRequest = '', $businessRequest = '') {
		ObjectSerializer::GetTypeInfo(new RecommendOutputEntity());
		$value = array(
			'1@RecommendCommonRequestEntity' => $commonRequest,
			'2@RecommendBusinessRequestEntity' => $businessRequest,
		);
		$res = $this->ps->invoke('getRecommend', $value);
		return $res;
	}

}