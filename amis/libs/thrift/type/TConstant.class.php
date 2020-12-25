<?php
namespace Thrift\Type;



abstract class TConstant
{
    /**
     * Don't instanciate this class
     */
    protected function __construct() {}

    /**
     * Get a constant value
     * @param  string $constant
     * @return mixed
     */
    public static function get($constant)
    {
        if (is_null(static::$$constant)) {
            static::$$constant = call_user_func(
                    sprintf('static::init_%s', $constant)
                );
        }

        return static::$$constant;
    }
}