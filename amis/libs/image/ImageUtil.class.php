<?php

namespace Libs\Image;

class ImageUtil {
    
    public static function getPictureUrl($path, $file) {
        return self::getPictureHost($file) . "/" . $path . "/" . $file;
    }

    public static function getOrigImageUrl($url) {
        $filename = pathinfo($url, PATHINFO_FILENAME);
        $fileNameArr = explode('_', $filename);
        $newFilename = $fileNameArr[0] . "_" . $fileNameArr[1];

        $origUrl = str_replace($filename, $newFilename, $url);
        $questionMarkPos = strpos($origUrl, '?');

        return $questionMarkPos === false ? $origUrl : substr($origUrl, 0, $questionMarkPos);
    }

    public static function getPictureHost($key) {
        if (empty($key)) {
            return $GLOBALS['PICTURE_DOMAINS']['a'];
        }
        $remain = crc32($key) % count($GLOBALS['PICTURE_DOMAINS']);
        $hashKey = $GLOBALS['PICTURE_DOMAINS_ALLOCATION'][ abs($remain) ];
        ! isset($GLOBALS['PICTURE_DOMAINS'][$hashKey]) && $hashKey = 'a';
        return $GLOBALS['PICTURE_DOMAINS'][$hashKey];
    }

    public static function getPictureSize($picfile) {
        $info = getimagesize($picfile);
        return array('width'=>$info[0], 'height'=>$info[1]);
    }

    public static function getPictureSizeFromString($buffer) {
        $info = getimagesizefromstring($buffer);
        return array('width'=>$info[0], 'height'=>$info[1]);
    }
}

