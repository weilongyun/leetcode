<?php

namespace Libs\Image;

use Libs\Serviceclient\MultiClient;
use Libs\Util\FileType;

class ImageUpload {
    
    public static $allow_file_types = array(
        FileType::JPEG,
        FileType::PNG,
        FileType::GIF,
        FileType::BMP,
    );

    private static $max_time_out_ms = 10*1000;

    private $path = '/default/';
    private $timeout_ms = 0;
    private $connect_timeout_ms = 0;

    private $mutilClientObj = NULL;
    private $result = array();

    public static function getUploader($path) {
        return new self($path);
    }

    private function __construct($path) {
        $this->setDFSPath($path);
        $this->setTimeoutMS(10000);
        $this->setConnectTimeoutMS(10000);
        $this->mutilClientObj = new MultiClient();
    }

    public function setDFSPath($path) {
        $path = trim(strval($path), '/');
        if (!empty($path)) {
            $this->path = "/" . $path . "/";
        }

        return $this;
    }

    public function getDFSPath() {
        return $this->path;
    }

    public function setTimeoutMS($timeout) {
        $timeout = intval($timeout);
        if ($timeout > 0 && $timeout <= self::$max_time_out_ms) {
            $this->timeout_ms = $timeout;
        }

        return $this;
    }

    public function setConnectTimeoutMS($connect_timeout) {
        $connect_timeout = intval($connect_timeout);
        if ($connect_timeout > 0 && $connect_timeout <= self::$max_time_out_ms) {
            $this->connect_timeout_ms = $connect_timeout;
        }

        return $this;
    }

    public function addFromAttachs() {
        if (empty($_FILES) || empty($_FILES['attachs']) || empty($_FILES['attachs']['name'])) {
            throw new ImageUploadException(UPLOAD_ERR_NO_FILE);
        }

        $keys = array_keys($_FILES['attachs']['name']);
        foreach ($keys as $key) {
            $name = $_FILES['attachs']['name'][$key];
            $tmp_name = $_FILES['attachs']['tmp_name'][$key];
            $error = $_FILES['attachs']['error'][$key];

            if (empty($name) || UPLOAD_ERR_NO_FILE == $error) { // no file was uploaded
                continue;
            }

            if (UPLOAD_ERR_OK != $error) { // not ok
                throw new ImageUploadException($error);
            }

            $this->addFromBuffer($name, file_get_contents($tmp_name), $this->path, $tmp_name);
        }

        if (empty($this->result)) {
            throw new ImageUploadException(UPLOAD_ERR_NO_FILE);
        }

        return $this;
    }

    public function addFromBuffer($filename, $buffer, $path = '', $tmpfile = '') {
        static $upload_idx = 0;
        
        $default_result = array(
            'file_name' => $filename,
            'file_size' => strlen($buffer),
            'file_url'  => '',
            'tmp_file' => $tmpfile,
            '_upload_idx' => '',
            'err_msg' => '',
            'pic_size' => ImageUtil::getPictureSizeFromString($buffer),
        );
        
        $type = FileType::getFileTypeByContent(substr($buffer, 0, FileType::MAX_HEADER_LEN));
        if (! in_array($type, self::$allow_file_types)) {
            $default_result['err_msg'] = '不支持的文件类型: ' . FileType::getFileTypeName($type);
            $this->result[] = $default_result;
            return $this;
        }
        
        if ($GLOBALS['PICTURE_MAX_SIZE'] > 0 && $default_result['file_size'] > $GLOBALS['PICTURE_MAX_SIZE']) {
            $default_result['err_msg'] = "所上传的文件超过大小限制";
            $this->result[] = $default_result;
            return $this;
        }

        empty($path) && $path = $this->path;
        $upload_idx ++;

        $this->mutilClientObj->call(
            'upload', '/', $buffer, $upload_idx, array(),
            array(
                'Content-Type' => 'multipart/form-data;',
                'Pic-Path' => $path,
                'Pic-Size' => '0*0*ByBig',
                'IsMerge' => '0',
                'Expect' => '',
            )
        );

        $default_result['_upload_idx'] = $upload_idx;
        $default_result['err_msg'] = 'ok';
        $this->result[] = $default_result;

        return $this;
    }

    public function upload() {
        $this->mutilClientObj->setGlobalOpt(array(
            'timeout' => intval($this->timeout_ms) / 1000,
            'connect_timeout' => intval($this->connect_timeout_ms) / 1000,
        ));
        $responses = $this->mutilClientObj->callData();

        $result = $this->result;
        $this->result = array();

        foreach ($result as $idx => $arr) {
            $response = $responses[ $arr['_upload_idx'] ];
            if (empty($response)) {
                continue;
            } elseif ($response['httpcode'] != 200 || empty($response['exec_ret'])) {
                $result[$idx]['file_url'] = false;
                $result[$idx]['err_msg'] = "上传图片超时，请再次尝试";
            } else {
                $result[$idx]['file_url'] = $response['exec_ret'];
            }
        }

        return $result;
    }

}
