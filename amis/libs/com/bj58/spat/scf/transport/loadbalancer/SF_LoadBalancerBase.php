<?php
namespace com\bj58\spat\scf\transport\loadbalancer;

abstract class SF_LoadBalancerBase implements SF_LoadBalancer {

    // 失败的节点
    private $_failed_nodes;

    public function __construct() {
        $this->_failed_nodes = array();
    }

    //public abstract function match($nodes);

    public function fail($node) {
        $this->_failed_nodes[] = $node->key();
        $this->updateErrorTimes($node);
    }

    public function reset() {
        $this->_failed_nodes = array();
    }

    /**
     * 检查node是否正常
     * @param $node
     * @return bool
     * true node正常
     * false node不正常
     */
    public function checkNode($node) {
        return !( $node->down() || in_array($node->key(), $this->_failed_nodes) );
    }

    public function getErrorTimes($node) {
        static $times = array();
        $key = "rrb_bad_ip:" . $node->key();

        // 第二次读取该节点的失败次数，说明该节点相对最健康
        if (isset($times[$key])) {
            return 0;
        }

        $time = intval(apcu_fetch($key));
        $times[$key] = $time;
        return $time * 10; // 失败一次，再次使用该节点的概率降低到10%
    }

    public function updateErrorTimes($node) {
        $key = "rrb_bad_ip:" . $node->key();
        apcu_add($key, 0, 900);
        apcu_inc($key, 1);
    }
}
