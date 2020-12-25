<?php
namespace Thrift\Packages\Scribe;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


interface ScribeIf extends \Thrift\Packages\Fb303\FacebookServiceIf {
  /**
   * @param \Thrift\Packages\Scribe\LogEntry[] $messages
   * @return int
   */
  public function Log(array $messages);
}