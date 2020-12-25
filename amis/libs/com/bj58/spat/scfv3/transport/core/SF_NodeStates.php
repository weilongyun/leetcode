<?php
namespace com\bj58\spat\scf\transport\core;
use com\bj58\spat\scf\transport\util\SF_Duration;
/**
 * 服务所有节点的信息。
 * @author xingwenge
 */
class SF_NodeStates {
    private $_nodeStates; //[key=>SF_NodeState]
    private $_createTime; //创建时间 SF_Duration
    private $_apcuStoreTTL = 60; //apcu缓存SF_NodeStates的时间

    private $_sendTimeout; //写时间
    private $_receiveTimeout; //读时间

    /**
     * @return [SF_NodeState]
     */
    public function getNodeStates() {
        return $this->_nodeStates;
    }

    /**
     * 设置节点
     * @param null $key
     * @param SF_NodeState $nodeState
     */
    public function setNodeState($key, SF_NodeState $nodeState) {
            $this->_nodeStates[$key] = $nodeState;
    }

    /**
     * 设置创建时间
     * @param $time
     */
    public function setCreateTime(SF_Duration $duration) {
        $this->_createTime = $duration;
    }

    /**
     * @return SF_Duration
     */
    public function getCreateTime() {
        return $this->_createTime;
    }

    /**
     * 设置apcu缓存时间(秒）
     * @param int $second
     */
    public function setApcuStoreTTL($second) {
        $this->_apcuStoreTTL = $second;
    }

    /**
     * @return int
     */
    public function getApcuStoreTTL() {
        return $this->_apcuStoreTTL;
    }

    /**
     * @return mixed
     */
    public function getSendTimeout()
    {
        return $this->_sendTimeout;
    }

    /**
     * @param mixed $sendTimeout
     */
    public function setSendTimeout($sendTimeout)
    {
        $this->_sendTimeout = $sendTimeout;
    }

    /**
     * @return mixed
     */
    public function getReceiveTimeout()
    {
        return $this->_receiveTimeout;
    }

    /**
     * @param mixed $receiveTimeout
     */
    public function setReceiveTimeout($receiveTimeout)
    {
        $this->_receiveTimeout = $receiveTimeout;
    }

}