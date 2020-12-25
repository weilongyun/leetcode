<?php
namespace wcacheclient\communication;

use wcacheclient\config\ParseResponseConfig;
use wcacheclient\exception\WcacheException;
use wcacheclient\protocol\binary\BinaryRequest;
use wcacheclient\protocol\binary\BinaryResponse;
use wcacheclient\util\ConnAddrUtil;
use wcacheclient\helper\Log;

/**
 * get server ip and port
 *
 * @author 58
 */
class ConnAccessConfig
{

    private $pollInterval;

    public function getServerConfig($addr, $port, $clusterId)
    {
        $ips = array();
        try {
            $ips = ConnAddrUtil::getIps($addr);
        } catch (WcacheException $e) {
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::ERROR, $e->__toString());
            return false;
        }
        if (count($ips) == 0) {
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::ERROR, "$addr is invalided .");
            return false;
        }
        $binaryRequest = new BinaryRequest();
        $requestInfo = $binaryRequest->toBytes($clusterId);
        Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "============ into conn config access server =============");
        $responseInfo = $this->conn($ips, $port, $requestInfo);
        if ($responseInfo === false) {
            throw new WcacheException("get config access server ($addr) failed . please check configaccess server addr $addr or cluserId $clusterId ");
        }
        $binaryResponse = new BinaryResponse();
        $strConfig = '';
        try {
            $binaryResponse->fromByte($responseInfo);
            $strConfig = $binaryResponse->getBufBody();
        } catch (WcacheException $e) {
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::ERROR, "$addr is invalided . \n");
            return false;
        }
        Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "get config ".$strConfig);
        $parseCTC = new ParseResponseConfig();
        $servers = array();
        try {
            $servers = $parseCTC->parseClusterTypeConfiguration($strConfig);
            $this->pollInterval = $parseCTC->getPollInterval();
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "get config success from configaccess server . as follows : ");
            foreach ($servers as $s) {
                Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG,$s);
            } 
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "config poll interval : $this->pollInterval .");
        } catch (WcacheException $e) {
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::ERROR, "ConnAccessConfig::getServerConfig failed . detail : ");
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::ERROR, $e->__toString());
        }
        return $servers;
    }

    /**
     * get memcached server config
     */
    private function conn($ips, $port, $requestInfo)
    {
        $count = count($ips);
        Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "tcp/ip connection . ");
        for ($i = 0; $i < $count; $i ++) {
            $times = $i+1;
            $ip = $ips[$i];
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if ($socket === false) {
                Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::ERROR, "socket_create() failed: reason: " . socket_strerror(socket_last_error()));
                Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::ERROR, "ip : $ip socket_create failed . total times : $count , current time : $i . ");
                $this->closeSocket($socket);
                continue;
            } else {
                Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "OK. ");
            }
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "Attempting to connect to $ip on port $port ...");
            //接收时间限制
            $timeout = array('sec'=>0,'usec'=>50000);
            socket_set_option($socket,SOL_SOCKET,SO_RCVTIMEO,$timeout);
            socket_set_option($socket,SOL_SOCKET,SO_SNDTIMEO,$timeout);
            $pollingIp = false;
            //连接时间限制
            socket_set_nonblock($socket);
            $ret = socket_connect($socket, $ip, $port);
            if ($ret === false) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
            }
            $r = $w = $e = array();
            $w = array($socket);
            $result = socket_select($r,$w,$e,0,50000);
            if ( 0 === $result || false === $result) {
               Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::ERROR, "Connection timed out . ");
               Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::ERROR, "socket_connect() failed.\nReason: configaccess server : $ip : $port is invalided . ");
               Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::ERROR, "ip : $ip socket_connect failed . total times : $count , current times : $count . ");
               $pollingIp = true;
            }
            socket_set_block($socket);
            if ($pollingIp === true) {
                continue;
            }
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "OK .");
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "sending tcp  request ...");
            $ret = socket_write($socket, $requestInfo, strlen($requestInfo));
            if ($ret != strlen($requestInfo)) {
                Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::ERROR, "write error ". $ret);
                continue;
            }
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "Reading response ...");
            $responseHead = '';
            while (strlen($responseHead) != 24) {
                $recvLen = 24 - strlen($responseHead);
                if ($recvLen > 0 ) {
                    $responseHead .= socket_read($socket, $recvLen);
                }
            }
            $totalBodyLen = BinaryResponse::getPacketLen($responseHead);
            $responseInfo = '';
            while (strlen($responseInfo) != $totalBodyLen) {
                $recvLen = $totalBodyLen - strlen($responseInfo);
                if ($recvLen > 0 ) {
                    $responseInfo .= socket_read($socket, $recvLen);
                }
            }
            $responseInfo = $responseHead . $responseInfo;
            $this->closeSocket($socket);
            return $responseInfo;
        }
        return false;
    }

    private function closeSocket($socket)
    {
        Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "closeing socket...");
        socket_close($socket);
        Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "ok .");
    }

    /**
     *
     * @return the $pollInterval
     */
    public function getPollInterval()
    {
        return $this->pollInterval;
    }

    /**
     *
     * @param \wcacheclient\config\the $pollInterval            
     */
    public function setPollInterval($pollInterval)
    {
        $this->pollInterval = $pollInterval;
    }
}
