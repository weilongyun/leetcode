<?php

namespace com\bj58\uc\passport\entry\cookie;

use com\bj58\spat\scf\serialize\component\SCFType;

class PCookie {

    static $_TSPEC;
    static $_SCFNAME = 'PCookie';
    private $name;
    private $value;
    private $domain;
    private $expire;
    private $path;

    public function __construct($name = '', $value = '', $domain = '', $expire = '', $path = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'name',
                    'sortId' => 1,
                    'type' => SCFType::STRING,
                ),
                2 => array(
                    'var' => 'value',
                    'sortId' => 2,
                    'type' => SCFType::STRING,
                ),
                3 => array(
                    'var' => 'domain',
                    'sortId' => 3,
                    'type' => SCFType::STRING,
                ),
                4 => array(
                    'var' => 'expire',
                    'sortId' => 4,
                    'type' => SCFType::I32,
                ),
                5 => array(
                    'var' => 'path',
                    'sortId' => 5,
                    'type' => SCFType::STRING,
                ),
            );
        }
    }

    public static function getTSPEC() {
        return PCookie::$_TSPEC;
    }

    public static function setTSPEC($_TSPEC) {
        PCookie::$_TSPEC = $_TSPEC;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getDomain() {
        return $this->domain;
    }

    public function setDomain($domain) {
        $this->domain = $domain;
    }

    public function getExpire() {
        return $this->expire;
    }

    public function setExpire($expire) {
        $this->expire = $expire;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }
}
