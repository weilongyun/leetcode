<?php

namespace Libs\Router;

class BasicRouter {

    protected $app;
    

    public function __construct($app) {
        $this->app = $app;
    }

    public function dispatch() {
        $path_args = $this->app->request->path_args;
        $module = array_shift($path_args);
        $action = array_shift($path_args);

        $module_namespace = $this->app->module_namespace;
        if (empty($module)) {
            $module = 'index';
        }
        if (empty($action)) {
            $action = 'index';
        }  
        $class = $module_namespace . ucwords($module) . '\\' . ucwords($action);
        return $class;
    }

}
