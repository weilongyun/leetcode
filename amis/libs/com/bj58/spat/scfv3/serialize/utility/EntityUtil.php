<?php
namespace com\bj58\spat\scf\serialize\utility;

use com\bj58\spat\scf\serialize\serializerV2\Serializer;
use com\bj58\spat\scf\serialize\serializerV3\SerializerV3;
class EntityUtil
{
    public static function registerEntity($type, $initObj = '') {
        Serializer::GetTypeInfo($type, $initObj);
        SerializerV3::GetTypeInfo($type, $initObj);
    }
}

?>