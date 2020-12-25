<?php
namespace Thrift\Factory;

use Thrift\StringFunc\Mbstring;
use Thrift\StringFunc\Core;


class TStringFuncFactory
{
    private static $_instance;

    /**
     * Get the Singleton instance of TStringFunc implementation that is
     * compatible with the current system's mbstring.func_overload settings.
     *
     * @return TStringFunc
     */
    public static function create()
    {
        if (!self::$_instance) {
            self::_setInstance();
        }

        return self::$_instance;
    }

    private static function _setInstance()
    {
        /**
         * Cannot use str* functions for byte counting because multibyte
         * characters will be read a single bytes.
         *
         * See: http://us.php.net/manual/en/mbstring.overload.php
         */
        if (ini_get('mbstring.func_overload') & 2) {
            self::$_instance = new Mbstring();
        }
        /**
         * mbstring is not installed or does not have function overloading
         * of the str* functions enabled so use PHP core str* functions for
         * byte counting.
         */
        else {
            self::$_instance = new Core();
        }
    }
}