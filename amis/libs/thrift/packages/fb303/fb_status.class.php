<?php
namespace Thrift\Packages\Fb303;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


class fb_status {
  const DEAD = 0;
  const STARTING = 1;
  const ALIVE = 2;
  const STOPPING = 3;
  const STOPPED = 4;
  const WARNING = 5;
  static public $__names = array(
    0 => 'DEAD',
    1 => 'STARTING',
    2 => 'ALIVE',
    3 => 'STOPPING',
    4 => 'STOPPED',
    5 => 'WARNING',
  );
}