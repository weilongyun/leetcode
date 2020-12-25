<?php
namespace com\bj58\spat\scf\transport\loadbalancer;

use com\bj58\spat\scf\transport\loadbalancer\SF_LoadBalancerFactory;

class SF_RoundRobinLoadBalancerFactory implements SF_LoadBalancerFactory {

	public function get() {
		return new SF_RoundRobinBalancer();
	}

}