<?php
namespace com\bj58\spat\scf\protocol\serializer;

use com\bj58\spat\scf\serialize\serializerV2\Serializer;
class SCFSerializeV2 extends SerializeBase
{
    public function serialize($obj)
    {
        try {
            $serializer = new Serializer();
            return $serializer->Serialize($obj);
        } catch (\Exception $e) {
            throw $e;
        }

    }

    public function deserialize($data, $cls)
    {
        try {
            $serializer = new Serializer();
            return $serializer->Derialize($data, $cls);
        } catch (\Exception $e) {
            throw $e;
        }

    }
}

?>