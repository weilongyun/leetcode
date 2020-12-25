<?php
namespace Libs\Demand;
/**
 * Created by PhpStorm.
 * User: baihao
 * Date: 2016/9/7
 * Time: 17:08
 */
class WtableConfig {

    const ONLINE = 0;
    const OFFLINE = 1;

    private static $envType = array(
        self::OFFLINE => array(
            'bid' => 655399,
            'password' => 'cOwRKiwr7cb8UeSr',
            'addr' => 'namevtest.wtable.58dns.org',
            'timeout' => 1000,
        ),
        self::ONLINE => array(
            'bid' => 131268626,
            'password' => 'LJ2HnoPmbvZ4iCV5',
            'addr' => 'nameprod.wtable.58dns.org',
            'timeout' => 1000,
        ),
    );

    public static function GetEnvTypeById($id) {
        if (isset(self::$envType[$id])) {
            return self::$envType[$id];
        } else {
            return self::$envType[$GLOBALS['IS_DEV_ENV']];
        }
    }


}