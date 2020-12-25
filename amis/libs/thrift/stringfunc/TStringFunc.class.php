<?php
namespace Thrift\StringFunc;



interface TStringFunc
{
    public function substr($str, $start, $length = null);
    public function strlen($str);
}