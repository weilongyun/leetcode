<?php
namespace com\bj58\spat\scf\protocol\compress;

use com\bj58\spat\scf\protocol\sfp\enumeration\CompressType;
use com\bj58\spat\scf\exception\ScfException;

abstract class CompressBase
{
    public static function getInstance($ct)
    {
        if ($ct === CompressType::UnCompress) {
            return new UnCompress();
        } else if ($ct === CompressType::SevenZip) {
            return new ServerZip();
        } else {
            throw new ScfException("not supported compress type!");
        }
    }
    /**
     *
     * @param byte[] $buffer
     * @return byte[]
     */
    public abstract function unzip ($buffer) ;
    /**
     *
     * @param byte[] $buffer
     * @return byte[]
     */
    public abstract function zip($buffer) ;
}