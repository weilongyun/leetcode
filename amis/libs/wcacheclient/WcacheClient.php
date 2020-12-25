<?php
namespace wcacheclient;

use wcacheclient\cache\OperCache;
use wcacheclient\exception\WcacheException;
use wcacheclient\common\Constant;
use wcacheclient\helper\Log;
use wcacheclient\util\ArrCmp;
use wcacheclient\verify\KeyVerify;
use wcacheclient\verify\ClusterVerify;
class WcacheClient
{

    private static $configEntity;

    private $mc;

    private $keyPrefix;

    private $timeout;

    /**
     *
     * @param String $clusterId            
     * @param string $keyPrefix            
     * @param number $timeout            
     * @param string $addr            
     * @param number $port            
     * @throws WcacheException , need to try it .
     * node : MAX_KEY_LENGTH 250 ,  KEY_NO_CONTAINS \r\n , MAX_VALUE_LENGTH 1024*1024 . 
     * online : config.access.cache.58dns.org
     * selfTest : 192.168.117.32
     */
    public function __construct($clusterId, $keyPrefix = 'Info-', $timeout = 1000, $addr = '192.168.117.32', $port = 11210)
    {
        if (!class_exists('Memcached')) {
            $this->mc = NULL;
            return;
        } 
        $cv = new ClusterVerify();
        $cv->verifyCluster($clusterId);	 
        $this->keyPrefix = $keyPrefix;
        $this->timeout = $timeout;
        $oPerCache = new OperCache();
        $servers = $oPerCache->getConfig($addr, $port, $clusterId);
        if (count($servers) == 0) {
            throw new WcacheException("get config from apcu cache failed . detail : please check log . ");
        }
        Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, "get wcache server config succ from  apcu . as follows : ");
        foreach ($servers as $s) {
            Log::logMessage(__CLASS__ . ":" . __LINE__, LOG::DEBUG, $s);
        }
        $servers_to_add = array();
        foreach ($servers as $server) {
            $arr = explode(" ", $server);
            if (count($arr) === 5) {
                $servers_to_add[] = array(
                    $arr[1],
                    $arr[2]
                );
            } else 
                if (count($arr) === 4) {
                    $servers_to_add[] = array(
                        $arr[0],
                        $arr[1]
                    );
                }
        }
        Log::logMessage(__CLASS__ . ":" . __LINE__, Log::DEBUG, " start construct mc client .");
        $this->mc = new \Memcached("WCache");
        Log::logMessage(__CLASS__ . ":" . __LINE__, Log::DEBUG, " end construct mc client .");
        $this->setOption($keyPrefix, $timeout);
        if ( !count($this->mc->getServerList())) {
            $this->mc->addServers($servers_to_add);
            $count = count($this->mc->getServerList());
            Log::logMessage(__CLASS__ . ":" . __LINE__, Log::DEBUG, "Now server node   is: $count .");
        } else {
            //是否需要判断配置的变化，进行服务节点变更 
            //$servers_to_add 和  $this->mc->getServerList()
            $arrCmp = new ArrCmp();
            if ($arrCmp->cmpMultiArr($servers_to_add, $this->mc->getServerList()) === false) {
                $this->mc->resetServerList();
                $this->mc->addServers($servers_to_add);
                Log::logMessage(__CLASS__ . ":" . __LINE__, Log::DEBUG, " server-config-modify , wcacheclient got it . ");
            }
            Log::logMessage(__CLASS__ . ":" . __LINE__, Log::DEBUG, " no read servers . ");
        }
    }

    private function setOption($keyPrefix, $timeout)
    {
        if (is_null($this->mc)) {
            return;
        }  
        $this->mc->setOption(\Memcached::OPT_BINARY_PROTOCOL, true);
        $this->mc->setOption(\Memcached::OPT_TCP_NODELAY, true);//ֹNagle DelayedAcknowledgment
        $this->mc->setOption(\Memcached::OPT_COMPRESSION, true); //
        $this->mc->setOption(\Memcached::OPT_PREFIX_KEY, $keyPrefix);
        
        $this->mc->setOption(\Memcached::OPT_CONNECT_TIMEOUT, $timeout);
        $this->mc->setOption(\Memcached::OPT_RETRY_TIMEOUT, 2); //
        $this->mc->setOption(\Memcached::OPT_SEND_TIMEOUT, $timeout);
        $this->mc->setOption(\Memcached::OPT_RECV_TIMEOUT, $timeout);
        $this->mc->setOption(\Memcached::OPT_POLL_TIMEOUT, $timeout);
        $this->mc->setOption(\Memcached::OPT_SERVER_FAILURE_LIMIT, 3);
        
        // consistent hash
        $this->mc->setOption(\Memcached::OPT_DISTRIBUTION, \Memcached::DISTRIBUTION_CONSISTENT);
        $this->mc->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
    }

    public function __destruct()
    {}

    /**
     *
     * @param String $key            
     * @param
     *            Sring or object $value
     * @param int $expiration : expiration-time , unit : s . default 60*60*24*30 s .           
     * @throws WcacheException
     * @return boolean|unknown if key exists. return getResultCode.
     *         Memcached::RES_NOTSTORED
     *   
     */
    public function add($key, $value, $expiration)
    {
        if (is_null($this->mc)) {
            return false;
        } 
        KeyVerify::verifyKey($key, $this->keyPrefix);
        $res = $this->mc->add($key, $value, $expiration);
        if ($res === false) {
            $index = $this->mc->getResultCode();
            if ($index == 12) { //已经存在
                return true;
            }  
            if ($index >= Constant::min_result_index && $index <= Constant::max_reult_index) {
                throw new WcacheException(Constant::$memcached_result[$index]);
            } else {
                throw new WcacheException("unknow exception result code : $index .");
            }
        }
        return $res;
    }

    /**
     *
     * @param String $key            
     * @throws WcacheException
     * @return boolean|unknown
     */
    public function delete($key)
    {
        if (is_null($this->mc)) {
            return false;
        }        
        $res = $this->mc->delete($key);
        if ($res === false) {
            $index = $this->mc->getResultCode();
            if ($index == 16) {
                return true;
            }  
            if ($index >= Constant::min_result_index && $index <= Constant::max_reult_index) {
                throw new WcacheException(Constant::$memcached_result[$index]);
            } else {
                throw new WcacheException("unknow exception result code : $index .");
            }
        }
        return $res;
    }

    /**
     *
     * @param String $key            
     * @param String or object $value
     * @param int $expiration :  expiration-time , unit : s . default 60*60*24*30 s .         
     * @throws WcacheException
     * @return
     *
     */
    public function set($key, $value, $expiration)
    {
        if (is_null($this->mc)) {
            return false;
        }         
        KeyVerify::verifyKey($key, $this->keyPrefix);
        $res = $this->mc->set($key, $value, $expiration);
        if ($res === false) {
            $index = $this->mc->getResultCode();
            if ($index >= Constant::min_result_index && $index <= Constant::max_reult_index) {
                throw new WcacheException(Constant::$memcached_result[$index]);
            } else {
                throw new WcacheException("unknow exception result code : $index .");
            }
        }
        return $res;
    }

    /**
     *
     * @param array $items . key-value-array .           
     * @param int $expiration : expiration-time , unit : s . default 60*60*24*30 s .             
     * @throws WcacheException
     * @return
     *
     */
    public function setMulti($items, $expiration)
    {
        if (is_null($this->mc)) {
            return false;
        }         
        KeyVerify::verifySetKeys($items, $this->keyPrefix);
        $res = $this->mc->setMulti($items, $expiration);
        if ($res === false) {
            $index = $this->mc->getResultCode();
            if ($index >= Constant::min_result_index && $index <= Constant::max_reult_index) {
                throw new WcacheException(Constant::$memcached_result[$index]);
            } else {
                throw new WcacheException("unknow exception result code : $index .");
            }
        }
        return $res;
    }

    /**
     *
     * @param String $key            
     * @throws WcacheException : get result code from memcached server
     * @return String
     */
    public function get($key)
    {
        if (is_null($this->mc)) {
            return NULL;
        }         
        $res = $this->mc->get($key);
        if ($res === false) {
            $index = $this->mc->getResultCode();
            if ($index == 16) {  //没找到
                return $res;
            }  
            if ($index >= Constant::min_result_index && $index <= Constant::max_reult_index) {
                throw new WcacheException(Constant::$memcached_result[$index]);
            } else {
                throw new WcacheException("unknow exception result code : $index .");
            }
        } else {
            return $res;
        }
    }

    /**
     *
     * @param Array $items , key-arrary .            
     * @throws WcacheException
     * @return array
     */
    public function getMulti($items)
    {
        if (is_null($this->mc)) {
            return NULL;
        }         
        $null = null;
        $res = $this->mc->getMulti($items, $null, \Memcached::GET_PRESERVE_ORDER);
        if (is_array($res)) {
            return $res;
        } elseif ($res === false) {
            $index = $this->mc->getResultCode();
            if ($index == 16) {  //没找到
                return $res;
            }             
            if ($index >= Constant::min_result_index && $index <= Constant::max_reult_index) {
                throw new WcacheException(Constant::$memcached_result[$index]);
            } else {
                throw new WcacheException("unknow exception result code : $index .");
            }
        }
    }

    /**
     *
     * @param String $key            
     * @param int $offset            
     * @throws WcacheException
     * @return 
     * node1 : the key need to exist before incr .
     * node2 : key-value : value is number .
     */
    public function increment($key, $offset = 1)
    {
        if (is_null($this->mc)) {
            return false;
        }         
        $res = $this->mc->increment($key, $offset);
        if ($res === false) {
            $index = $this->mc->getResultCode();
            if ($index >= Constant::min_result_index && $index <= Constant::max_reult_index) {
                throw new WcacheException(Constant::$memcached_result[$index]);
            } else {
                throw new WcacheException("unknow exception result code : $index .");
            }
        } else {
            return $res;
        }
    }
 
    /**
     *
     * @param int $key            
     * @param int $offset            
     * @throws WcacheException
     * @return
     * node1 : the key need to exist before incr .
     * node2 : key-value : value is number .
     */
    public function decrement($key, $offset = 1)
    {
        if (is_null($this->mc)) {
            return false;
        }         
        $res = $this->mc->decrement($key, $offset);
        if ($res === false) {
            $index = $this->mc->getResultCode();
            if ($index >= Constant::min_result_index && $index <= Constant::max_reult_index) {
                throw new WcacheException(Constant::$memcached_result[$index]);
            } else {
                throw new WcacheException("unknow exception result code : $index .");
            }
        } else {
            return $res;
        }
    }
    
    public function getResultCode() {
        if (is_null($this->mc)) {
            return false;
        } 
        return $this->mc->getResultCode();        
    } 
}