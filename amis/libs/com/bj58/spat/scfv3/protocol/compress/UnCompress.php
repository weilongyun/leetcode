<?php
namespace com\bj58\spat\scf\protocol\compress;

use com\bj58\spat\scf\protocol\compress\CompressBase;
class UnCompress extends CompressBase
{

    /**
     * @param byte[]
     * @return byte[]
     * @see \protocol\protocol\compress\CompressBase\CompressBase::zip()
     */
    public function zip($buffer)
    {
        return $buffer;
    }

      /**
        * @param byte[]
        * @return byte[]
     * @see \protocol\protocol\compress\CompressBase\CompressBase::unzip()
     */
    public function unzip($buffer)
    {
        return $buffer;
    }
}