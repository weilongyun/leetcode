<?php
namespace Thrift\Protocol\JSON;



class LookaheadReader
{
    private $hasData_ = false;
    private $data_ = array();
    private $p_;

    public function __construct($p)
    {
        $this->p_ = $p;
    }

    public function read()
    {
        if ($this->hasData_) {
            $this->hasData_ = false;
        } else {
            $this->data_ = $this->p_->getTransport()->readAll(1);
        }

        return substr($this->data_, 0, 1);
    }

    public function peek()
    {
        if (!$this->hasData_) {
            $this->data_ = $this->p_->getTransport()->readAll(1);
        }

        $this->hasData_ = true;

        return substr($this->data_, 0, 1);
    }
}