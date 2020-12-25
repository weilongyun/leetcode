<?php
namespace Thrift\Transport;

use Thrift\Exception\TTransportException;


class TNullTransport extends TTransport
{
  public function isOpen()
  {
    return true;
  }

  public function open() {}

  public function close() {}

  public function read($len)
  {
    throw new TTransportException("Can't read from TNullTransport.");
  }

  public function write($buf) {}

}