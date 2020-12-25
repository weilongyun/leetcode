<?php
namespace com\bj58\spat\scf\protocol\sfp\enumeration;

use com\bj58\spat\scf\exception\ScfException;

class SerializeType
{
    const JSON = 1;
    const JAVABinary = 2;
    const XML = 3;
    const SCFBinary = 4;
    const SCFBinaryV2 = 5;

    public static function getSerializeType($serializeType)
    {
        switch ($serializeType) {
            case 1:
                return SerializeType::JSON;
            case 2:
                return SerializeType::JAVABinary;
            case 3:
                return SerializeType::XML;
            case 4:
                return SerializeType::SCFBinary;
            case 5:
                return SerializeType::SCFBinaryV2;
            default:
                throw new ScfException("serializeType error!");
        }
    }

    public static function getSerializeTypeNum($serializeType)
    {
        switch ($serializeType) {
            case 'json':
                return SerializeType::JSON;
            case 'java':
                return SerializeType::JAVABinary;
            case 'xml':
                return SerializeType::XML;
            case 'SCF':
                return SerializeType::SCFBinary;
            case 'SCFV2':
                return SerializeType::SCFBinaryV2;
            default:
                throw new ScfException("serializeType error!");
        }
    }
}