<?php
namespace Thrift\Transport;

use Thrift\Factory\TStringFuncFactory;


class TBufferedTransport extends TTransport
{
  /**
   * Constructor. Creates a buffered transport around an underlying transport
   */
  public function __construct($transport=null, $rBufSize=512, $wBufSize=512)
  {
    $this->transport_ = $transport;
    $this->rBufSize_ = $rBufSize;
    $this->wBufSize_ = $wBufSize;
  }

  /**
   * The underlying transport
   *
   * @var TTransport
   */
  protected $transport_ = null;

  /**
   * The receive buffer size
   *
   * @var int
   */
  protected $rBufSize_ = 512;

  /**
   * The write buffer size
   *
   * @var int
   */
  protected $wBufSize_ = 512;

  /**
   * The write buffer.
   *
   * @var string
   */
  protected $wBuf_ = '';

  /**
   * The read buffer.
   *
   * @var string
   */
  protected $rBuf_ = '';

  public function isOpen()
  {
    return $this->transport_->isOpen();
  }

  public function open()
  {
    $this->transport_->open();
  }

  public function close()
  {
    $this->transport_->close();
  }

  public function putBack($data)
  {
    if (TStringFuncFactory::create()->strlen($this->rBuf_) === 0) {
      $this->rBuf_ = $data;
    } else {
      $this->rBuf_ = ($data . $this->rBuf_);
    }
  }

  /**
   * The reason that we customize readAll here is that the majority of PHP
   * streams are already internally buffered by PHP. The socket stream, for
   * example, buffers internally and blocks if you call read with $len greater
   * than the amount of data available, unlike recv() in C.
   *
   * Therefore, use the readAll method of the wrapped transport inside
   * the buffered readAll.
   */
  public function readAll($len)
  {
    $have = TStringFuncFactory::create()->strlen($this->rBuf_);
    if ($have == 0) {
      $data = $this->transport_->readAll($len);
    } elseif ($have < $len) {
      $data = $this->rBuf_;
      $this->rBuf_ = '';
      $data .= $this->transport_->readAll($len - $have);
    } elseif ($have == $len) {
      $data = $this->rBuf_;
      $this->rBuf_ = '';
    } elseif ($have > $len) {
      $data = TStringFuncFactory::create()->substr($this->rBuf_, 0, $len);
      $this->rBuf_ = TStringFuncFactory::create()->substr($this->rBuf_, $len);
    }

    return $data;
  }

  public function read($len)
  {
    if (TStringFuncFactory::create()->strlen($this->rBuf_) === 0) {
      $this->rBuf_ = $this->transport_->read($this->rBufSize_);
    }

    if (TStringFuncFactory::create()->strlen($this->rBuf_) <= $len) {
      $ret = $this->rBuf_;
      $this->rBuf_ = '';

      return $ret;
    }

    $ret = TStringFuncFactory::create()->substr($this->rBuf_, 0, $len);
    $this->rBuf_ = TStringFuncFactory::create()->substr($this->rBuf_, $len);

    return $ret;
  }

  public function write($buf)
  {
    $this->wBuf_ .= $buf;
    if (TStringFuncFactory::create()->strlen($this->wBuf_) >= $this->wBufSize_) {
      $out = $this->wBuf_;

      // Note that we clear the internal wBuf_ prior to the underlying write
      // to ensure we're in a sane state (i.e. internal buffer cleaned)
      // if the underlying write throws up an exception
      $this->wBuf_ = '';
      $this->transport_->write($out);
    }
  }

  public function flush()
  {
    if (TStringFuncFactory::create()->strlen($this->wBuf_) > 0) {
      $out = $this->wBuf_;

      // Note that we clear the internal wBuf_ prior to the underlying write
      // to ensure we're in a sane state (i.e. internal buffer cleaned)
      // if the underlying write throws up an exception
      $this->wBuf_ = '';
      $this->transport_->write($out);
    }
    $this->transport_->flush();
  }

}