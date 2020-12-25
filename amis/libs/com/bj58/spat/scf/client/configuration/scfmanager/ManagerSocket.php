<?php
namespace com\bj58\spat\scf\client\configuration\scfmanager;

use com\bj58\spat\scf\protocol\utility\ProtocolConst;
use com\bj58\spat\scf\protocol\utility\ByteConverter;
use com\bj58\spat\scf\exception\ScfException;

class ManagerSocket
{
//     private $server;//ManagerServer
    private $handle_ = null;
    private $recvTimeout_ = 3000;
    private $sendTimeout_ = 3000;
    private $sendTimeoutSet_ = FALSE;
    private $persist_ = FALSE;
    private $debug_ = FALSE;
    private $debugHandler_ = null;
    private $managerServerConfig;
    private $isConnected_ = false;

    public function __construct($managerServerConfig)
    {
        $this->managerServerConfig = $managerServerConfig;
    }

    /**
     * Tests whether this is open
     *
     * @return bool true if the socket is open
     */
    public function isOpen()
    {
        return is_resource($this->handle_);
    }

    /**
     * Connects the socket.
     */
    public function open()
    {
        if ($this->isOpen()) {
            throw new ScfException('Socket already connected');
        }

        $host = $this->managerServerConfig->getIp();
        $port = $this->managerServerConfig->getPort();

        if (empty($host)) {
            throw new ScfException('Cannot open null host');
        }

        if ($port <= 0) {
            throw new ScfException('Cannot open without port');
        }

        if ($this->persist_) {
            $this->handle_ = @pfsockopen($host,
                $port,
                $errno,
                $errstr,
                $this->sendTimeout_/1000.0);
        } else {
            $this->handle_ = @fsockopen($host,
                $port,
                $errno,
                $errstr,
                $this->sendTimeout_/1000.0);
        }

        // Connect failed?
        if ($this->handle_ === FALSE) {
            $error = 'TSocket: Could not connect to '.$host.':'.$port.' ('.$errstr.' ['.$errno.'])';
            if ($this->debug_) {
                call_user_func($this->debugHandler_, $error);
            }
            throw new ScfException($error);
        }

        stream_set_timeout($this->handle_, 0, $this->sendTimeout_*1000);
        $this->sendTimeoutSet_ = TRUE;
    }

    /**
     * Closes the socket.
     */
    public function close()
    {
        if (!$this->persist_) {
            @fclose($this->handle_);
            $this->handle_ = null;
        }
    }

    /**
     * Uses stream get contents to do the reading
     *
     * @param int $len How many bytes
     * @return string Binary data
     */
    public function readAll($len)
    {
        if ($this->sendTimeoutSet_) {
            stream_set_timeout($this->handle_, 0, $this->recvTimeout_*1000);
            $this->sendTimeoutSet_ = FALSE;
        }

        $pre = null;
        while (TRUE) {
            $buf = @fread($this->handle_, $len);
            if ($buf === FALSE || $buf === '') {
                $md = stream_get_meta_data($this->handle_);
                if ($md['timed_out']) {
                    throw new ScfException('TSocket: timed out reading '.$len.' bytes from '.
                        $this->managerServerConfig->getIp().':'.$this->managerServerConfig->getPort());
                } else {
                    throw new ScfException('TSocket: Could not read '.$len.' bytes from '.
                        $this->managerServerConfig->getIp().':'.$this->managerServerConfig->getPort());
                }
            } else if (($sz = strlen($buf)) < $len) {
                $md = stream_get_meta_data($this->handle_);
                if ($md['timed_out']) {
                    throw new ScfException('TSocket: timed out reading '.$len.' bytes from '.
                        $this->managerServerConfig->getIp().':'.$this->managerServerConfig->getPort());
                } else {
                    $pre .= $buf;
                    $len -= $sz;
                }
            } else {
                return $pre.$buf;
            }
        }
    }

    /**
     * Read from the socket
     *
     * @param int $len How many bytes
     * @return string Binary data
     */
    public function read($len)
    {
        if ($this->sendTimeoutSet_) {
            stream_set_timeout($this->handle_, 0, $this->recvTimeout_*1000);
            $this->sendTimeoutSet_ = FALSE;
        }
        $data = @fread($this->handle_, $len);
        if ($data === FALSE || $data === '') {
            $md = stream_get_meta_data($this->handle_);
            if ($md['timed_out']) {
                throw new ScfException('TSocket: timed out reading '.$len.' bytes from '.
                    $this->managerServerConfig->getIp().':'.$this->managerServerConfig->getPort());
            } else {
                throw new ScfException('TSocket: Could not read '.$len.' bytes from '.
                    $this->managerServerConfig->getIp().':'.$this->managerServerConfig->getPort());
            }
        }
        return $data;
    }

    /**
     * Write to the socket.
     *
     * @param string $buf The data to write
     */
    public function write($buf)
    {
        if (!$this->sendTimeoutSet_) {
            stream_set_timeout($this->handle_, 0, $this->sendTimeout_*1000);
            $this->sendTimeoutSet_ = TRUE;
        }
        while (strlen($buf) > 0) {
            $got = @fwrite($this->handle_, $buf);
            if ($got === 0 || $got === FALSE) {
                $md = stream_get_meta_data($this->handle_);
                if ($md['timed_out']) {
                    throw new ScfException('TSocket: timed out writing '.strlen($buf).' bytes from '.
                        $this->managerServerConfig->getIp().':'.$this->managerServerConfig->getPort());
                } else {
                    throw new ScfException('TSocket: Could not write '.strlen($buf).' bytes '.
                        $this->managerServerConfig->getIp().':'.$this->managerServerConfig->getPort());
                }
            }
            $buf = substr($buf, $got);
        }
    }

    /**
     * Flush output to the socket.
     */
    public function flush()
    {
        $ret = fflush($this->handle_);
        if ($ret === FALSE) {
            throw new ScfException('TSocket: Could not flush: '.
                $this->managerServerConfig->getIp().':'.$this->managerServerConfig->getPort());
        }
    }

    /**
     * 获取数据
     * @param $writeBinaryData
     * @return binaryData
     * 返回: 版本号（1位）+ 数据长度(4位)， 消息实体(数据长度-5)
     */
    public function request($writeBinaryData)
    {
        if (!$this->isOpen()) {
            $this->open();
        }

        # 写数据
        $checkHeader = array(18, 17, 13, 10, 9);
        $checkFooter = array(9, 10, 13, 17, 18);

        $s = null;$e = null;
        foreach($checkHeader as $v) {
            $s = $s . pack('C', trim($v));
        }
        $temp = count(ProtocolConst::$P_START_TAG) + 4 + strlen($writeBinaryData) + count(ProtocolConst::$P_ENF_TAG);
        $len = ByteConverter::intToBytesBigEndian($temp);
        $e = null;
        foreach($checkFooter as $v) {
            $e = $e . pack('C', trim($v));
        }
        $writeBinaryData = $s . $len . $writeBinaryData . $e;
        $this->write($writeBinaryData);

//    整个数据流： 固定头(5位) + 数据长度(4位)， 消息实体(数据长度-5), 固定尾部(5位)
        # 读数据
        $header = $this->read(9);
        $responseHeaerArr = unpack('c*', $header);

        # 校验头部
        if(!$this->_checkArray($checkHeader, array_slice($responseHeaerArr, 0, 5))) {
            throw new ScfException('Check header failure!');
        }
        # 数据长度
        $fetchLen = ByteConverter::bytesToIntBigEndian(substr($header, 5));
        $responseBinaryData = $this->readAll($fetchLen - 9);

            // 校验尾部
        $bodyArr = unpack('c*', substr($responseBinaryData, $fetchLen - 9 - 5));
        if(!$this->_checkArray($checkFooter, array_slice( $bodyArr, 0, 5))) {
            throw new ScfException('Check footer failure!');
        }

        $returnBinary = substr($responseBinaryData, 8, $fetchLen - 12 - 10);
        return $returnBinary;
    }

    private function _checkArray($arr1, $arr2)
    {
        return $arr1 == $arr2;
    }

    public function getHandle()
    {
        return $this->handle_;
    }

    public function setHandle($handle_)
    {
        $this->handle_ = $handle_;
        return $this;
    }

    public function getRecvTimeout()
    {
        return $this->recvTimeout_;
    }

    public function setRecvTimeout($recvTimeout_)
    {
        $this->recvTimeout_ = $recvTimeout_;
        return $this;
    }

    public function getSendTimeout()
    {
        return $this->sendTimeout_;
    }

    public function setSendTimeout($sendTimeout_)
    {
        $this->sendTimeout_ = $sendTimeout_;
        return $this;
    }

    public function getSendTimeoutSet()
    {
        return $this->sendTimeoutSet_;
    }

    public function setSendTimeoutSet($sendTimeoutSet_)
    {
        $this->sendTimeoutSet_ = $sendTimeoutSet_;
        return $this;
    }

    public function getPersist()
    {
        return $this->persist_;
    }

    public function setPersist($persist_)
    {
        $this->persist_ = $persist_;
        return $this;
    }

    public function getDebug()
    {
        return $this->debug_;
    }

    public function setDebug($debug_)
    {
        $this->debug_ = $debug_;
        return $this;
    }

    public function getDebugHandler()
    {
        return $this->debugHandler_;
    }

    public function setDebugHandler($debugHandler_)
    {
        $this->debugHandler_ = $debugHandler_;
        return $this;
    }

    public function getManagerServerConfig()
    {
        return $this->managerServerConfig;
    }

    public function setManagerServerConfig($managerServerConfig)
    {
        $this->managerServerConfig = $managerServerConfig;
        return $this;
    }

    public function getIsConnected()
    {
        return $this->isConnected_;
    }

    public function setIsConnected($isConnected_)
    {
        $this->isConnected_ = $isConnected_;
        return $this;
    }
}

?>