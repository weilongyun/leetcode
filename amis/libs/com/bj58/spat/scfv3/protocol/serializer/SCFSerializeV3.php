<?php
namespace com\bj58\spat\scf\protocol\serializer;

use com\bj58\spat\scf\serialize\serializerV3\SerializerV3;
class SCFSerializeV3 extends SerializeBase
{
    public function serialize($obj, $initObj = '')
    {
        try {
            $serializer = new SerializerV3();
            return $serializer->Serialize($obj, $initObj);
        } catch (\Exception $e) {
            throw $e;
        }

    }

    public function deserialize($data, $cls, $initObj = '')
    {
        try {
            $serializer = new SerializerV3();
            return $serializer->Derialize($data, $cls, $initObj);
        } catch (\Exception $e) {
            throw $e;
        }

    }
}

?>