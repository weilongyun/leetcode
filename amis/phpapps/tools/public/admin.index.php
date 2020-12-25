<?php
// 设置时区
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

date_default_timezone_set('Asia/Shanghai');

$start = microtime(true);

define('FRAME_PATH', __DIR__ . '/../../../frame');
define('LIB_PATH', __DIR__ . '/../../../libs');
define('VENDOR_PATH', __DIR__ . '/../../tools');
define('LOG_PATH',  VENDOR_PATH . '/../../../logs');

require(FRAME_PATH . '/Autoloader.class.php');

$root_path_setting = array(
    'Frame' => FRAME_PATH,
    'Libs' => LIB_PATH,
    'default' => VENDOR_PATH,
);
$autoloader = Autoloader::register($root_path_setting);


$app = \Frame\Application::instance();

//注册module的namespace
$module_prefix = trim(str_replace('index.php', '', basename(__FILE__)), '.');
$app->module_namespace = '\\Tools\\' . ucfirst($module_prefix . "modules") . '\\';


$app->singleton('request', function($c) {
    return new \Libs\Http\BasicRequest();
});
//response
$app->singleton('response', function($c) {
    return new \Libs\Http\BasicResponse();
});
//router
$app->singleton('router', function($c) {
    return new \Libs\Router\BasicRouter($c);
});

$app->singleton('view', function($c) {
    return new \Libs\View\None($c);
});

//声明logWriter
$app->singleton('logWriter', function($c) {
    return new \Libs\Log\BasicLogWriter();
});

$spend = microtime(true) - $start;

$app->run();
