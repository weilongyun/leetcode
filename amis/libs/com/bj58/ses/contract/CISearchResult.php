<?php

namespace com\bj58\ses\contract;

use com\bj58\spat\scf\serialize\component\SCFType;

class CISearchResult {

    static $_TSPEC;
    static $_SCFNAME = 'CISearchResult';
    private $totalCount;
    private $objectIds;
    private $sortIds;
    private $segmentWord;
    private $sortName;
    private $sortMode;

    public function __construct($totalCount = '', $objectIds = '', $sortIds = '', $segmentWord = '', $sortName = '', $sortMode = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'totalCount',
                    'sortId' => 1,
                    'type' => SCFType::I64,
                ),
                2 => array(
                    'var' => 'objectIds',
                    'sortId' => 2,
                    'type' => SCFType::LST,
                    'elem' => array(
                        'type' => SCFType::I64,
                    ),
                ),
                3 => array(
                    'var' => 'sortIds',
                    'sortId' => 3,
                    'type' => SCFType::LST,
                    'elem' => array(
                        'type' => SCFType::DOUBLE,
                    ),
                ),
                4 => array(
                    'var' => 'segmentWord',
                    'sortId' => 4,
                    'type' => SCFType::STRING,
                ),     
                5 => array(
                    'var' => 'sortName',
                    'sortId' => 5,
                    'type' => SCFType::STRING,
                ),
                6 => array(
                    'var' => 'sortMode',
                    'sortId' => 6,
                    'type' => SCFType::STRING,
                ),
            );
        }
    }

    public static function getTSPEC() {
        return CISearchResult::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        CISearchResult::$_TSPEC = $_TSPEC;
    }

    public function getTotalCount() {
        return $this->totalCount;
    }

    public function setTotalCount($totalCount) {
        $this->totalCount = $totalCount;
    }

    public function getObjectIds() {
        return $this->objectIds;
    }

    public function setObjectIds($objectIds) {
        $this->objectIds = $objectIds;
    }

    public function getSortIds() {
        return $this->sortIds;
    }

    public function setSortIds($sortIds) {
        $this->sortIds = $sortIds;
    }

    public function getSegmentWord() {
        return $this->segmentWord;
    }

    public function setSegmentWord($segmentWord) {
        $this->segmentWord = $segmentWord;
    }

    public function getSortName() {
        return $this->sortName;
    }

    public function setSortName($sortName) {
        $this->sortName = $sortName;
    }

    public function getSortMode() {
        return $this->sortMode;
    }

    public function setSortMode($sortMode) {
        $this->sortMode = $sortMode;
    }
}
