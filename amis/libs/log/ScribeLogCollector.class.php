<?php

namespace Libs\Log;

use Thrift\Packages\Scribe\LogEntry;
use Thrift\Packages\Scribe\ScribeClient;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TSocket;

class ScribeLogCollector extends LogCollector {
    private $nodes;

    public function __construct() {
        $config = \Frame\ConfigFilter::instance()->getConfig('remote');
        $this->nodes = $config['scribe'];
    }

    private function getScribeClient() {
        if (!is_array($this->nodes) || empty($this->nodes)) {
            throw new \Exception('invalid LOG_SERVER_CONFIG');
        }
        $node = $this->nodes[rand(0, count($this->nodes) - 1)];
        $socket = new TSocket($node['host'], $node['port'], TRUE);
        $socket->setSendTimeout(100);
        $socket->setRecvTimeout(100);
        $transport = new TFramedTransport($socket);
        $protocol = new TBinaryProtocolAccelerated($transport);
        $client = new ScribeClient($protocol, $protocol);
        return array($client, $transport);
    }

    public function sendLog($mark, $str) {
        list($client, $transport) = $this->getScribeClient();
        $transport->open();
        !empty($_SERVER['SERVER_ADDR']) ? $n_ip = $_SERVER['SERVER_ADDR'] : $n_ip = '127.0.0.1';
        $from_ip = '';//gethostbyname(gethostname());
        $str .= "\t[$from_ip]\t[$n_ip]";
        $msg1['category'] = $mark;
        $msg1['message'] = $str;
        $entry1 = new LogEntry($msg1);
        $message = array($entry1);
        $client->Log($message);
        $transport->close();
    }
}
