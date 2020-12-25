<?php
namespace com\bj58\spat\scf\protocol\utility;

use com\bj58\spat\scf\serialize\component\SCFType;
class KeyValuePair
{
    static $_TSPEC;
    static $_SCFNAME = 'RpParameter';
    private $key = null;
    private $value = null;

    public function __construct($key = null, $value = null)
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'key',
                    'type' => SCFType::STRING,
                    'sortId' => 1,
                    'orderId' => 1,
                    'isGeneric'=> false,
                ),
                2 => array(
                    'var' => 'value',
                    'type' => SCFType::OBJECT,
                    'sortId' => 2,
                    'orderId' => 2,
                    'isGeneric' => true
                ),
            );
        }
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

}