<?php
namespace Frame\Middleware;

use \Libs\Wmonitor\WMonitorRBI;

class PrettyExceptionHandler extends \Frame\Middleware
{
    /**
     * @var array
     */
    protected $settings;
    public function __construct($settings = array()) {}

    /**
     * Call
     */
    public function call()
    {
        try {
            $this->next->call();
        }  catch (\Frame\Exception\NotFoundException $e){
            $this->app->response->setStatus(404);            
        } catch (\Exception $e) {
            \Libs\Log\ExceptionLog::Log($e);
            //输出httpcode500
            $this->app->response->setStatus(500);
        }
    }
}
