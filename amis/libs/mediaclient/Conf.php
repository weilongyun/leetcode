<?php
namespace mediaclient;
class Conf
{
    const PKG_VERSION = '1.0.0';

    const API_IMAGE_END_POINT = 'http://web.image.myqcloud.com/photos/v1/';
    const API_VIDEO_END_POINT = 'http://web.video.myqcloud.com/files/v1/';
    const API_COSAPI_END_POINT = 'http://web.file.myqcloud.com/files/v1/';

    const APPID = '10011010';

    const eMaskBizAttr = 0x01;
    const eMaskTitle = 0x02;
    const eMaskDesc = 0x04;
    const eMaskVideoCover = 0x08;
    const eMaskAll = 0x0F;

    const bid = 3;
    const password = "test";
    const server_url = "http://mediaupload.58dns.org:9528/";

    public static function getUA()
    {
        return 'QcloudPHP/' . self::PKG_VERSION . ' (' . php_uname() . ')';
    }
}