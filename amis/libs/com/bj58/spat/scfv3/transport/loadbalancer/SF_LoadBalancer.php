<?php
namespace com\bj58\spat\scf\transport\loadbalancer;

interface SF_LoadBalancer {
    /**
     * 给定的服务地址，选定一个
     * @param SF_NodeStates $nodes
     */
    public function match($nodes);
    public function fail($node);
    public function reset();
}

