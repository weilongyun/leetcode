<?php

namespace Libs\Util;

class Calculator {

    public static function string_add($operand1, $operand2) {
        if (PHP_INT_SIZE >= 8) {
            return $operand1 + $operand2;
        }

        $operand1 = strval($operand1);
        $operand2 = strval($operand2);

        $len1 = strlen($operand1);
        $len2 = strlen($operand2);
        $len_max = max($len1, $len2);

        $result = '';
        $flag = 0;
        while ($len_max--) {
            $opd1 = $len1 > 0 ? $operand1[--$len1] : 0;
            $opd2 = $len2 > 0 ? $operand2[--$len2] : 0;

            $sum = $opd1 + $opd2 + $flag;
            $flag = floor($sum/10);
            $result = strval($sum%10).$result;
        }
        $flag > 0 && $result = strval($flag).$result;

        return $result;
    }


    public static function  base62_convert($number, $from_base=10, $to_base=62) {
        if($to_base > 62 || $to_base < 2) {
            return false;
        }
        //no need to convert 0
        if("{$number}" === '0') {
            return 0;
        }

        //if to and from base are same.
        if($from_base == $to_base){
            return $number;
        }

        //if base is lower than 36, use PHP internal function
        if($from_base <= 36 && $to_base <= 36) {
            return base_convert($number, $from_base, $to_base);
        }

        // char list starts from 0-9 and then small alphabets and then capital alphabets
        // to make it compatible with eixisting base_convert function
        $charlist = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if($from_base < $to_base) {
            // if converstion is from lower base to higher base
            // first get the number into decimal and then convert it to higher base from decimal;

            if($from_base != 10){
                $decimal = self::base62_convert($number, $from_base, 10);
            } else {
                $decimal = intval($number);
            }

            //get the list of valid characters
            $charlist = substr($charlist, 0, $to_base);

            if($number == 0) {
                return 0;
            }
            $converted = '';
            while($number > 0) {
                $converted = $charlist{($number % $to_base)} . $converted;
                $number = floor($number / $to_base);
            }
            return $converted;
        } else {
            // if conversion is from higher base to lower base;
            // first convert it into decimal and the convert it to lower base with help of same function.
            $number = "{$number}";
            $length = strlen($number);
            $decimal = 0;
            $i = 0;
            while($length > 0) {
                $char = $number{$length-1};
                $pos = strpos($charlist, $char);
                if($pos === false){
                    return false;
                }
                $decimal += $pos * pow($from_base, $i);
                $length --;
                $i++;
            }
            return self::base62_convert($decimal, 10, $to_base);
        }
    }

}
