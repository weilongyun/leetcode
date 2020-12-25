<?php
namespace mediaclient;

include "Conf.php";
include "Video.php";
include "Cosapi.php";
include "Auth.php";
include "Http.php";

class AudioResult
{
    public $code;
    public $msg;
    public $accessUrl;
}

class VideoInfo
{
    public $bucketName;
    public $path;
    public $accessUrl;
}

class VideoResult
{
    public $code;
    public $msg;
    public $videoinfo;
}

class MediaPath
{
    public $path;
    public $bucketName;
}

class MediaClient
{
    const AUDIO_TYPE = 1;
    const VIDEO_TYPE = 2;

    public function getMediaPath($mediaType)
    {
        $url = Conf::server_url . "/upload?bid=" . conf::bid . "&passwd=" . conf::password . "&m=" . $mediaType;
        $resp = file_get_contents($url);
        if (strlen($resp) == 0) {
            return null;
        }
        $path = json_decode($resp, true);
        if ($path['errCode'] != 0) {
            return null;
        }
        $result = new MediaPath();
        $result->bucketName = $path['bucketName'];
        $result->path = $path['path'];
        return $result;
    }

    /*
     * code: 0 表示成功，其他表示失败
     * msg: 失败原因
     * url: 上传后的url
     */
    public function uploadAudio($filePath)
    {
        $result = new AudioResult();
        $path = $this->getMediaPath(MediaClient::AUDIO_TYPE);
        if ($path == null) {
            $result->code = -1;
            $result->msg = "get media path error for " . Conf::bid . " media type " . MediaClient::AUDIO_TYPE;
            $this->uploadErrReport(-1, "getMediaPath error", MediaClient::AUDIO_TYPE, "", "", "getMediaPath");
            return null;
        }
        $path->path = $path->path . $this->getExt($filePath);
        print "\n";
        $ret = Cosapi::upload_slice($filePath, $path->bucketName, $path->path);
        if ($ret == null || (isset($ret['httpcode']) && $ret['httpcode'] != 200) || (isset($ret['code']) && $ret['code'] != 0)) {
            $result->code = -2;
            $result->msg = "upload slice error" . $ret['code'] . " msg " . $ret['message'] . " for " . Conf::bid . " media type " . MediaClient::AUDIO_TYPE;
            $this->uploadErrReport($ret['code'], $ret['message'], MediaClient::AUDIO_TYPE, $path->bucketName, $path->path, "upload_slice");

            return $result;
        }
        $result->code = 0;
        $result->msg = "";
        $result->accessUrl = $ret['data']['access_url'];
        return $result;
    }

    private function getExt($filePath)
    {
        $pos = strrpos($filePath, ".");
        if ($pos === false || strlen($filePath) - $pos > 5 || strlen($filePath) - $pos <= 2) {
            return "";
        } else {
            return substr($filePath, $pos);
        }
    }

    /*
     * code: 0 表示成功，其他表示失败
     * msg: 失败原因
     * videoinfo: 上传后的videoinfo
     */
    public function uploadVideo($filePath)
    {
        $result = new VideoResult();
        $path = $this->getMediaPath(MediaClient::VIDEO_TYPE);
        if ($path == null) {
            $result->code = -1;
            $result->msg = "get media path error for " . Conf::bid . " media type " . MediaClient::AUDIO_TYPE;
            $this->uploadErrReport(-1, "getMediaPath error", MediaClient::VIDEO_TYPE, "", "", "getMediaPath");
            return null;
        }
        $path->path = $path->path . $this->getExt($filePath);

        print "\n";
        $ret = Video::upload_slice($filePath, $path->bucketName, $path->path);
        if ($ret == null || (isset($ret['httpcode']) && $ret['httpcode'] != 200) || (isset($ret['code']) && $ret['code'] != 0)) {
            $result->code = -2;
            $result->msg = "upload slice error" . $ret['code'] . " msg " . $ret['message'] . " for " . Conf::bid . " media type " . MediaClient::AUDIO_TYPE;
            $this->uploadErrReport($ret['code'], $ret['message'], MediaClient::AUDIO_TYPE, $path->bucketName, $path->path, "upload_slice");
            return $result;
        }
        $result->code = 0;
        $result->msg = "";
        $result->videoinfo = new VideoInfo();
        $result->videoinfo->accessUrl = $ret['data']['access_url'];
        $result->videoinfo->bucketName = $path->bucketName;
        $result->videoinfo->path = $path->path;
        return $result;
    }

    public function uploadErrReport($code, $msg, $mediatype, $bucket, $path, $funcname)
    {
        $url = Conf::server_url . "/report";
        $data = array('code' => $code, 'msg' => $msg, "path" => $path, "bucket" => $bucket, "bid" => Conf::bid, "mediatype" => $mediatype, "busi" => "uploaderr", "funcname" => $funcname);

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
    }

    public function getValidVideoUrl($videoinfo)
    {
        $urls = array();
        $ret = Video::stat($videoinfo->bucketName, $videoinfo->path);
        if ($ret['code'] == 0 && isset($ret['data']) && isset($ret['data']['trans_status']) && isset($ret['data']['video_play_url'])) {
            foreach ($ret['data']['trans_status'] as $key => $val) {
                if ($val == 2 && isset($ret['data']['video_play_url'][$key])) {
                    $urls[$key] = $ret['data']['video_play_url'][$key];
                }
            }
        } else {
            $this->uploadErrReport($ret['code'], $ret['message'], MediaClient::VIDEO_TYPE, $videoinfo->bucketName, $videoinfo->path, "stat");
        }
        return $urls;
    }
}