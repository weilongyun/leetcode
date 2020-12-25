<?php

namespace Libs\Wmonitor;

class WMonitorRBI {

    public static function setRBI($attributeId, $value) {
        if (empty($attributeId)) return;
        try{
            $Wmonitor = WMonitor::getInstance();
            $Wmonitor->sum($attributeId, $value);
        }  catch (\Exception $ex) {
        }
    }

    public static function setAvgRBI($attributeId, $value, $count=1) {
        if (empty($attributeId)) return;
        try {
            $Wmonitor = WMonitor::getInstance();
            $Wmonitor->average($attributeId, $value,$count);
        } catch (\Exception $ex) {
        }
    }

}

