<?php
namespace Thrift\Protocol\JSON;



class BaseContext
{
    public function escapeNum()
    {
        return false;
    }

    public function write()
    {
    }

    public function read()
    {
    }
}