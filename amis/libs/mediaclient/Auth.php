<?php

namespace mediaclient;
class Auth
{

    const AUTH_URL_FORMAT_ERROR = -1;
    const AUTH_SECRET_ID_KEY_ERROR = -2;

    /**
     * 生成多次有效签名函数（用于上传和下载资源，有效期内可重复对不同资源使用）
     * @param  int $expired 过期时间,unix时间戳
     * @param  string $bucketName 文件所在bucket
     * @return string          签名
     */
    public static function appSign($expired, $bucketName, $mediatype)
    {

        $url = Conf::server_url . "/getsign";
        $data = array('mediatype' => $mediatype, 'bid' => Conf::bid, "bucket_name" => $bucketName, "passwd" => Conf::password, "expired" => $expired);

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context = stream_context_create($options);
        $resp = file_get_contents($url, false, $context);

        $signResp = json_decode($resp, true);
        if ($signResp == null) {
            return null;
        }
        return $signResp['sign'];
    }

}

//end of script

