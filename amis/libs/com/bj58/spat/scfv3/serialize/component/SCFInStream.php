<?php
namespace com\bj58\spat\scf\serialize\component;

use com\bj58\spat\scf\serialize\component\helper\ByteHelper;
use com\bj58\spat\scf\exception\ScfException;
class SCFInStream {

    /**
     * Constructor. Optionally pass an initial value
     * for the buffer.
     */
    public function __construct($buf = '') {
        $this->buf_ = $buf;
    }

    public static $MAX_DATA_LEN = 10485760;
    protected $buf_ = '';
    private $_RefPool = array();

    public function getBuf() {
        return $this->buf_;
    }

    public function getLength() {
        return strlen($this->buf_);
    }

    public function skip($num) {
        if (strlen($this->buf_) < $num) {
            throw new ScfException('read byte from instream out of bound. current len is '. strlen($this->buf_) . ' read len is ' . $num);
        } else {
            $this->buf_ = substr($this->buf_, $num);
        }
    }

    public function GetRef($hashcode) {
        if ($hashcode === 0) {
            return null;
        }
        if (array_key_exists($hashcode, $GLOBALS['scf_RefPool'])) {
            return $GLOBALS['scf_RefPool'][$hashcode];
        } else {
            throw new ScfException('scf refPool not found hashcode ' . $hashcode);
        }
    }

    public function SetRef($hashcode, $obj) {
        $GLOBALS['scf_RefPool'][$hashcode] = $obj;
    }

    public function ReadInt16() {
        $buf = array();
        $buf = $this->read(2);
        return ByteHelper::ToInt16($buf);
    }

    public function ReadInt32() {
        $buf = array();
        $buf = $this->read(4);
        return ByteHelper::ToInt32($buf);
    }

    public function ReadInt64() {
        $buf = array();
        $buf = $this->read(8);
        return ByteHelper::ToInt64($buf);
    }

    public function ReadByte() {
        $buf = $this->read(1);
        $arr = unpack('c', $buf);
        return $arr[1];
    }

    /**
     * read $param(int) from this->buf_ and remove this elements
     * @param unknown $param
     */
    public function read($len) {
        if (strlen($this->buf_) >= $len) {
            $ret = substr($this->buf_, 0, $len);
            $this->buf_ = substr($this->buf_, $len);
            return $ret;
        } else {
            throw new ScfException("StreamException: read stream error!");
        }
    }
}