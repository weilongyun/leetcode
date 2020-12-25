<?php
namespace com\bj58\spat\scf\protocol\serializer;

use com\bj58\spat\scf\serialize\serializer\Serializer;

class SCFSerialize extends SerializeBase
{
    /**
     *
     * @see \protocol\protocol\SerializeBase\SerializeBase::serialize()
     */
    public function serialize($obj, $initObj = '')
    {
        try {
            $serializer = new Serializer();
            return $serializer->Serialize($obj, $initObj);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @see \protocol\protocol\SerializeBase\SerializeBase::deserialize()
     */
    public function deserialize($data, $cls, $initObj = '')
    {
        try {
            $serializer = new Serializer();
            return $serializer->Derialize($data, $cls, $initObj);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}