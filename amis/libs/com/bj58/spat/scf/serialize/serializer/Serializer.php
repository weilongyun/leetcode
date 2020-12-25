<?php
namespace com\bj58\spat\scf\serialize\serializer;

use com\bj58\spat\scf\serialize\component\SCFOutStream;
use com\bj58\spat\scf\serialize\component\SCFInStream;
use com\bj58\spat\scf\client\utility\LogHelper;
use com\bj58\spat\scf\serialize\component\helper\TypeHelper;

class Serializer
{

    private $_Encoder = "UTF-8";

    function _construct()
    {}

    public function Serialize($obj)
    {
        $stream = null;
        try {
            $stream = new SCFOutStream();
            if (null === $obj) {
                SerializerFactory::GetSerializer(null)->WriteObject(null, $stream);
            } else {
                if (is_object($obj)) {
                    $type = get_class($obj);
                } else {
                    $type = TypeHelper::GetTypeId(gettype($obj));
                }
                SerializerFactory::GetSerializer($type)->WriteObject($obj, $stream);
            }
            return $stream;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function Derialize($buffer, $type)
    {
        try {
            $stream = new SCFInStream($buffer);
            return SerializerFactory::GetSerializer($type)->ReadObject($stream, $type);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getEncoder()
    {
        return $this->_Encoder;
    }

    public function setEncoder($_Encoder)
    {
        $this->_Encoder = $_Encoder;
        return $this;
    }
}