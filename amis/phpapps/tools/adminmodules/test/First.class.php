<?php

namespace Tools\Adminmodules\Test;


class First extends \Frame\Module {

    public function run() {
        $this->app->response->renderHtml('admin', 'test/first');
        return true;
    }
}
