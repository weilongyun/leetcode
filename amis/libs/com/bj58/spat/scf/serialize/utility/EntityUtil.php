<?php
namespace com\bj58\spat\scf\serialize\utility;

use com\bj58\spat\scf\serialize\serializerV2\Serializer;
class EntityUtil
{
    public static function registerEntity($type) {
        Serializer::GetTypeInfo($type);
    }
}

?>