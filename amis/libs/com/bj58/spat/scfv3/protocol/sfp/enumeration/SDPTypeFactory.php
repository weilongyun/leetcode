<?php
namespace com\bj58\spat\scf\protocol\sfp\enumeration;

use com\bj58\spat\scf\exception\ScfException;

class SDPTypeFactory
{

    public static function getSDPClass($protocol, $initObj = '')
    {
        $serializeType = $protocol->getSerializerType();
        switch ($serializeType) {
            case SerializeType::SCFBinary:
                return SDPType::getSDPClass($protocol->getSdpType(), $initObj);
            case SerializeType::SCFBinaryV2:
                return SDPTypeV2::getSDPClass($protocol->getSdpType(), $initObj);
            case SerializeType::SCFBinaryV3:
                return SDPTypeV3::getSDPClass($protocol->getSdpType(), $initObj);
            default:
                throw new ScfException('not validata serializer type. ' . $serializeType);
                break;
        }
    }
}

?>