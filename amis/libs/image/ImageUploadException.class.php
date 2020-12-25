<?php

namespace Libs\Image;

class ImageUploadException extends \Exception {
    public function __construct($code) {
        $message = $this->codeToMessage($code);
        parent::__construct($message, $code);
    }

    private function codeToMessage($code) {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                $message = "所上传的文件超过大小限制";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                $message = "所上传的文件超过大小限制";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                $message = "所上传的文件仅部分完成，请重新上传";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                $message = "请选择需要上传的图片";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                $message = "临时文件夹错误,请重新上传";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                $message = "保存到磁盘失败，请重新上传";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                $message = "上传因异常停止，请重新上传";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }

}