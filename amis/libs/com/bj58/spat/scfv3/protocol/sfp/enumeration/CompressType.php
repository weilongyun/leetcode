<?php
namespace com\bj58\spat\scf\protocol\sfp\enumeration;

use com\bj58\spat\scf\exception\ScfException;

class CompressType
{
    const UnCompress = 0;
    const SevenZip = 1;
    const DES = 2;

    /**
     *
     * @param byte $compressType
     * @return StringSerializer
     */
    public static function getCompressType($compressType)
    {
        switch ($compressType) {
            case 0:
                return CompressType::UnCompress;
            case 1:
                return CompressType::SevenZip;
            case 2:
                return CompressType::DES;
            default:
                throw new ScfException("compress type error!");
        }
    }
}