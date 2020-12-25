<?php
namespace com\bj58\spat\scf\protocol\sdp;

use com\bj58\spat\scf\serialize\component\SCFType;
class HandclaspProtocol
{
    static $_TSPEC;
    static $_SCFNAME = 'HandclaspProtocol';

    private $type;//string
    private $data;//string

    public function __construct()
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'type',
                    'type' => SCFType::STRING,
                    'sortId' => 1,
                    'orderId' => 1,
                    'isGeneric'=> false,
                ),
                2 => array(
                    'var' => 'data',
                    'type' => SCFType::STRING,
                    'sortId' => 2,
                    'orderId' => 2,
                    'isGeneric'=> false,
                ),
            );
        }
    }
 /**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

 /**
     * @return the $data
     */
    public function getData()
    {
        return $this->data;
    }

 /**
     * @param field_type $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

 /**
     * @param field_type $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}