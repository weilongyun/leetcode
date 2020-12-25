<?php
namespace com\bj58\sfb\queryrecClient\contract;

use com\bj58\sfb\queryrecClient\entity\QueryRecRequest;
use com\bj58\sfb\queryrecClient\entity\QueryRecResponse;
use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;

class QueryRecScfInterface {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function getRecommendations($query = '') {
		ObjectSerializer::GetTypeInfo(new QueryRecRequest());
		ObjectSerializer::GetTypeInfo(new QueryRecResponse());

		$value = array(
			'1@QueryRecRequest' => $query,
		);
		$res = $this->ps->invoke('getRecommendations', $value);
		return $res;
	}

}