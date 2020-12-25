<?php
namespace com\bj58\spat\scf\transport\core;
/**
 * 服务的某个节点的信息。
 */
class SF_NodeState {
    private $host;
    private $port;

    /**
     * 默认值为1
     * @var unknown
     */
    private $weight = 1;

    /**
     * 当前的weight，初始化为0，每次轮询时会加上effective_weight，对于选中的
     * server会减去total
     * @var unknown
     */
    public $current_weight = 0;

    /**
     * 该权重会在服务发生连接失败是减小，正常连接时增加，但不会大于weight
     * @var unknown
     */
    public $effective_weight;

    /**
     * 记录失败次数
     * @var unknown
     */
    public $fails = 0;

    /**
     * 最大失败次数
     * @var unknown
     */
    public $max_fails = 10;

    /**
     * 上次选中的时间
     * @var unknown
     */
    public $checked;

    /**
     * 检测失败时间，用于计算超时
     * @var unknown
     */
    public $accessed;

    /**
     * 失败重连时间 默认10s
     * @var unknown
     */
    public $fail_timeout = 10;

    /**
     * 是否已经宕机。
     * @var unknown
     */
    private $down;

    /**
     * 是否从故障中恢复
     * @var unknown
     */
    private $resume=false;

    // 得到此结点权重
    public function getWeight() {
        return $this->weight;
    }

    // 得到此结点host
    public function getHost() {
        return $this->host;
    }

    // 得到此结点port
    public function getPort() {
        return $this->port;
    }

    public function key() {
        return $this->host.":".$this->port;
    }

    public function host($host) {
        $this->host=$host;
    }

    public function port($port) {
        $this->port=$port;
    }

    public function weight($weight) {
        $this->weight=$weight;
        $this->current_weight=0;
        $this->effective_weight=$weight;
    }

    public function down() {
    	$now = time();
    	if($this->accessed && $now - $this->accessed > $this->fail_timeout) {
    		$this->resume();
    	}

    	return $this->down;
    }

    public function  resume() {
    	$this->down = false;
    	$this->effective_weight=$this->weight;
    	$this->current_weight=0;
    	$this->fails = 0;
    	$this->resume = true;
    }

    public function setResume($bool) {
        $this->resume = $bool;
    }

    public function fail() {
        $this->fails ++ ;
        if($this->fails > $this->max_fails) {
            $this->fails = $this->max_fails;
        }
        $now = time();

        $this->accessed = $now;
        $this->checked = $now;

        if($this->max_fails) {
            $this->effective_weight = $this->effective_weight - $this->weight / $this->max_fails;
            if($this->fails >= $this->max_fails) {
                $this->down = true;
            }
        }

        if($this->effective_weight < 0) {
            $this->effective_weight = 0;
        }

    }

    public function success() {
        if($this->accessed && $this->checked && $this->accessed < $this->checked) {
        	$this->fails = 0;
        }
    }

    public function __get($name) {
        return $this->$name;
    }
}