<?php
namespace com\bj58\spat\scf\protocol\sfp\enumeration;

use com\bj58\spat\scf\exception\ScfException;

class SDPTypeFactory
{

    public static function getSDPClass($protocol)
    {
        $serializeType = $protocol->getSerializerType();
        switch ($serializeType) {
            case SerializeType::SCFBinary:
                return SDPType::getSDPClass($protocol->getSdpType());
                break;
            case SerializeType::SCFBinaryV2:
                return SDPTypeV2::getSDPClass($protocol->getSdpType());
                break;
            default:
                throw new ScfException('not validata serializer type. ' . $serializeType);
                break;
        }
    }
}

?>