<?php
namespace Thrift;

use Thrift\Exception\TException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TMultiplexedProtocol;
use Thrift\Protocol\TProtocolDecorator;
use Thrift\Type\TMessageType;


class StoredMessageProtocol extends TProtocolDecorator
{
    private $fname_, $mtype_, $rseqid_;

    public function __construct(TProtocol $protocol, $fname, $mtype, $rseqid)
    {
        parent::__construct($protocol);
        $this->fname_  = $fname;
        $this->mtype_  = $mtype;
        $this->rseqid_ = $rseqid;
    }

    public function readMessageBegin(&$name, &$type, &$seqid)
    {
        $name  = $this->fname_;
        $type  = $this->mtype_;
        $seqid = $this->rseqid_;
    }
}