<?php

namespace Libs\Image;

class ImageResize {

    const ZOOM_BY_BOTH          = 1; // 以相对比例大的为准
    const ZOOM_BY_HEIGHT        = 2; // 以高为准
    const ZOOM_BY_WIDTH         = 3; // 以宽为准
    const ZOOM_BY_SMALL_TOP     = 4; // 以相对比例小的为准，需要裁减留顶部
    const ZOOM_BY_BIG           = 5; // 以相对比例大的为准
    const ZOOM_BY_SMALL_MIDDLE  = 6; // 以相对比例小的为准，需要裁减留中间
    const ZOOM_BY_SMALL_BOTTOM  = 7; // 以相对比例小的为准，需要裁减留底部

    private $customInfo = array();

    public function __construct() {
        $this->customInfo = array_fill(0,8,0);
        $this->customInfo[0] = 5;
    }

    public function setZipType($type) {
        $this->customInfo[1] = intval($type);
    }

    public function setWaterMark($mark) {
        if ($mark) {
            $this->customInfo[2] = 1;
        } else {
            $this->customInfo[2] = 0;
        }
    }

    public function setWidth($width) {
        $width = intval($width);
        $this->customInfo[4] = $width & 0xFF;
        $this->customInfo[5] = ($width >> 8) & 0xFF;
    }

    public function setHeight($height) {
        $height = intval($height);
        $this->customInfo[6] = $height & 0xFF;
        $this->customInfo[7] = ($height >> 8) & 0xFF;
    }

    public function setRatio($width, $height, $ratio) {
        if (empty($width) || empty($height) || empty($ratio)) return;
        $orgRatio = $width / $height;
        if ($orgRatio > $ratio) {
            $this->setWidth($height * $ratio);
            $this->setHeight($height);
        } else {
            $this->setWidth($width);
            $this->setHeight($width / $ratio);
        }
    }

    public function reset() {
        $this->customInfo = array_fill(0,8,0);
        $this->customInfo[0] = 5;
    }

    public function resize($url) {
        $url = ImageUtil::getOrigImageUrl($url);
        $filename = pathinfo($url, PATHINFO_FILENAME);
        if (empty($filename)) {return $url;}

        $resize_filename = ImageDesHelper::urlEncode($filename, $this->customInfo);
        return str_replace($filename, $resize_filename, $url);
    }

}
