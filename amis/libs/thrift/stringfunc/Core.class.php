<?php
namespace Thrift\StringFunc;



class Core implements TStringFunc
{
    public function substr($str, $start, $length = null)
    {
        // specifying a null $length would return an empty string
        if ($length === null) {
            return substr($str, $start);
        }

        return substr($str, $start, $length);
    }

    public function strlen($str)
    {
        return strlen($str);
    }
}