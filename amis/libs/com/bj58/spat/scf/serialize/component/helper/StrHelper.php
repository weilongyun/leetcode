<?php
namespace com\bj58\spat\scf\serialize\component\helper;

class StrHelper {
    public static $EmptyString = "";

    /**
     * get the hashcode of the string str
     * return int
     * @param unknown $str string
     */
    public static function GetHashcode($str) {
        $hash1 = 5381;
        $hash2 = $hash1;
        $len = strlen($str);
        for ($i = 0; $i < $len;$i ++) {
            $c = ord($str[$i]);
            $hash1 = ((($hash1 << 5) + $hash1) ^ $c);
            $hash1 = StrHelper::intval32($hash1);
            if ( ++$i >= $len) {
                break;
            }
            $c = ord($str[$i]);
            $hash2 = ((($hash2 << 5) + $hash2) ^ $c);
            $hash2 = StrHelper::intval32($hash2);
        }
        $tmp = bcmul($hash2, '1566083941');
        $tmp1 = bcmod($tmp, '4294967296');
        if($tmp1 > 2147483647) {
            $tmp1 = $tmp1 - 4294967296;
            $tmp2 = StrHelper::intval32($tmp1);
        } else {
            $tmp2 = StrHelper::intval32($tmp1);
        }
        $res = $hash1 + $tmp2;
        $res = StrHelper::intval32($res);
        return $res;
    }

    public static function intval32($num) {
       if (PHP_INT_SIZE === 4) {
            if (abs($num) > 4294967295) {
                $num &= 4294967295;
            }
        } else {
            if ($num > 2147483647 || $num < 0) {
                $num &= 4294967295;
            }
        }
        $p = $num >> 31;
        if ($p) {
            $num = $num -1;
            $num = $num ^ 0xffffffff;
            $num = $num & 0xffffffff;
            return $num * -1;
        } else {
            return $num;
        }
    }

    public static function getEntityName($class, &$realName = '') {
        $obj = new \ReflectionClass($class);
        $realName = $obj->name;
        $name = $obj->getProperty("_SCFNAME")->getValue();
        if (null === $name) {
            $strs = str_split($class, '\\');
            $name = end($strs);
        }
        return $name;
    }
}