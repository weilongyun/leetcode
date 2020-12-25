<?php
namespace wcacheclient\test;

require_once __DIR__ . '/../util/Autoload.php';
use wcacheclient\WcacheClient;


var_dump("================== wcacheclient test start =====================");
$wcacheClient = NULL;
try {
    $wcacheClient = new WcacheClient('spat_wljtestself');//xxx_xxx
} catch (\Exception $e) {
    var_dump($e->__toString());
    exit();
}
$key = 'key-test';
$value = 'value-test';
try {
    $wcacheClient->set($key, $value, 60*60);
    $res = $wcacheClient->get($key);
    var_dump($res);
} catch (\Exception $e) {
    var_dump($e->__toString());
}

var_dump("================== wcacheclient test end =====================");


