<?php
namespace WTable\net;
use WTable\protocal\PkgHead;
use WTable\protocal\PkgGetHostList;
use WTable\protocal\Protocal;
use WTable\util\APCuCache;
use WTable\client\WTableClient;
use WTable\exception\WTableException;
use WTable\exception\WTableError;
use WTable\helper\InnerLog;
use WTable\util\Blacklist;

define("EINTR_ERR", 4);

class Net{
	const CACHE_TTL = 30000;
	const EDESTADDRREQ = 89;	 /* Destination address required */
	const ENETDOWN = 100;	 /* Network is down */
	const ENETUNREACH = 101;	 /* Network is unreachable */
	const ENETRESET = 102;	   /* Network dropped connection because of reset */
	const ECONNRESET = 104;	  /* Connection reset by peer */
	const ESHUTDOWN = 108;	   /* Cannot send after transport endpoint shutdown */
	const ETIMEDOUT = 110;	   /* Connection timed out */
	const ECONNREFUSED = 111;	/* Connection refused */ 
	const EHOSTDOWN = 112;	 /* Host is down */
	const EHOSTUNREACH = 113;	 /* No route to host */
	const EALREADY = 114; /*Operation already in progress*/
	const EINPROGRESS  = 115;  /*Operation now in progress*/
	private $proxy;
	private $bid;
	private $cid;
	private $dbid;
	private $password;
	private $dns;
	private $timeout;
	private $connTimeout;
	private $socket;
	private $cache;
	private $hosts;
	private $curHostId;
	private $blacklist;

	public function __construct($bid,$password,$dns){
		$this->bid=$bid;
		$this->dbid = ($this->bid & 0xff);
		$this->cid = $this->bid >> 16;
		$this->password = $password;
		$this->dns = $dns;
		$this->hosts = array();
		$this->curHostId = 0;
		$this->setTimeout(WTableClient::DEFAULT_TIMEOUT);
		$this->setConnTimeout(WTableClient::DEFAULT_CONN_TIMEOUT);
	}
	private static function translateTimeoutToArray($timeout) {
		$usec = $timeout*1000;
		$sec = $usec/1000000;
		$usec = $usec%1000000;
		return array("sec"=>$sec, "usec"=>$usec);
	}
	public function setTimeout($timeout) {
		$this->timeout = self::translateTimeoutToArray($timeout);
	}
	public function setConnTimeout($timeout) {
	    $this->connTimeout = self::translateTimeoutToArray($timeout);
	}
	private static function setSocketTimeout($socket,$timeout) {
		if(!is_array($timeout) || ( 0 == $timeout["sec"] && 0 == $timeout["usec"])) {
			return $socket;
		}
		if (!socket_set_option($socket,SOL_SOCKET,SO_RCVTIMEO,$timeout) ||
			!socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1)) {
			throw new WTableException("socket set option failed: ".socket_strerror(socket_last_error($socket)));
		}
		if (!socket_set_option($socket,SOL_SOCKET,SO_SNDTIMEO,$timeout) ||
			!socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1)) {
			throw new WTableException("socket set option failed: ".socket_strerror(socket_last_error($socket)));
		}
	}
	private static function createSocket($timeout) {
		if(false === ($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))) {
			throw new WTableException("create socket failed : ".socket_strerror(socket_last_error($socket)));
		}
		/*
		$linger = array('l_linger' => 0, 'l_onoff' => 1);
		if (false === socket_set_option($socket, SOL_SOCKET, SO_LINGER, $linger))
		{
			throw new WTableException("socket set option failed : ".socket_strerror(socket_last_error($socket)));
		}
		*/
		self::setSocketTimeout($socket, $timeout);
		return $socket;
	}
	public function closeSocket() {
		if($this->socket){
			socket_close($this->socket);
		}
	}

	private static function readPkg($socket) {
		$rep='';
		$readLen=0;
		do{
			if(false === ($headPkg = socket_read($socket, Protocal::HeadSize))) {
				if (EINTR_ERR == socket_last_error($socket) ){
					continue;
				}
				throw new WTableException(socket_strerror(socket_last_error($socket)));
			}
			if(Null == $headPkg) {
				throw new WTableException("connection is closed by remote peer!", -1);
			}
			$readLen += strlen($headPkg);
			$rep .= $headPkg;
		}while(strlen($rep) < Protocal::HeadSize);

		$pkgHead = new PkgHead(array());
		$n = $pkgHead->decode($rep, $readLen);
		if($n < Protocal::HeadSize){
			throw new WTableException("readPkg pkglen(".$n.") less then headSize!", -2);
		}
		$pkgLen = $pkgHead->pkgLen;
		while($readLen < $pkgLen){
			if(false === ($out = socket_read($socket,$pkgLen - $readLen))) {
				if (EINTR_ERR == socket_last_error($socket) ){
					continue;
				}
				throw new WTableException(socket_strerror(socket_last_error($socket)));
			}
			if(Null == $out) {
				throw new WTableException("connection is closed by remote peer!", -3);
			}
			$rep.=$out;
			$readLen += strlen($out);
		}
		return $rep;
	}
	
	public function init(){
		$this->cache = new APCuCache("WTable");
		if(false === $this->cache->init()) {
			throw new WTableException('init cache failed!');
		}
		$this->blacklist = new Blacklist("WTableBlackList");
		$this->hosts = $this->getActiveHosts();
		//var_dump($this->hosts);
		//echo "</br>";
		if(false === $this->getOneProxy()) {
			throw new WTableException('WTable is unusable!');
		}
	}
	public function getActiveHosts() {
		$activeHosts = array();
		$hosts = $this->getHosts();
		if(NULL === $hosts) {
			return array();
		}
		foreach ($hosts as $value) {
			$res = explode(":", $value->host);
			if(false === $res || count($res) != 2) {
				continue;
			}
			if (true === $this->blacklist->invalid($res[0])) {
				continue;
			}
			$activeHosts[] = $value;
		}
		if(count($activeHosts) !== 0) {
			return $activeHosts;
		}
		return $hosts;
	}
	public function getHosts(){
		$retry = 3;
		$result = array();
		$hosts = Null;
		while($retry) {
			$retry--;
			if(true === $this->cache->get($this->cid, $hosts)) {
				if (count($hosts) !== 0) {
					return $hosts;
				}
			}

			if(false === $this->cache->wLock($this->cid,true)) {
				if(count($hosts) > 0) {
					return $hosts;
				}
				usleep(50000);
				continue;
			}
			if(true === $this->cache->get($this->cid, $hosts)) {
				$this->cache->unWLock($this->cid);
				return $hosts;
			}
			try {
				$reply = $this->reqHostsFromNC();
				if(count($reply->hosts) !== 0){
					//echo "get from namec\n";
					$hosts = $reply->hosts;
					$this->cache->put($this->cid, $reply->hosts, self::CACHE_TTL);
					$this->clearBlacklist($reply->hosts);
				} else{
					throw new WTableException("Proxy address from nc is null!", -1);
				}
			} catch(WTableException $e) {
			    try {
			        InnerLog::logMessage(__CLASS__ . ":" . __LINE__, InnerLog::ERROR, $e->__toString());
				} catch (\Exception $e) {
				    
				}
				if(count($hosts) !== 0){ // put timeout data
						$this->cache->put($this->cid, $hosts, self::CACHE_TTL);
						$this->clearBlacklist($hosts);
				} else {//no timeout data
						$this->cache->unWLock($this->cid);
						continue;
				}
			}
			$this->cache->unWLock($this->cid);
			return $hosts;
		}
		return array();
	}
	private function clearBlacklist($hosts) {
		foreach ($hosts as $value) {
			$res = explode(":", $value->host);
			if(false === $res || count($res) != 2) {
				continue;
			}
			$this->blacklist->reset($res[0]);
		}
	}
	private function reqHostsFromNC(){
		$pkgGetHostList = new PkgGetHostList($this->bid,0);
		$xx = $pkgGetHostList->encode();
		$bytes = $xx['data'];
		//req from namec timeout is 400ms

		$socket = self::createSocket($this->connTimeout);
		$try = 0;
		do{
			if(true === @socket_connect($socket,$this->dns,'6710')){
				break;
			}
			//failed
			$errCode = socket_last_error($socket);
			$errMsg = socket_strerror($errCode);
			try {
			    InnerLog::logMessage(__CLASS__ . ":" . __LINE__, InnerLog::ERROR, $errMsg);
			} catch (\Exception $e) {
			    
			}
			if (EINTR_ERR != $errCode) {
				throw new WTableException("connect to namecenter failed : ".$errMsg, $errCode);
			}
			socket_close($socket);
			$socket = self::createSocket($this->connTimeout); 
			$try++;
		}while($try < 2);
		
		if($try >= 2){
			throw new WTableException("connect to namecenter too many times : ".socket_strerror(socket_last_error($socket)), socket_last_error($socket));
		}
		
		if(false === socket_write($socket,$bytes)) {
			$errCode = socket_last_error($socket);
			$errMsg = socket_strerror($errCode);
			try {
			    InnerLog::logMessage(__CLASS__ . ":" . __LINE__, InnerLog::ERROR, $errMsg);
			} catch (\Exception $e) {
			    
			}
			throw new WTableException("send request to namecentor failed : ".$errMsg, $errCode);
		}

		$rep = self::readPkg($socket);
		socket_close($socket);
		$pkgGetHostList->decode($rep, strlen($rep));
		WTableError::getException($pkgGetHostList->errCode);
		return $pkgGetHostList;
	}
	private function getOneProxy() {
		if(count($this->hosts) !== 0) {
			$i = array_rand($this->hosts);
			$tmp = explode(":",$this->hosts[$i]->host);
			$this->curHostId = $i;
			$this->proxy=array(
				'host' => $tmp[0],
				'port' => $tmp[1]
			);
			return true;
		}
		return false;
	}
	private static function isSocketTimeout($errCode) {
		if(self::ETIMEDOUT == $errCode || self::EINPROGRESS == $errCode || self::EALREADY == $errCode) {
			return true;
		}
		return false;
	}
	public function sendAndRecv($bytes){
		if(!$this->socket){
			$this->socket = self::createSocket($this->connTimeout);
			$retry = 2;
			$start=microtime(true);
			while(false === (@socket_connect($this->socket,$this->proxy['host'], $this->proxy['port']))) {
				$end=microtime(true);
				$cost=($end-$start)*1000;
				$start=$end;
				$errCode = socket_last_error($this->socket);
				$errMsg = $this->proxy['host'].":".$this->proxy['port'].",retry=".$retry.",cost=".$cost.",".socket_strerror($errCode);
				try {
				    InnerLog::logMessage(__CLASS__ . ":" . __LINE__, InnerLog::ERROR, $errMsg);
				} catch (\Exception $e) {
				    
				}
				$retry -= 1;
				if($retry <= 0) {
				    throw new WTableException("sendAndRecv create conn failed :".$errMsg, $errCode);
				}
				if (EINTR_ERR == $errCode || self::EINPROGRESS == $errCode || self::EALREADY == $errCode) {
					socket_close($this->socket);
					$this->socket = self::createSocket($this->connTimeout);
					if (EINTR_ERR == $errCode) {
						continue;
					}
				}
				// put this->proxy to blacklist
				$this->blacklist->inc($this->proxy['host']);
				/*
				if(self::isSocketTimeout($errCode)) {
					throw new WTableException("sendAndRecv create conn failed :".$errMsg, $errCode);
				}
				*/
				array_splice($this->hosts, $this->curHostId, 1);
				if(true === $this->getOneProxy() && $retry > 0) {
					continue;
				}
				throw new WTableException("sendAndRecv create conn failed :".$errMsg, $errCode);
			}
			self::setSocketTimeout($this->socket,$this->timeout);
		}
		
		$retryWrite = 2;
		while(false === socket_write($this->socket, $bytes)) {
			$retryWrite -= 1;
			$errCode = socket_last_error($this->socket);
			$errMsg = socket_strerror($errCode);
			if (EINTR_ERR == $errCode) {
				if($retryWrite > 0) {
                    continue;
				} else {
					throw new WTableException("sendAndRecv write failed : ".$errMsg, $errCode);
				}
			}
			try {
			    InnerLog::logMessage(__CLASS__ . ":" . __LINE__, InnerLog::ERROR, $errMsg);
			} catch (\Exception $e) {
			    
			}
			throw new WTableException("sendAndRecv write failed : ".$errMsg, $errCode);
		}
		return self::readPkg($this->socket);
	}
}
