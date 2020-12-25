<?php

namespace Libs\Wmb;

use Libs\Wmb\WmbRegistry;
use Libs\Wmb\WmbMsgProtocol;

/**
 * 
 */
class WmbClient {

    const FLAG_NO_ACK = 0x01;

    private $registry;
    public $connect_timeout = 500;  // 毫秒 ms
    public $receive_timeout = 500;  // 毫秒 ms

    /** 两个参数配合，代表在n秒内单个server失败超过x次，就屏蔽之 */
    public $mask_server_failed_cnt = 3;  // 单个server失败次数
    public $mask_server_cnt_interval = 30; // 秒
    public $mask_second_conn_reset = 30;  // 因连接失败引起，屏蔽的时长，秒
    public $mask_second_ack_timeout = 15;  // 因ack超时引起，屏蔽的时长，秒
    private $update_flag_prefix = "wmb_counter_";
    private $server_down_prefix = "wmb_down_cnt_";

    function __construct($key_path) {
        $this->registry = new WmbRegistry($key_path);
    }

    /**
     * [wmbSyncSend 同步发送msg]
     * @param  integer  $subject_id [主题id]
     * @param  integer  $client_id  [client id]
     * @param  string   $msg        [消息内容]
     * @param  integer  $flag       [标记]
     * @return bool                 []
     */
    public function wmbSyncSend($subject_id, $client_id, $msg, $flag = 0) {
        $flag_no_ack = FALSE;
        if ($flag & self::FLAG_NO_ACK == 1) {
            $flag_no_ack = TRUE;
        }
        $this->registry->connect_timeout = $this->connect_timeout;
        $brokers = $this->registry->getBrokerList($subject_id, $client_id);
        $cnt = count($brokers);

        /** 默认情况下，随机选择server */
        $index = mt_rand(0, $cnt - 1);
        /** Apcu缓存可用情况下，“依次轮询”选择server，实现“负载均衡” */
        if (function_exists('apcu_store') === TRUE) {
            $count_key = $this->update_flag_prefix . "|" . $this->registry->key . "|" . $subject_id . "|" . $client_id;
            $cache_counter = apcu_inc($count_key);
            if (is_numeric($cache_counter) && $cache_counter > 0 && $cache_counter < 2147483640) {
                /** Apcu缓存计数成功获取，根据计数实现server负载均衡；否则依然采用随机方式 */
                $index = $cache_counter % $cnt;
            } else {
                /** 计数超过范围，重置计数；避免溢出、负数 */
                apcu_store($count_key, 0);
            }
        }

        // 由调用者发起重试，内部重试暂不开启
        //for ($i=0; $i < $cnt; $i++) { 
        //$brk_addr = $brokers[($index+$i)%$cnt];

        $brk_addr = $brokers[$index];
        $parts = explode(":", $brk_addr);
        if (empty($parts[1])) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_BRK_ADDR];
            throw new \Exception($err_array["info"] . "|" . $brk_addr, $err_array["code"]);
        }

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        $conn_ret = WmbCommon::tcpConnectWithTimeout($socket, $parts[0], (int) $parts[1], $this->connect_timeout);
        if ($conn_ret === FALSE) {
            /** 尝试屏蔽若干秒 */
            $this->mask_broker($brk_addr, $this->mask_second_conn_reset);
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_BRK_CONN];
            throw new \Exception($err_array["info"] . "|" . $brk_addr, $err_array["code"]);
        }

        $send_proto = new WmbMsgProtocol($subject_id, $client_id, $msg, $flag_no_ack);
        $send_frame = $send_proto->toByteString();

        $w_len = socket_write($socket, $send_frame, strlen($send_frame));
        if ($w_len === FALSE || $w_len < strlen($send_frame)) {
            socket_close($socket);
            /** 尝试屏蔽若干秒 */
            $this->mask_broker($brk_addr, $this->mask_second_ack_timeout);
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_BRK_W];
            throw new \Exception($err_array["info"] . "|" . $brk_addr, $err_array["code"]);
        }


        if ($flag_no_ack == TRUE) {
            socket_close($socket);
            return TRUE;
        } else {
            /** 等待ACK */
            $rcv_proto = new WmbMsgProtocol(0, 0, "");
            $rcv_proto->receive_timeout = $this->receive_timeout;
            $rcv_proto->readSocketFromByte($socket);
            socket_close($socket);

            if ($rcv_proto->command_type != 7 || $rcv_proto->msg_body = 0) {
                /** 尝试屏蔽若干秒 */
                $this->mask_broker($brk_addr, $this->mask_second_ack_timeout);
                $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_BRK_ACK];
                throw new \Exception($err_array["info"] . "|" . $brk_addr, $err_array["code"]);
            }
            return TRUE;
        }

        //}
    }

    /**
     * [set_timeout 设置超时]
     * @param [type] $con_timeout_ms  [连接超时，毫秒]
     * @param [type] $recv_timeout_ms [读超时，毫秒]
     */
    public function set_timeout($con_timeout_ms, $recv_timeout_ms) {
        if (is_numeric($con_timeout_ms) && $con_timeout_ms > 0) {
            $this->connect_timeout = $con_timeout_ms;
        }
        if (is_numeric($recv_timeout_ms) && $recv_timeout_ms > 0) {
            $this->receive_timeout = $recv_timeout_ms;
        }
    }

    private function mask_broker($brk_addr, $mask_sec = 15) {
        /** Apcu缓存 屏蔽某个broker */
        if (function_exists('apcu_store') === TRUE) {
            $down_count_key = $this->server_down_prefix . $brk_addr;
            $v = apcu_exists($down_count_key);
            $n = 1;
            if ($v === FALSE) {
                /** 写入key，并设置过期时间 */
                apcu_store($down_count_key, 1, $this->mask_server_cnt_interval);
            } else {
                /** +1; inc */
                $n = apcu_inc($down_count_key);
            }

            /** 达到 一定时间内失败次数 条件，屏蔽若干秒 */
            if (is_numeric($n) && $n >= $this->mask_server_failed_cnt) {
                $key = WmbRegistry::$mask_broker_prefix . $brk_addr;
                apcu_store($key, "mask", $mask_sec);
            }
        }
    }
}
