<?php
namespace com\bj58\spat\scf\protocol\compress;

use com\bj58\spat\scf\protocol\compress\CompressBase;
use com\bj58\spat\scf\exception\ScfException;

class ServerZip extends CompressBase
{

    /**
     * @param byte[]
     * @return byte[]
     * @see \protocol\protocol\compress\CompressBase\CompressBase::zip()
     */
    public function zip($buffer)
    {
        throw new ScfException("not supported 7zip!");
    }

 /**
  * @param byte[]
  * @return byte[]
     * @see \protocol\protocol\compress\CompressBase\CompressBase::unzip()
     */
    public function unzip($buffer)
    {
        throw new ScfException("not supported 7zip!");
    }
}