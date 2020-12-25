<?php
namespace Thrift\Transport;

use Thrift\Exception\TTransportException;
use Thrift\Factory\TStringFuncFactory;


class TMemoryBuffer extends TTransport
{
  /**
   * Constructor. Optionally pass an initial value
   * for the buffer.
   */
  public function __construct($buf = '')
  {
    $this->buf_ = $buf;
  }

  protected $buf_ = '';

  public function isOpen()
  {
    return true;
  }

  public function open() {}

  public function close() {}

  public function write($buf)
  {
    $this->buf_ .= $buf;
  }

  public function read($len)
  {
    $bufLength = TStringFuncFactory::create()->strlen($this->buf_);

    if ($bufLength === 0) {
      throw new TTransportException('TMemoryBuffer: Could not read ' .
                                    $len . ' bytes from buffer.',
                                    TTransportException::UNKNOWN);
    }

    if ($bufLength <= $len) {
      $ret = $this->buf_;
      $this->buf_ = '';

      return $ret;
    }

    $ret = TStringFuncFactory::create()->substr($this->buf_, 0, $len);
    $this->buf_ = TStringFuncFactory::create()->substr($this->buf_, $len);

    return $ret;
  }

  public function getBuffer()
  {
    return $this->buf_;
  }

  public function available()
  {
    return TStringFuncFactory::create()->strlen($this->buf_);
  }
}