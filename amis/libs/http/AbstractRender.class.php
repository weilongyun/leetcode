<?php

namespace Libs\Http;

/**
 * @desc render base
 */
abstract class AbstractRender {

    abstract function assign($key, $val);

    abstract function fetch($controllerName, $actionName);

    abstract function render($controllerName, $actionName);
}
