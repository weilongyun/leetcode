<?php

namespace Libs\Wmb;

use Libs\Wmb\WmbRegProtocol;
use Libs\Wmb\WmbCommon;

/**
 * 
 */
class WmbRegistry {

    const CONF_EXPIRE_TIME_SEC = 60;

    //const MASK_BROKER_TTL = 15;

    private $config_cache_path_prefix = "/tmp/wmb_reg_conf_cache_";
    private $apcu_cache_key_prefix = "wmb_conf_";
    private $update_flag_prefix = "update_";
    public static $mask_broker_prefix = "wmb_mask_broker_";
    public $key_file_path = "";
    public $client_id_init = 0;
    public $key;
    public $registry_host;
    public $registry_port;
    public $reg_config = array();
    public $subject_conf_data = array();
    public $connect_timeout = 500;  // 毫秒 ms

    function __construct($key_path) {
        $parts = explode("?", trim($key_path));
        $this->key_file_path = $parts[0];
        if (isset($parts[1]) && is_numeric($parts[1])) {
            $this->client_id_init = (int) $parts[1];
        }

        $raw_file_string = file_get_contents($this->key_file_path);
        if ($raw_file_string === FALSE) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_KEY_OPEN];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }
        if (empty($raw_file_string)) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_KEY_DATA];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }

        $lines = explode("\n", trim($raw_file_string));
        foreach ($lines as $i => $line) {
            $line_parts = explode("=", trim($line));
            if (empty($line_parts[0]) || empty($line_parts[1])) {
                continue;
            }

            switch ($line_parts[0]) {
                case 'key':
                    $this->key = trim($line_parts[1]);
                    break;
                case 'registry_server_ip':
                    $this->registry_host = trim($line_parts[1]);
                    break;
                case 'registry_server_port':
                    $this->registry_port = trim($line_parts[1]);
                    break;
                default:
                    break;
            }
        }
        if (empty($this->key) || empty($this->registry_host) || empty($this->registry_port)) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_KEY_DATA];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }
    }

    public function getRegConfig() {
        if ($this->getRegConfigFromFile() === TRUE) {
            return TRUE;
        }
        if ($this->getRegConfigFromServer() === TRUE && !empty($this->reg_config)) {
            /** Apcu缓存设置 */
            if (function_exists('apcu_store') === TRUE) {
                $cache_key = $this->apcu_cache_key_prefix . $this->key;
                $update_key = $this->update_flag_prefix . $cache_key;
                apcu_store($cache_key, $this->reg_config);
                apcu_store($update_key, 0, 5);
            }

            $file_path = $this->config_cache_path_prefix . $this->key;
            $file = @fopen($file_path, "r+");
            if ($file === FALSE) {
                /** 文件不存在，直接写 */
                file_put_contents($file_path, serialize($this->reg_config) . "\n");
                return TRUE;
            }
            if (flock($file, LOCK_EX)) {
                /** 获得锁，更新文件内容 */
                file_put_contents($file_path, serialize($this->reg_config) . "\n");
                flock($file, LOCK_UN);
                fclose($file);
                return TRUE;
            }
            fclose($file);
        }
        return FALSE;
    }

    public function getBrokerList($subject_id, $client_id) {
        /** Apcu缓存查询 */
        if (function_exists('apcu_store') === TRUE) {
            $cache_key = $this->apcu_cache_key_prefix . $this->key;
            $this->reg_config = apcu_fetch($cache_key);
            /** 判断是否需要更新cashe，条件：timestamp超时 and “更新标志”为 0 */
            if (!empty($this->reg_config) && !empty($this->reg_config["timestamp"])) {
                if (time() - $this->reg_config["timestamp"] > self::CONF_EXPIRE_TIME_SEC) {
                    $n = apcu_inc($this->update_flag_prefix . $cache_key);
                    if ($n !== FALSE && $n == 1) {
                        /** 将reg_config置空，触发后面的更新操作 */
                        $this->reg_config = array();
                    }
                }
            }
        }
        /**  */
        if (!is_array($this->reg_config) || !isset($this->reg_config["config_json"])) {
            if ($this->getRegConfig() === FALSE) {
                $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_BRK_CONF];
                throw new \Exception($err_array["info"], $err_array["code"]);
            }
        }

        $this->subject_conf_data = json_decode($this->reg_config["config_json"], TRUE);
        if (empty($this->subject_conf_data)) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_BRK_JSON];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }

        /**  */
        $brokers = array();
        $clusters = array();
        foreach ($this->subject_conf_data["subjects"] as $sbj) {
            if ($sbj["name"] == $subject_id && $sbj["clientId"] == $client_id && $sbj["type"] == 0 && !empty($sbj["clusters"])) {
                $clusters = array_merge($clusters, $sbj["clusters"]);
            }
        }
        if (empty($clusters)) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_SBJ_NOFOUND];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }
        foreach ($this->subject_conf_data["clusters"] as $clu) {
            if ($clu["type"] == 0 && in_array($clu["hashCode"], $clusters)) {
                $brokers = array_merge($brokers, $clu["nodes"]);
            }
        }
        if (count($brokers) <= 0) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_CLUSTER_NOFOUND];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }

        /** Apcu缓存查询broker是否被暂时屏蔽 */
        if (function_exists('apcu_store') === TRUE) {
            $new_brokers = array();
            foreach ($brokers as $brk) {
                $key = self::$mask_broker_prefix . $brk;
                $v = apcu_exists($key);
                if ($v === FALSE) {
                    $new_brokers[] = $brk;
                }
            }
            /** 当所有的broker都被屏蔽时，返回原始broker列表，屏蔽集体失效 */
            if (count($new_brokers) > 0) {
                $brokers = $new_brokers;
            }
        }

        return $brokers;
    }

    private function getRegConfigFromServer() {
        $hosts = gethostbynamel($this->registry_host);
        if ($hosts === FALSE || !is_array($hosts) || empty($hosts)) {
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_REG_DNS];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }
        $cnt = count($hosts);
        $i = mt_rand(0, $cnt - 1);
        $ip = $hosts[$i];

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $conn_ret = WmbCommon::tcpConnectWithTimeout($socket, $ip, $this->registry_port, $this->connect_timeout);
        if ($conn_ret === FALSE) {
            socket_close($socket);
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_REG_CONN];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }

        $send_body = json_encode(array("key" => $this->key));
        $send_proto = new WmbRegProtocol(WmbCommon::REG_OPCODE_CONFIG_GET, WmbCommon::REG_REQUEST_ALL_DATAS, $send_body);
        $send_frame = $send_proto->toByteString();

        $w_len = socket_write($socket, $send_frame, strlen($send_frame));
        if ($w_len === FALSE || $w_len < strlen($send_frame)) {
            socket_close($socket);
            $err_array = WmbCommon::$err_info[WmbCommon::WMB_ERR_REG_W];
            throw new \Exception($err_array["info"], $err_array["code"]);
        }

        $rcv_proto = new WmbRegProtocol(0, 0, "");
        $rcv_proto->readSocketFromByte($socket);

        $this->reg_config = array(
            "timestamp" => time(),
            "config_json" => $rcv_proto->body,
        );

        socket_close($socket);

        return TRUE;
    }

    private function getRegConfigFromFile() {
        $ret_val = FALSE;
        $file_path = $this->config_cache_path_prefix . $this->key;
        /**  */
        $file = @fopen($file_path, "r+");
        if ($file === FALSE) {
            return FALSE;
        }
        if (flock($file, LOCK_SH)) {

            $f_content = file_get_contents($file_path);
            $this->reg_config = unserialize($f_content);
            if ($this->reg_config === FALSE || !is_array($this->reg_config)) {
                $ret_val = FALSE;
            } elseif (time() - $this->reg_config["timestamp"] > self::CONF_EXPIRE_TIME_SEC) {
                /** 文件记录的config过期 */
                $ret_val = FALSE;
            } else {
                $ret_val = TRUE;
            }
            flock($file, LOCK_UN);
        } else {

            $ret_val = FALSE;
        }

        fclose($file);

        return $ret_val;
    }
}
