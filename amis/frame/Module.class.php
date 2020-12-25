<?php

namespace Frame;

abstract class Module {

    protected $app;
    protected $hooks = array(
        'before' => array(),
        'after' => array()
    );

    protected $elapsedTime;

    public function __construct($app) {
        $this->app = $app;
    }

    public function __get($name) {
        return $this->app->$name;
    }

    abstract public function run();

    public function start() {
        $start = microtime(true);

        $this->applyHook('before');
        $this->run();
        $this->applyHook('after');

        $this->elapsedTime = intval((microtime(true) - $start) * 1000);
    }

    public function hook($name, $callable, $priority = 10) {
        if (!isset($this->hooks[$name])) {
            $this->hooks[$name] = array(array());
        }
        if (is_callable($callable)) {
            $this->hooks[$name][(int) $priority][] = $callable;
        }
    }

    public function applyHook($name, $hookArg = null) {
        if (!empty($this->hooks[$name])) {
            // Sort by priority, low to high, if there's more than one priority
            if (count($this->hooks[$name]) > 1) {
                ksort($this->hooks[$name]);
            }
            foreach ($this->hooks[$name] as $priority) {
                if (!empty($priority)) {
                    foreach ($priority as $callable) {
                        call_user_func($callable, $hookArg);
                    }
                }
            }
        }
    }

    public function asyncJob() {
        
    }
}
