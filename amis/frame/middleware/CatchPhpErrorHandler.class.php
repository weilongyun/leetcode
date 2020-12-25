<?php
/**
 * 线上服务异常捕捉
 * Class MonitorManager
 * @author  haitaoguo
 */
namespace Frame\Middleware;

use \Libs\Wmonitor\WMonitorRBI;

class CatchPhpErrorHandler extends \Frame\Middleware
{

    private $callback;

    public function __construct()
    {
    }

    public function call()
    {
        register_shutdown_function(function (){
            $error = error_get_last();

        });
        set_error_handler(function ($errNo , $errStr )  {
            return FALSE;
        }, E_WARNING);

        $this->next->call();
    }

}

