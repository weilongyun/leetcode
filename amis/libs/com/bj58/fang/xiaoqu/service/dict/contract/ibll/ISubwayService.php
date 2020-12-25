<?php

namespace com\bj58\fang\xiaoqu\service\dict\contract\ibll;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\fang\xiaoqu\service\dict\contract\entitys\TrafficLine;
use com\bj58\fang\xiaoqu\service\dict\contract\dto\TrafficStationDTO;
use com\bj58\fang\xiaoqu\service\dict\contract\dto\TrafficLineDTO;
use com\bj58\fang\xiaoqu\service\dict\contract\entitys\TrafficStation;
use com\bj58\fang\xiaoqu\service\dict\contract\enums\StationCount;
use com\bj58\fang\xiaoqu\service\dict\contract\enums\StationDistance;

class ISubwayService {

    public $ps;

    public function __construct($serviceName = '', $lookup = '', $initObj = '') {
        $ps = new ProxyStandard($serviceName, $lookup, $initObj);
        $this->ps = $ps;
    }

    public function getSubLineByCity($cityid = '') {
        ObjectSerializer::GetTypeInfo(new TrafficLine());
        $value = array(
            '1@int' => $cityid,
        );
        $res = $this->ps->invoke('getSubLineByCity', $value);
        return $res;
    }

    public function getSubLineByCityNoCache($cityid = '') {
        ObjectSerializer::GetTypeInfo(new TrafficLine());
        $value = array(
            '1@int' => $cityid,
        );
        $res = $this->ps->invoke('getSubLineByCityNoCache', $value);
        return $res;
    }

    public function getSubStationsByLineid($lineid = '') {
        ObjectSerializer::GetTypeInfo(new TrafficStation());
        ObjectSerializer::GetTypeInfo(new StationDistance());  
        ObjectSerializer::GetTypeInfo(new StationCount());  
        ObjectSerializer::GetTypeInfo(new TrafficLine());
        
        $value = array(
            '1@int' => $lineid,
        );
        $res = $this->ps->invoke('getSubStationsByLineid', $value);
        return $res;
    }

    public function getSubStationsByLineidNoCache($lineid = '') {
        ObjectSerializer::GetTypeInfo(new TrafficStation());
        $value = array(
            '1@int' => $lineid,
        );
        $res = $this->ps->invoke('getSubStationsByLineidNoCache', $value);
        return $res;
    }

    public function getSubLineByStationid($stationid = '') {
        ObjectSerializer::GetTypeInfo(new TrafficLine());
        $value = array(
            '1@int' => $stationid,
        );
        $res = $this->ps->invoke('getSubLineByStationid', $value);
        return $res;
    }

    public function updateSubline($trafficLine = '') {
        $value = array(
            '1@TrafficLine' => $trafficLine,
        );
        $res = $this->ps->invoke('updateSubline', $value);
        return $res;
    }

    public function deleteSubLine($sublineid = '') {
        $value = array(
            '1@int' => $sublineid,
        );
        $res = $this->ps->invoke('deleteSubLine', $value);
        return $res;
    }

    public function updateSubstation($subStation = '') {
        $value = array(
            '1@TrafficStation' => $subStation,
        );
        $res = $this->ps->invoke('updateSubstation', $value);
        return $res;
    }

    public function deleteSubstation($substationid = '') {
        $value = array(
            '1@int' => $substationid,
        );
        $res = $this->ps->invoke('deleteSubstation', $value);
        return $res;
    }

    public function fetchNearSubstation($lat = '', $lon = '', $distance = '', $count = '') {
        ObjectSerializer::GetTypeInfo(new TrafficStation());
        $value = array(
            '1@double' => $lat,
            '2@double' => $lon,
            '3@double' => $distance,
            '4@int' => $count,
        );
        $res = $this->ps->invoke('fetchNearSubstation', $value);
        return $res;
    }

    public function fetchNearSubstationDTOMap($infoids = '', $distance = '', $count = '') {
        ObjectSerializer::GetTypeInfo(new TrafficStationDTO());  
        ObjectSerializer::GetTypeInfo(new TrafficLineDTO());          
        ObjectSerializer::GetTypeInfo(new StationDistance());  
        ObjectSerializer::GetTypeInfo(new StationCount());          
        $value = array(
            '1@List<Integer>' => $infoids,
            '2@StationDistanceEnum' => $distance,
            '3@StationCountEnum' => $count,          
        );
        $res = $this->ps->invoke('fetchNearSubstationDTOMap', $value);
        return $res;
    } 

    public function selectSubline($ids = '') {
        ObjectSerializer::GetTypeInfo(new TrafficLine());
        $value = array(
            '1@long[]' => $ids,
        );
        $res = $this->ps->invoke('selectSubline', $value);
        return $res;
    }

    public function selectSubstation($ids = '') {
        ObjectSerializer::GetTypeInfo(new TrafficStation());
        $value = array(
            '1@long[]' => $ids,
        );
        $res = $this->ps->invoke('selectSubstation', $value);
        return $res;
    }

    public function getLineCountByCondition($where = '') {
        $value = array(
            '1@String' => $where,
        );
        $res = $this->ps->invoke('getLineCountByCondition', $value);
        return $res;
    }

    public function getStationCountByCondition($where = '') {
        $value = array(
            '1@String' => $where,
        );
        $res = $this->ps->invoke('getStationCountByCondition', $value);
        return $res;
    }

    public function getSublinepageByRowNumber($where = '', $currentpage = '', $pagesize = '', $sortField = '', $sortType = '') {
        ObjectSerializer::GetTypeInfo(new TrafficLine());
        $value = array(
            '1@String' => $where,
            '2@int' => $currentpage,
            '3@int' => $pagesize,
            '4@String' => $sortField,
            '5@String' => $sortType,
        );
        $res = $this->ps->invoke('getSublinepageByRowNumber', $value);
        return $res;
    }

    public function getSubsattionpageByRowNumber($where = '', $currentpage = '', $pagesize = '', $sortField = '', $sortType = '') {
        ObjectSerializer::GetTypeInfo(new TrafficStation());
        $value = array(
            '1@String' => $where,
            '2@int' => $currentpage,
            '3@int' => $pagesize,
            '4@String' => $sortField,
            '5@String' => $sortType,
        );
        $res = $this->ps->invoke('getSubsattionpageByRowNumber', $value);
        return $res;
    }

    public function getSubLineByStationIds($idList = '') {
        ObjectSerializer::GetTypeInfo(new TrafficLine());
        $value = array(
            '1@List<Integer>' => $idList,
        );
        $res = $this->ps->invoke('getSubLineByStationIds', $value);
        return $res;
    }

    public function getSubstationById($stationid = '') {
        ObjectSerializer::GetTypeInfo(new TrafficStation());
        $value = array(
            '1@int' => $stationid,
        );
        $res = $this->ps->invoke('getSubstationById', $value);
        return $res;
    }

    public function insertSubstation($station = '') {
        $value = array(
            '1@TrafficStation' => $station,
        );
        $res = $this->ps->invoke('insertSubstation', $value);
        return $res;
    }

    public function insertSubline($line = '') {
        $value = array(
            '1@TrafficLine' => $line,
        );
        $res = $this->ps->invoke('insertSubline', $value);
        return $res;
    }

    public function getBeforeAfterStation($trafficStation = '') {
        ObjectSerializer::GetTypeInfo(new TrafficStation());
        $value = array(
            '1@TrafficStation' => $trafficStation,
        );
        $res = $this->ps->invoke('getBeforeAfterStation', $value);
        return $res;
    }
}
