<?php

namespace Libs\Log;

class BasicLogWriter extends LogWriter {

    private $LOGPATH = LOG_PATH;

    public function write($mark, $str) {
        $path_parts = pathinfo($mark);
        $realpath = $this->LOGPATH;
        if (!is_dir($realpath)) {
            mkdir($realpath, 0777,TRUE);
        }
        $realfile = $path_parts["basename"] . "." . date("Ymd");
        $currentTime = date("Y-m-d H:i:s");
        $file = $realpath . DIRECTORY_SEPARATOR . $realfile;
        file_put_contents($file, $str . PHP_EOL, FILE_APPEND);
    }
}
