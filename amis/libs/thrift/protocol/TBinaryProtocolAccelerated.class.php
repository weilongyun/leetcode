<?php
namespace Thrift\Protocol;

use Thrift\Transport\TBufferedTransport;


class TBinaryProtocolAccelerated extends TBinaryProtocol
{
  public function __construct($trans, $strictRead=false, $strictWrite=true)
  {
    // If the transport doesn't implement putBack, wrap it in a
    // TBufferedTransport (which does)

    // NOTE (t.heintz): This is very evil to do, because the TBufferedTransport may swallow bytes, which
    // are then never written to the underlying transport. This happens precisely when a number of bytes
    // less than the max buffer size (512 by default) is written to the transport and then flush() is NOT
    // called. In that case the data stays in the writeBuffer of the transport, from where it can never be
    // accessed again (for example through read()).
    //
    // Since the caller of this method does not know about the wrapping transport, this creates bugs which
    // are very difficult to find. Hence the wrapping of a transport in a buffer should be left to the
    // calling code. An interface could used to mandate the presence of the putBack() method in the transport.
    //
    // I am leaving this code in nonetheless, because there may be applications depending on this behavior.
    //
    // @see THRIFT-1579

    if (!method_exists($trans, 'putBack')) {
      $trans = new TBufferedTransport($trans);
    }
    parent::__construct($trans, $strictRead, $strictWrite);
  }
  public function isStrictRead()
  {
    return $this->strictRead_;
  }
  public function isStrictWrite()
  {
    return $this->strictWrite_;
  }
}