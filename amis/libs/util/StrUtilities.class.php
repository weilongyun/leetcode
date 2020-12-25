<?php
namespace Libs\Util;

class StrUtilities {

    public static function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }

    public static function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_,', '+/='));
    }

    public static function startWith($haystack, $needle) {
        return strpos($haystack, $needle) === 0;
    }

    public static function endWith($haystack, $needle) {
        return strrpos($haystack, $needle, strlen($haystack) - strlen($needle)) !== false;
    }

    public static function mbStrSplit($string) {
        if (empty($string)) return array();
        return preg_split('/(?<!^)(?!$)/u', $string );
    }

    public static function mbSubStr($str, $length, $suffix='', $ascii_place=1, $utf8_place=1) {
        $strLen = self::mbStrShowLen($str, $ascii_place, $utf8_place);
        if ($strLen <= $length) return $str;

        $strArr = self::mbStrSplit($str);
        $sufLen = self::mbStrShowLen($suffix, $ascii_place, $utf8_place);
        if ($sufLen >= $strLen) return "";

        $count = 0;
        $length -= $sufLen;
        foreach ($strArr as $char) {
            $len = strlen($char) == 1 ? $ascii_place : $utf8_place;
            if ($length >= $len) {
                $count++;
                $length -= $len;
            } else {
                break;
            }
        }

        return implode('', array_slice($strArr, 0, $count)) . $suffix;
    }

    public static function mbStrShowLen($str, $ascii_place=1, $utf8_place=1) {
        $strArr = self::mbStrSplit($str);
        $len = 0;
        foreach ($strArr as $char) {
            $len += strlen($char) == 1 ? $ascii_place : $utf8_place;
        }
        return $len;
    }

}
