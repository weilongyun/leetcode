<?php

namespace com\bj58\geo\poi\entity;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\geo\poi\entity\PoiEntity;

class PoiResultEntity {

    static $_TSPEC;
    static $_SCFNAME = 'PoiResultEntity';
    private $poiList;
    private $totalCount;

    public function __construct($poiList = '', $totalCount = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'poiList',
                    'sortId' => 1,
                    'type' => SCFType::LST,
                    'elem' => array(
                        'type' => SCFType::OBJECT,
                        'class' => new PoiEntity(),
                    ),
                ),
                2 => array(
                    'var' => 'totalCount',
                    'sortId' => 2,
                    'type' => SCFType::I64,
                ),
            );
        }
        $this->poiList = $poiList;
        $this->totalCount = $totalCount;
    }

    public static function getTSPEC() {
        return PoiResultEntity::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        PoiResultEntity::$_TSPEC = $_TSPEC;
    }

    public function getPoiList() {
        return $this->poiList;
    }

    public function setPoiList($poiList) {
        $this->poiList = $poiList;
    }

    public function getTotalCount() {
        return $this->totalCount;
    }

    public function setTotalCount($totalCount) {
        $this->totalCount = $totalCount;
    }
}
