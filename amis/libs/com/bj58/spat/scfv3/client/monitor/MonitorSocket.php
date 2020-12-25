<?php
namespace com\bj58\spat\scf\client\monitor;

use com\bj58\spat\scf\transport\exception\SF_SocketException;
class MonitorSocket
{
    /**
     * Handle to PHP socket
     *
     * @var resource
     */
    private $handle_ = null;

    /**
     * Remote hostname
     *
     * @var string
     */
    protected $host_ = 'localhost';

    /**
     * Remote port
     *
     * @var int
     */
    protected $port_ = '30000';

    /**
     * Send timeout in milliseconds
     *
     * @var int
     */
    private $sendTimeout_ = 3000;

    /**
     * Recv timeout in milliseconds
     *
     * @var int
     */
    private $recvTimeout_ = 3000;

    /**
     * Is send timeout set?
     *
     * @var bool
     */
    private $sendTimeoutSet_ = FALSE;

    /**
     * Socket constructor
     *
     * @param string $host         Remote hostname
     * @param int    $port         Remote port
     */
    public function __construct($monitorServerConfig) {
        $this->host_ = $monitorServerConfig->getIp();
        $this->port_ = $monitorServerConfig->getPort();
        $this->sendTimeout_ = $monitorServerConfig->getSendTimeout();
        $this->recvTimeout_ = $monitorServerConfig->getRecvTimeout();
    }

    /**
     * @param resource $handle
     * @return void
     */
    public function setHandle($handle) {
        $this->handle_ = $handle;
    }

    /**
     * Sets the send timeout.
     *
     * @param int $timeout  Timeout in milliseconds.
     */
    public function setSendTimeout($timeout) {
        $this->sendTimeout_ = $timeout;
    }

    /**
     * Sets the receive timeout.
     *
     * @param int $timeout  Timeout in milliseconds.
     */
    public function setRecvTimeout($timeout) {
        $this->recvTimeout_ = $timeout;
    }

    /**
     * Get the host that this socket is connected to
     *
     * @return string host
     */
    public function getHost() {
        return $this->host_;
    }

    /**
     * Get the remote port that this socket is connected to
     *
     * @return int port
     */
    public function getPort() {
        return $this->port_;
    }

    /**
     * Tests whether this is open
     *
     * @return bool true if the socket is open
     */
    public function isOpen() {
        return is_resource($this->handle_);
    }

    /**
     * Connects the socket.
     */
    public function open() {
        if (empty($this->host_)) {
            throw new SF_SocketException('Cannot open null host');
        }

        if ($this->port_ <= 0) {
            throw new SF_SocketException('Cannot open without port');
        }

        if ($this->handle_ === FALSE) {
            $error = 'Socket: Could not connect to '.$this->host_.':'.$this->port_.' ('.$errstr.' ['.$errno.'])';
            throw new SF_SocketException($error);
        }

        $this->handle_ = stream_socket_client("udp://{$this->host_}:{$this->port_}", $errno, $errstr, $this->sendTimeout_*1000);
        $this->sendTimeoutSet_ = TRUE;
        return $this->handle_;
    }

    /**
     * 获取数据
     * @param $writeBinaryData
     * @return binaryData
     */
    public function request($writeBinaryData) {
        $this->open();

        # 写数据
        $this->write($writeBinaryData);
    }


    /**
     * Uses stream get contents to do the reading
     *
     * @param int $len How many bytes
     * @return string Binary data
     */
    public function readAll($len) {
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
                    throw new SF_SocketException('TSocket: timed out reading '.$len.' bytes from '.
                        $this->host_.':'.$this->port_);
                } else {
                    throw new SF_SocketException('TSocket: Could not read '.$len.' bytes from '.
                        $this->host_.':'.$this->port_);
                }
            } else if (($sz = strlen($buf)) < $len) {
                $md = stream_get_meta_data($this->handle_);
                if ($md['timed_out']) {
                    throw new SF_SocketException('TSocket: timed out reading '.$len.' bytes from '.
                        $this->host_.':'.$this->port_);
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
    public function read($len) {
        if ($this->sendTimeoutSet_) {
            stream_set_timeout($this->handle_, 0, $this->recvTimeout_*1000);
            $this->sendTimeoutSet_ = FALSE;
        }
        $data = @fread($this->handle_, $len);
        if ($data === FALSE || $data === '') {
            $md = stream_get_meta_data($this->handle_);
            if ($md['timed_out']) {
                throw new SF_SocketException('TSocket: timed out reading '.$len.' bytes from '.
                    $this->host_.':'.$this->port_);
            } else {
                throw new SF_SocketException('TSocket: Could not read '.$len.' bytes from '.
                    $this->host_.':'.$this->port_);
            }
        }
        return $data;
    }

    /**
     * Write to the socket.
     *
     * @param string $buf The data to write
     */
    public function write($buf) {
        if (!$this->sendTimeoutSet_) {
            stream_set_timeout($this->handle_, 0, $this->sendTimeout_*1000);
            $this->sendTimeoutSet_ = TRUE;
        }
        while (strlen($buf) > 0) {
            $got = @fwrite($this->handle_, $buf);
            if ($got === 0 || $got === FALSE) {
                $md = stream_get_meta_data($this->handle_);
                if ($md['timed_out']) {
                    throw new SF_SocketException('TSocket: timed out writing '.strlen($buf).' bytes from '.
                        $this->host_.':'.$this->port_);
                } else {
                    throw new SF_SocketException('TSocket: Could not write '.strlen($buf).' bytes '.
                        $this->host_.':'.$this->port_);
                }
            }
            $buf = substr($buf, $got);
        }
    }

    /**
     * Closes the socket.
     */
    public function close() {
        @fclose($this->handle_);
        $this->handle_ = null;
    }

    /**
     * @param $arr1
     * @param $arr2
     * @return bool
     */
    private function _checkArray($arr1, $arr2) {
        return $arr1 == $arr2;
    }

    private function _bytesToInteger($bytes, $position) {
        $val = 0;
        $val = $bytes[$position + 3] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position + 2] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position + 1] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position] & 0xff;
        return $val;
    }
}

?>