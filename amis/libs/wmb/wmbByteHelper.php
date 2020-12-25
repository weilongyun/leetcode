<?php

namespace Libs\Wmb;

class WmbByteHelper {

    public static function ToInt16($buffer) {
        $arr = unpack('v', $buffer);
        $value = $arr[1];
        if ($value > 0x7fff) {
            $value = 0 - (($value - 1) ^ 0xffff);
        }
        return $value;
    }

    public static function ToInt32($buffer) {
        $int32 = unpack('V', $buffer);
        $value = $int32[1];
        if ($value > 0x7fffffff) {
            $value = 0 - (($value - 1) ^ 0xffffffff);
        }
        return $value;
    }

    public static function ToInt64($buffer) {
//         $temp = unpack('N2', $buffer);
//         $num = $temp["i*1"] + ($temp["i*2"]  * 4294967296);
        $arr = unpack('i2', $buffer);

        // If we are on a 32bit architecture we have to explicitly deal with
        // 64-bit twos-complement arithmetic since PHP wants to treat all ints
        // as signed and any int over 2^31 - 1 as a float
        if (PHP_INT_SIZE == 4) {

            $hi = $arr[2];
            $lo = $arr[1];
            $isNeg = $hi < 0;

            // Check for a negative
            if ($isNeg) {
                $hi = ~$hi & (int) 0xffffffff;
                $lo = ~$lo & (int) 0xffffffff;

                if ($lo == (int) 0xffffffff) {
                    $hi++;
                    $lo = 0;
                } else {
                    $lo++;
                }
            }

            // Force 32bit words in excess of 2G to pe positive - we deal wigh sign
            // explicitly below

            if ($hi & (int) 0x80000000) {
                $hi &= (int) 0x7fffffff;
                $hi += 0x80000000;
            }

            if ($lo & (int) 0x80000000) {
                $lo &= (int) 0x7fffffff;
                $lo += 0x80000000;
            }

            $value = $hi * 4294967296 + $lo;

            if ($isNeg) {
                $value = 0 - $value;
            }
        } else {

            if ($arr[1] & 0x80000000) {
                $arr[1] = $arr[1] & 0xffffffff;
            }

            if ($arr[2] & 0x80000000) {
                $arr[2] = $arr[2] & 0xffffffff;
                $arr[2] = $arr[2] ^ 0xffffffff;
                $arr[1] = $arr[1] ^ 0xffffffff;
                $value = 0 - $arr[2] * 4294967296 - $arr[1] - 1;
            } else {
                $value = $arr[2] * 4294967296 + $arr[1];
            }
        }
        return $value;
    }

    public static function GetBytesFromChar($ch) {
        return strrev(pack('v', ord($ch)));
    }

    public static function GetCharFromBytes($bs) {
        $bs = strrev($bs);
        $temp = unpack('v', $bs);
        $ch = chr($temp[1]);
        return $ch;
    }

    public static function GetBytesFromInt16($value) {
        if ($value == null) {
            $value = 0;
        }
        $data = pack('v', $value);
        return $data;
    }

    public static function GetBytesFromInt32($value) {
        if ($value == null) {
            $value = 0;
        }
        $data = pack('V', $value);
        return $data;
    }

    public static function GetBytesFromInt64($value) {

        if ($value == null) {
            $value = 0;
        }
        if (PHP_INT_SIZE == 4) {
            $neg = $value < 0;

            if ($neg) {
                $value *= -1;
            }

            $hi = (int) ($value / 4294967296);
            $lo = (int) $value;

            if ($neg) {
                $hi = ~$hi;
                $lo = ~$lo;
                if (($lo & (int) 0xffffffff) == (int) 0xffffffff) {
                    $lo = 0;
                    $hi++;
                } else {
                    $lo++;
                }
            }
            $buff = pack('i2', $lo, $hi);
        } else {
            $hi = $value >> 32;
            $lo = $value & 0xFFFFFFFF;
            $buff = pack('i2', $lo, $hi);
        }
        return $buff;
    }

}
