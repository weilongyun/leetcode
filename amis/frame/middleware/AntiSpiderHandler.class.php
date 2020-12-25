<?php
namespace Frame\Middleware;


class AntiSpiderHandler extends \Frame\Middleware {

    private $callback;

    public function __construct(callable $callback) {
        $this->callback = $callback;
    }

    public function call() {
        $result = array(0, '');
        is_callable($this->callback) && $result = call_user_func($this->callback);
        list($status, $body) = $result;
        if ($status > 0 && $status != 200) {
            http_response_code($status);
            echo $body;
        } else {
            $this->next->call();
        }
    }

}
