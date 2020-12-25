<?php
namespace com\bj58\spat\scf\client\proxy;

class Parameter 
{
    private $type;
    private $value;


    public function __construct($value = '')
    {
        $this->value = $value;
    }

 /**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

 /**
     * @return the $value
     */
    public function getValue()
    {
        return $this->value;
    }

 /**
     * @param field_type $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

 /**
     * @param field_type $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }


}