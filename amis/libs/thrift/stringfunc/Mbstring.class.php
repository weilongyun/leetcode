<?php
namespace Thrift\StringFunc;



class Mbstring implements TStringFunc
{
    public function substr($str, $start, $length = null)
    {
        /**
         * We need to set the charset parameter, which is the second
         * optional parameter and the first optional parameter can't
         * be null or false as a "magic" value because that would
         * cause an empty string to be returned, so we need to
         * actually calculate the proper length value.
         */
        if ($length === null) {
            $length = $this->strlen($str) - $start;
        }

        return mb_substr($str, $start, $length, '8bit');
    }

    public function strlen($str)
    {
        return mb_strlen($str, '8bit');
    }
}