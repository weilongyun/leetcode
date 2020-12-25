<?php

namespace Libs\Wmb;

/**
 * 
 */
class WmbCommon {

    const REG_OPCODE_CONFIG_GET = 0x00;
    const REG_OPCODE_CONFIG_PUSH = 0x01;
    const REG_REQUEST_ALL_DATAS = 0x01;
    const WMB_ERR_KEY_OPEN = 1;
    const WMB_ERR_KEY_DATA = 2;
    const WMB_ERR_BRK_CONF = 3;
    const WMB_ERR_BRK_JSON = 4;
    const WMB_ERR_SBJ_NOFOUND = 5;
    const WMB_ERR_CLUSTER_NOFOUND = 6;
    const WMB_ERR_REG_DNS = 7;
    const WMB_ERR_REG_CONN = 8;
    const WMB_ERR_REG_W = 9;
    const WMB_ERR_REG_R = 10;
    const WMB_ERR_REG_FRAME = 11;
    const WMB_ERR_BRK_ADDR = 12;
    const WMB_ERR_BRK_CONN = 13;
    const WMB_ERR_BRK_W = 14;
    const WMB_ERR_BRK_R = 15;
    const WMB_ERR_BRK_ACK = 16;

    public static $err_info = array(
        1 => array("info" => "wmb key path open failed", "code" => -3001),
        2 => array("info" => "wmb key config illegal", "code" => -3002),
        3 => array("info" => "wmb get broker config failed", "code" => -3003),
        4 => array("info" => "wmb parse config json failed", "code" => -3004),
        5 => array("info" => "wmb subject config no found", "code" => -3005),
        6 => array("info" => "wmb cluster broker no found", "code" => -3006),
        7 => array("info" => "wmb resolve reg dns failed", "code" => -3007),
        8 => array("info" => "wmb registry connect failed", "code" => -3008),
        9 => array("info" => "wmb registry write failed", "code" => -3009),
        10 => array("info" => "wmb registry read failed", "code" => -3010),
        11 => array("info" => "wmb registry frame explode failed", "code" => -3011),
        12 => array("info" => "wmb broker address illegal", "code" => -4001),
        13 => array("info" => "wmb broker connect failed", "code" => -4002),
        14 => array("info" => "wmb broker write failed", "code" => -4003),
        15 => array("info" => "wmb broker read failed", "code" => -4004),
        16 => array("info" => "wmb broker ACK failed", "code" => -4005),
    );

    public static function getStartTag() {
        return pack("CCCCC", 18, 17, 13, 10, 9);
    }

    public static function getEndTag() {
        return pack("CCCCC", 9, 10, 13, 17, 18);
    }

    public static function sessionIdGenerator() {
        return 0;
    }

    /**
     * [tcpConnectWithTimeout description]
     * @param  [type] $socket  [description]
     * @param  [type] $host    [description]
     * @param  [type] $port    [description]
     * @param  [type] $timeout [超时；毫秒 ms]
     * @return [type]          [description]
     */
    public static function tcpConnectWithTimeout($socket, $host, $port, $timeout) {
        socket_set_nonblock($socket);

        $sec_timeout = $timeout / 1000;  // 超时时间，转换成 “秒”

        $time = microtime(true);
        while (!@socket_connect($socket, $host, $port)) {
            $err = socket_last_error($socket);
            if ($err == 115 || $err == 114) {
                if ((microtime(true) - $time) >= $sec_timeout) {
                    socket_close($socket);
                    return FALSE;
                }
                //time_nanosleep(0, 5 * 1000 * 1000); // 5 ms
                $r = $w = $e = array();
                $w = array($socket);
                socket_select($r, $w, $e, 0, 10 * 1000);  // select to wait
                continue;
            }
            return FALSE;
        }

        socket_set_block($socket);
        return TRUE;
    }
}
