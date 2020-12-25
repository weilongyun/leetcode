<?php
namespace Thrift\Protocol\JSON;

use Thrift\Protocol\TJSONProtocol;


class PairContext extends BaseContext
{
    private $first_ = true;
    private $colon_ = true;
    private $p_ = null;

    public function __construct($p)
    {
        $this->p_ = $p;
    }

    public function write()
    {
        if ($this->first_) {
            $this->first_ = false;
            $this->colon_ = true;
        } else {
            $this->p_->getTransport()->write($this->colon_ ? TJSONProtocol::COLON : TJSONProtocol::COMMA);
            $this->colon_ = !$this->colon_;
        }
    }

    public function read()
    {
        if ($this->first_) {
            $this->first_ = false;
            $this->colon_ = true;
        } else {
            $this->p_->readJSONSyntaxChar($this->colon_ ? TJSONProtocol::COLON : TJSONProtocol::COMMA);
            $this->colon_ = !$this->colon_;
        }
    }

    public function escapeNum()
    {
        return $this->colon_;
    }
}