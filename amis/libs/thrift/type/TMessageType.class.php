<?php
namespace Thrift\Type;



class TMessageType
{
  const CALL  = 1;
  const REPLY = 2;
  const EXCEPTION = 3;
  const ONEWAY = 4;
}