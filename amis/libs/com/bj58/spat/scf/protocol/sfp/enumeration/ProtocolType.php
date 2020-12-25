<?php
namespace com\bj58\spat\scf\protocol\sfp\enumeration;

use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\client\utility\LogHelper;

class ProtocolType
{

    const V1 = 1;

    const V2 = 2;

    const OTHER = 3;

    /**
     *
     * @param byte $protocolType
     * @return String
     */
    public static function getProtocolType($protocolType)
    {
        if ($protocolType === 'V1') {
            return 1;
        } else
            if ($protocolType === 'V2') {
                return 2;
            } else
                if ($protocolType === 'V3') {
                    LogHelper::logWarnMsg('can not support this protocol type. current protocol type is ' . $protocolType);
                    return 3;
                } else {
                    throw new ScfException("prtocolType error");
                }
    }
}