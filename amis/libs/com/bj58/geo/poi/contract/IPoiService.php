<?php

namespace com\bj58\geo\poi\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\geo\poi\entity\PoiSearchRequest;
use com\bj58\geo\poi\entity\PoiResultEntity;
use com\bj58\geo\common\geometry\Circle;
use com\bj58\geo\common\geometry\BoundingBox;
use com\bj58\geo\common\geometry\Point;
use com\bj58\geo\poi\entity\PoiEntity;
use com\bj58\geo\poi\entity\PoiTag;

class IPoiService {

    public $ps;

    public function __construct($serviceName = '', $lookup = '', $initObj = '') {
        $ps = new ProxyStandard($serviceName, $lookup, $initObj);
        $this->ps = $ps;
    }

    public function searchPoi($request = '') {
        ObjectSerializer::GetTypeInfo(new PoiSearchRequest());
        ObjectSerializer::GetTypeInfo(new PoiResultEntity());
        ObjectSerializer::GetTypeInfo(new Circle());
        ObjectSerializer::GetTypeInfo(new BoundingBox());
        ObjectSerializer::GetTypeInfo(new Point());
        ObjectSerializer::GetTypeInfo(new PoiEntity());
        ObjectSerializer::GetTypeInfo(new PoiTag());

        $value = array(
            '1@PoiSearchRequest' => $request,
        );

        $res = $this->ps->invoke('searchPoi', $value);
        return $res;
    }

    public function getPoi($ids = '') {
        ObjectSerializer::GetTypeInfo(new PoiResultEntity());
        $value = array(
            '1@List<Long>' => $ids,
        );
        $res = $this->ps->invoke('getPoi', $value);
        return $res;
    }
}
