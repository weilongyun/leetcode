<?php
namespace com\bj58\spat\scf\serialize\component;

use com\bj58\spat\scf\serialize\component\helper\ByteHelper;

class SCFOutStream
{

    /**
     * Constructor.
     * Optionally pass an initial value
     * for the buffer.
     */
    public function __construct($buf = '')
    {
        $this->buf_ = $buf;
    }

    protected $buf_ = '';

    private $_RefPool = array();
 // map<Integer, Object>
    public function getBuf()
    {
        return $this->buf_;
    }

    /**
     *
     * @param object $obj
     */
    public function WriteRef($obj)
    {
        if (null === $obj) {
            $this->WriteByte(1);
            $this->WriteInt32(0);
            return true;
        }
        $objHashcode = $this->getHashcode($obj);
        if (array_key_exists($objHashcode, $this->_RefPool)) {
            $this->WriteByte(1);
            $this->WriteInt32($objHashcode);
            return true;
        } else {
            $this->_RefPool[$objHashcode] = $obj;
            $this->WriteByte(0);
            $this->WriteInt32($objHashcode);
            return false;
        }
    }

    /**
     * write byte into SCFOutStream
     *
     * @param byte $value
     */
    public function WriteByte($value)
    {
        $data = pack('c', $value);
        $this->write($data);
    }

    /**
     * write short into SCFOutStream
     *
     * @param short $param
     */
    public function WriteInt16($value)
    {
        $buffer = ByteHelper::GetBytesFromInt16($value);
        $this->write($buffer);
    }

    /**
     * write int into SCFOutStream
     *
     * @param int $value
     */
    public function WriteInt32($value)
    {
        $buffer = ByteHelper::GetBytesFromInt32($value);
        $this->write($buffer);
    }

    /**
     * write long into SCFOutStream
     *
     * @param long $value
     */
    public function WriteInt64($value)
    {
        $buffer = ByteHelper::GetBytesFromInt64($value);
        $this->write($buffer);
    }

    /**
     *
     * @param byte[] $buf
     */
    public function write($buf)
    {
        $this->buf_ .= $buf;
    }

    private $hashcode = 1000;
    private $_objMap = array();
 // map<Object, Integer>

    /**
     * compute $obj 's hashcode
     *
     * @param object $obj
     */
    public function getHashcode($obj)
    {
        if (null === $obj) {
            return 0;
        }
        $this->hashcode = $this->hashcode + 1;
        return $this->hashcode;
    }
}