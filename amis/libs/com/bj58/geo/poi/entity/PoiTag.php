<?php

namespace com\bj58\geo\poi\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class PoiTag {

    static $_TSPEC;
    static $_SCFNAME = 'PoiTag';
    private $id;
    private $name;

    public function __construct($id = '', $name = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'id',
                    'sortId' => 1,
                    'type' => SCFType::I64,
                ),
                2 => array(
                    'var' => 'name',
                    'sortId' => 2,
                    'type' => SCFType::STRING,
                ),
            );
        }
       $this->id = $id;
        $this->name = $name;
    }

    public static function getTSPEC() {
        return PoiTag::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        PoiTag::$_TSPEC = $_TSPEC;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
}
