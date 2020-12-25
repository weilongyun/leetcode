<?php

namespace Libs\QueryBuilder\Adapters;
class Mysql extends BaseAdapter {
    /**
     * @var string
     */
    protected $sanitizer = '`';
}