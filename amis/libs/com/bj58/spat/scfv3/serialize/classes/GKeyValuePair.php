<?php
namespace com\bj58\spat\scf\serialize\classes;

class GKeyValuePair {
    private $_key;
    private $_value;

    public function __construct($key, $value) {
        $this->_key = $key;
        $this->_value = $value;
    }
    /**
     * @return the $_key
     */
    public function getKey()
    {
        return $this->_key;
    }

 /**
     * @return the $_value
     */
    public function getValue()
    {
        return $this->_value;
    }

 /**
     * @param field_type $_key
     */
    public function setKey($_key)
    {
        $this->_key = $_key;
    }

 /**
     * @param field_type $_value
     */
    public function setValue($_value)
    {
        $this->_value = $_value;
    }



}