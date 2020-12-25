<?php
namespace Thrift\Factory;



interface TProtocolFactory
{
  /**
   * Build a protocol from the base transport
   *
   * @return Thrift\Protocol\TProtocol protocol
   */
  public function getProtocol($trans);
}