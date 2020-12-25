<?php
namespace Thrift\Factory;

use Thrift\Protocol\TJSONProtocol;


class TJSONProtocolFactory implements TProtocolFactory
{
    public function __construct()
    {
    }

    public function getProtocol($trans)
    {
        return new TJSONProtocol($trans);
    }
}