<?php

namespace Libs\Serviceclient;

/**
 * 生成snake的请求header
 * @author zx
 */
class SnakeHeaderCreator {

    private static $header = array('Meilishuo' => 'uid:0;ip:0.0.0.0;v:0;master:0');
    private static $info = array('ip' => '0.0.0.0', 'user_id' => 0, 'master' => 0);
    private static $uri = '';
    private static $is_mob = 0;  // 该请求是否来自mobapi或者doota

    public static function getHeaders() {
        $v = self::is_v(self::$info['user_id'], self::$info['ip']);
        $master = !empty(self::$info['master']) ? 1 : 0;
        $is_mob = !empty(self::$is_mob) ? 1 : 0;
        self::$header = array(
                "Meilishuo" =>
                "uid:" . (int) self::$info['user_id'] .
                ";ip:" . self::$info['ip'] .
                ";v:" . $v .
                ";master:" . $master .
                ";is_mob:" . $is_mob,
                );

        if (!empty(self::$uri)) {
            self::$header['X-REF'] = self::$uri;
        }          

        return self::$header;
    }

    public static function setInfos($info) {
        self::$info = $info;

        if (isset($info['uri'])) {
            self::$uri = $info['uri'];
        }          

        if (isset($info['is_mob'])) {
            self::$is_mob = $info['is_mob'];
        }          
    }

    public static function is_v($user_id, $ip) {
        $ip = ip2long($ip);
        $v = 0;
        $white_user = array(20929830, 20719591);
        if (in_array($user_id, $white_user)) {
            $v = 1;
        }
        elseif (($ip >= 2093649920 && $ip <= 2093650175) ||
                ($ip >= 3550318994 && $ip <= 3550319006) ||
                $ip == ip2long('127.0.0.1') ||
                ($ip >= ip2long('211.157.145.144') && $ip <= ip2long('211.157.145.158')) ||
                ($ip >= ip2long('111.206.85.33') && $ip <= ip2long('111.206.85.46 ')) ||
                ($ip >= ip2long('211.157.149.8') && $ip <= ip2long('211.157.149.15')) ||
                ($ip >= ip2long('111.206.87.113') && $ip <= ip2long('111.206.87.126')) ||

                ($ip == ip2long('121.0.26.1') || $ip == ip2long('121.0.26.2')) ||
                ($ip >= ip2long('172.16.0.1') && $ip <= ip2long('172.16.255.255')) ||
                ($ip >= ip2long('221.122.61.50') && $ip <= ip2long('221.122.61.62')) ||
                ($ip >= ip2long('192.168.0.1') && $ip <= ip2long('192.168.255.255'))||
                ($ip >= ip2long('211.99.254.33') && $ip <= ip2long('211.99.254.63'))
               ) {
            $v = 1;
        }
        else {
            //     $user_helper = new \Snake\Package\User\User();
            //     if ($user_helper->verifyUser2($user_id)) {
            $v = 1;
            //     }
        }
        return $v;
    }
}
