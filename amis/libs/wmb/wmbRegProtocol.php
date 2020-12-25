<?php

namespace Libs\Wmb;

use Libs\Wmb\WmbByteHelper;
use Libs\Wmb\WmbCommon;

/**
 * 
 */
class WmbRegProtocol {

    public $header_len = 15;
    public $total_len;
    public $version = 1;
    public $opaque;
    public $msg_type;
    public $session_id = 0;
    public $body;

    function __construct($opaque, $msg_type, $body) {
        $this->opaque = $opaque;
        $this->msg_type = $msg_type;
        $this->body = $body;
        $this->total_len = $this->header_len + strlen($this->body);
    }

    public function toByteString() {
        $tmp_buffer = array();
        $tmp_buffer[] = WmbCommon::getStartTag();
        $tmp_buffer[] = pack("VCCC", $this->total_len, $this->version, $this->opaque, $this->msg_type);
        $tmp_buffer[] = WmbByteHelper::GetBytesFromInt64($this->session_id);  // little endian
        $body_len = strlen($this->body);
        $tmp_buffer[] = pack("a{$body_len}", $this->body);
        $tmp_buffer[] = WmbCommon::getEndTag();

        return join($tmp_buffer);
    }

    public function readSocketFromByte($socket) {
        $buf = "";
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 500 * 1000));
        $rcv_cnt = socket_recv($socket, $buf, $this->header_len + 5, MSG_WAITALL);
        if ($rcv_cnt < $this->header_len + 5) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_REG_R];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }

        if (strcmp(substr($buf, 0, 5), WmbCommon::getStartTag()) != 0) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_REG_FRAME];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }

        $unpack_array = unpack("V", substr($buf, 5, 4));
        $this->total_len = $unpack_array[1];
        $unpack_array = unpack("C", substr($buf, 10, 1));
        $this->opaque = $unpack_array[1];
        $unpack_array = unpack("C", substr($buf, 11, 1));
        $this->msg_type = $unpack_array[1];

        $body_len = $this->total_len - $this->header_len;

        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 500 * 1000));
        $rcv_cnt = socket_recv($socket, $buf, $body_len + 5, MSG_WAITALL);
        if ($rcv_cnt < $body_len + 5) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_REG_R];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }

        $unpack_array = unpack("a{$body_len}", substr($buf, 0, $body_len));
        $this->body = $unpack_array[1];

        if (strcmp(substr($buf, $body_len, 5), WmbCommon::getEndTag()) != 0) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_REG_FRAME];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }
    }
}
