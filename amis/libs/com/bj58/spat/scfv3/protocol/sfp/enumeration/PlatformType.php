<?php
namespace com\bj58\spat\scf\protocol\sfp\enumeration;

use com\bj58\spat\scf\exception\ScfException;

class PlatformType
{
    const Dotnet = 0;
    const Java = 1;
    const C = 2;
    const PHP = 3;

    /**
     *
     * @param byte $platformType
     * @return String
     */
    public static function getPlatformType($platformType)
    {
        switch ($platformType) {
            case 0:
                return "Dotnet";
            case 1:
                return "Java";
            case 2:
                return "C";
            case 3:
                return "PHP";
            default:
                throw new ScfException("platformType error!");
        }
    }
}