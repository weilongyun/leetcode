<?php
namespace com\bj58\spat\scf\transport\loadbalancer;

class SF_RandomLoadBalancerFactory implements SF_LoadBalancerFactory {

	function get() {
		return new SF_RandomLoadBalancer();
	}

}