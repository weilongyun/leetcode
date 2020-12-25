<?php

namespace com\bj58\geo\poi\entity;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\geo\common\geometry\Point;
use com\bj58\geo\poi\entity\PoiTag;

class PoiEntity {

    static $_TSPEC;
    static $_SCFNAME = 'PoiEntity';
    private $id;
    private $name;
    private $address;
    private $location;
    private $type;
    private $distance;
    private $tags;

    public function __construct($id = '', $name = '', $address = '', $location = '', $type = '', $distance = '', $tags = '') {
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
                3 => array(
                    'var' => 'address',
                    'sortId' => 3,
                    'type' => SCFType::STRING,
                ),
                4 => array(
                    'var' => 'location',
                    'sortId' => 4,
                    'type' => SCFType::OBJECT,
                    'elem' => array(
                        'class' => new Point(),
                    ),
                ),
                5 => array(
                    'var' => 'type',
                    'sortId' => 5,
                    'type' => SCFType::STRING,
                ),
                6 => array(
                    'var' => 'distance',
                    'sortId' => 6,
                    'type' => SCFType::DOUBLE,
                ),
                7 => array(
                    'var' => 'tags',
                    'sortId' => 7,
                    'type' => SCFType::LST,
                    'elem' => array(
                        'type' => SCFType::OBJECT,
                        'class' => new PoiTag(),
                    ),
                ),
            );
        }
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->location = $location;
        $this->type = $type;
        $this->distance = $distance;
        $this->tags = $tags;
    }

    public static function getTSPEC() {
        return PoiEntity::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        PoiEntity::$_TSPEC = $_TSPEC;
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

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getlocation() {
        return $this->location();
    }

    public function setlocation($location) {
        $this->location = $location;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getDistance() {
        return $this->distance;
    }

    public function setDistance($distance) {
        $this->distance = $distance;
    }

    public function getNull() {
        return $this->null;
    }

    public function setNull($null) {
        $this->null = $null;
    }

    public function setTags($tags=array())
    {
        $this-> tags=$tags;
    }
}
