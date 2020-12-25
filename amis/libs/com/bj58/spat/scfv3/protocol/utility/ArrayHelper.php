<?php
namespace com\bj58\spat\scf\protocol\utility;

class ArrayHelper
{
    /**
     *
     */
    public static function arrayCopy($srcArry, $srcPos, $destArray, $destPos, $length)
    {
        for ($i = 0; $i < $length;  $i ++) {
            $destArray[$destPos + $i] = $srcArry[$srcPos + $i];
        }
        return $destArray;
    }
}