<?php
namespace Thrift\Factory;

use Thrift\Protocol\TCompactProtocol;


class TCompactProtocolFactory implements TProtocolFactory
{
  public function __construct()
  {
  }

  public function getProtocol($trans)
  {
    return new TCompactProtocol($trans);
  }
}