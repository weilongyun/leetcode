<?php
namespace Libs\Wmonitor;

class Socket
{
    private $sock;
    private $ip;
    private $port;

    public function __construct($ip = "127.0.0.1", $port = "36001")
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->initSock();
    }

    private function initSock()
    {
        $this->sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_set_option($this->sock, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 0, 'usec' => 50));
        socket_set_nonblock($this->sock);
    }

    public function sendto($msg, $len)
    {
        if (!is_resource($this->sock)) {
            $this->initSock();
        }
        if (is_resource($this->sock)) {
            $result = socket_sendto($this->sock, $msg, $len, 0, $this->ip, $this->port);

            if ($result == FALSE) {
                error_log("send error");
            }
            return $result;
        } else {
            error_log("sock can not open");
            return 0;
        }
    }

    public function close()
    {
        socket_close($this->sock);
    }

}


abstract class IWMonitor
{

    public abstract function sum($attributeId, $value = 1);

    public abstract function average($attributeId, $value, $times = 1);

    public abstract function max($attributeId, $value);

}

#header,total length,version,compress type, body,end
abstract class Protocol
{
    protected $version;
    protected $api;


    public abstract function toBinStr();
}

class IDValue extends Protocol
{
    private $id;
    private $value;

    public function __construct($api)
    {
        $this->version = 1;
        $this->api = $api;
    }

    public function toBinStr()
    {
        $header = pack("c", 1);
        $totalLength = pack("N", 19);
        $v = pack("c", $this->version);
        $compressType = pack("c", 99);
        $end = pack("c",3);

        $api = pack("c", $this->api);
        $lan = pack("c", 2); //1=java,2=php,3=c
        $ver = pack("c", 1); //2 php
        $data = array($header, $totalLength, $v, $compressType, $api, $lan, $ver);

        array_push($data, pack("N", $this->id), pack("N", $this->value),$end);

        return join("", $data);
    }

    public function set($attributeId, $value)
    {
        $this->id = $attributeId;
        $this->value = $value;
    }

}

class Avg extends Protocol
{
    private $id;
    private $value;
    private $times;

    public function __construct()
    {
        $this->version = 1;
        $this->api = 2;
    }

    public function toBinStr()
    {
        $header = pack("c", 1);
        $totalLength = pack("N", 19);
        $v = pack("c", $this->version);
        $compressType = pack("c", 99);
        $end = pack("c",3);

        $api = pack("c", $this->api);
        $lan = pack("c", 2); //2 php
        $ver = pack("c", 1); //2 php
        $data = array($header, $totalLength, $v, $compressType, $api, $lan, $ver);
        array_push($data, pack("N", $this->id), pack("N", $this->value), pack("N", $this->times),$end);
        return join("", $data);
    }

    public function avg($attributeId, $value, $times)
    {
        $this->id = $attributeId;
        $this->value = $value;
        $this->times = $times;
    }
}


class WMonitor extends IWMonitor
{
    private static $_instance;

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    private $sum;
    private $max;
    private $avg;

    private $sock;


    private function __construct()
    {
        $this->sock = new Socket();
        $this->sum = new IDValue(1);
        $this->max = new IDValue(3);
        $this->avg = new Avg();
        $this->min = new IDValue(4);

    }


    public function sum($attributeId, $value = 1)
    {
        $this->sum->set($attributeId, $value);
        $data = $this->sum->toBinStr();
        $this->sock->sendto($data, strlen($data));
    }


    function average($attributeId, $value, $times = 1)
    {
        $this->avg->avg($attributeId, $value, $times);
        $data = $this->avg->toBinStr();
        $this->sock->sendto($data, strlen($data));
    }

    public function max($attributeId, $value)
    {
        $this->max->set($attributeId, $value);
        $data = $this->max->toBinStr();
        $this->sock->sendto($data, strlen($data));

    }


    function min($attributeId, $value)
    {
        $this->min->set($attributeId, $value);
        $data = $this->min->toBinStr();
        $this->sock->sendto($data, strlen($data));

    }


    public function __destruct()
    {
        $this->sock->close();
    }
}



