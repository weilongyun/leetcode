<?php

namespace Libs\Wmb;

use Libs\Wmb\WmbByteHelper;
use Libs\Wmb\WmbCommon;

/**
 * 
 */
class WmbMsgProtocol {

    public $header_len = 46;
    public $total_len;
    public $version = 2;
    public $command_type = 0;
    public $protocol_type = 1;
    public $subject;
    public $message_id;
    public $session_id;
    public $message_type = 0;
    public $delivery_mode = 0;
    public $client_id;
    public $need_replay = 0;
    public $ip = 0;
    public $timestamp;
    public $msg_body;
    public $receive_timeout = 500; // 毫秒 ms

    function __construct($subject, $client_id, $msg_body, $flag_no_ack = FALSE) {
        $this->subject = $subject;
        $this->client_id = $client_id;
        $this->message_id = 0;
        $this->session_id = WmbCommon::sessionIdGenerator();
        $this->msg_body = $msg_body;
        $this->total_len = $this->header_len + strlen($this->msg_body);
        $this->timestamp = time();

        if ($flag_no_ack == FALSE) {
            //$this->command_type = 6;
            $this->need_replay = 1;
        }
    }

    public function toByteString() {
        $tmp_buffer = array();

        $tmp_buffer[] = pack("V", $this->total_len);
        $tmp_buffer[] = pack("CCC", $this->version, $this->command_type, $this->protocol_type);
        $tmp_buffer[] = pack("V", $this->subject);
        $tmp_buffer[] = WmbByteHelper::GetBytesFromInt64($this->message_id);
        $tmp_buffer[] = WmbByteHelper::GetBytesFromInt64($this->session_id);
        $tmp_buffer[] = pack("CC", $this->message_type, $this->delivery_mode);
        $tmp_buffer[] = pack("VCV", $this->client_id, $this->need_replay, $this->ip);
        $tmp_buffer[] = WmbByteHelper::GetBytesFromInt64($this->timestamp);
        $msg_len = strlen($this->msg_body);
        $tmp_buffer[] = pack("a{$msg_len}", $this->msg_body);

        $tmp_buffer[] = WmbCommon::getEndTag();

        return join($tmp_buffer);
    }

    public function readSocketFromByte($socket) {
        $buf = "";
        $ms = (int) ($this->receive_timeout % 1000);
        $sec = (int) ($this->receive_timeout / 1000);
        $usec = $ms * 1000;
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => $sec, "usec" => $usec));
        $rcv_cnt = socket_recv($socket, $buf, $this->header_len, MSG_WAITALL);
        if ($rcv_cnt < $this->header_len) {
            socket_close($socket);
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_BRK_R];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }

        $unpack_array = unpack("V", substr($buf, 0, 4));
        $this->total_len = $unpack_array[1];
        $unpack_array = unpack("C", substr($buf, 5, 1));
        $this->command_type = $unpack_array[1];

        $body_len = $this->total_len - $this->header_len;
        if ($body_len > 0) {
            //socket_set_option($socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>0, "usec"=>500*1000));
            $rcv_cnt = socket_recv($socket, $buf, $body_len + 5, MSG_WAITALL);
            if ($rcv_cnt < $body_len + 5) {
                socket_close($socket);
                $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_BRK_R];
                throw new \Exception($err_array["info"], $err_array["code"]);
            }

            //$unpack_array = unpack("a{$body_len}", substr($buf, 0, $body_len));
            $unpack_array = unpack("C", substr($buf, 0, $body_len));
            $this->msg_body = $unpack_array[1];
        }
    }
}
