<?php
namespace wcacheclient\cache;
use wcacheclient\cache\APCuCache;
use wcacheclient\communication\ConnAccessConfig;
use wcacheclient\exception\WcacheException;
use wcacheclient\helper\Log;

class OperCache
{

    private $clusterId;

    private $cache;
    
    private $pollInterval;

    public function getConfig($addr, $port, $clusterId)
    {
        $this->clusterId = $clusterId;
        $this->cache = new APCuCache('WCache');
        $this->cache->init();
        $reset = 3;
        $result = array();
        $config = NULL;
        while ($reset) {
            $reset--;
            if (true === $this->cache->get($this->clusterId, $config)) {
                if (count($config) !== 0)
                {
                    Log::logMessage(__LINE__, Log::DEBUG, "first : get config : " . implode(",", $config));
                    return $config;
                }
            }
            Log::logMessage(__LINE__, Log::DEBUG, "apcu timeouted");
            if (false === $this->cache->wLock($this->clusterId, true))
            {
                if (count($config) > 0)
                {
                    Log::logMessage(__LINE__, Log::DEBUG, "retry  : get config : times is $reset ." );
                    return $config;
                }
                usleep(20000);//20ms
                continue;
            }

            if (true === $this->cache->get($this->clusterId, $config))
            {
                $this->cache->unWLock($this->clusterId);
                //TODO
                Log::logMessage(__LINE__, Log::DEBUG, "second : get config : " . implode(",", $config));
                return $config;
            } 

            $replyConfig = $this->reqFromConfigAccess($addr, $port, $clusterId);
            //TODO
            $getConnFromCA = count($replyConfig);
            Log::logMessage(__CLASS__ . ":" . __LINE__ , Log::DEBUG, "third : get config from CA : config-array-count : $getConnFromCA");
            if (count($replyConfig) !== 0)
            {
                $config = $replyConfig;
                Log::logMessage(__CLASS__ . ":" . __LINE__ , LOG::DEBUG, "store into apcu, pollInterval is $this->pollInterval");
                $this->cache->put($this->clusterId, $config, $this->pollInterval);
                Log::logMessage(__CLASS__ . ":" . __LINE__ , LOG::DEBUG, "wcache server config store into file and apcu succ . " );
            } else if(count($config) !== 0){
                $this->cache->put($this->clusterId, $config, 12000);
                Log::logMessage(__CLASS__ . ":" . __LINE__ , LOG::DEBUG, "restore apcu and file data ." );
            } else {
                $this->cache->unWLock($this->clusterId);
                continue;
            }
            Log::logMessage(__CLASS__ . ":" . __LINE__ , LOG::DEBUG, "get server succ . " );
            $this->cache->unWLock($this->clusterId);
            return $config;
        }
        return array();
    }

    public function reqFromConfigAccess($addr, $port, $clusterId)
    {
        $ret = array();
        $connAccConf = new ConnAccessConfig();
        try {
            $result = $connAccConf->getServerConfig($addr, $port, $clusterId);
            if (is_array($result) && count($result) > 0) {
                $this->pollInterval = $connAccConf->getPollInterval();
                return $result;
            } else  {
                Log::logMessage(__CLASS__ . ":" . __LINE__ , LOG::ERROR, "get server config from access config failed . res = false . " );
                return $ret;           
            }
            
        } catch (WcacheException $e) {
            Log::logMessage(__CLASS__ . ":" . __LINE__ , LOG::ERROR, "get server config from access config failed . " );
            Log::logMessage(__CLASS__ . ":" . __LINE__ , LOG::ERROR, $e->__toString() );
        }
        return $ret;
    }
    /**
     * @return the $clusterId
     */
    public function getClusterId()
    {
        return $this->clusterId;
    }

    /**
     * @return the $cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @return the $pollInterval
     */
    public function getPollInterval()
    {
        return $this->pollInterval;
    }

    /**
     * @param field_type $clusterId
     */
    public function setClusterId($clusterId)
    {
        $this->clusterId = $clusterId;
    }

    /**
     * @param \wcacheclient\cache\APCuCache $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param \wcacheclient\communication\the $pollInterval
     */
    public function setPollInterval($pollInterval)
    {
        $this->pollInterval = $pollInterval;
    }



}


