<?php
namespace com\bj58\spat\scf\transport\loadbalancer;
/**
 * 随机选择一个地址
 */
class SF_RandomLoadBalancer extends SF_LoadBalancerBase{

	/**
	 * @param $nodes 地址数组,数组里边的对象为SF_NodeState
	 * @see SF_LoadBalancer::match()
     * @return SF_NodeState
	 */
	public function match($nodes) {
		//暂时random也是用加权轮询算法。
		$len = count($nodes);
		if($len == 1) {
			return current($nodes);
		}
		$best = null;
		$now = time();
		$total = 0;
		while($best == null) {
			foreach ($nodes as $node) {
				if( !$this->checkNode($node)) {
					continue;
				}
				$total = $total + $node->effective_weight;
			}

			$randWeight = rand(1, $total);
			$tmpWeight = 0;
			foreach ($nodes as $node) {
				if( !$this->checkNode($node)) {
					continue;
				}

				$tmpWeight = $node->effective_weight + $tmpWeight;
				if($node->effective_weight < $node->weight) {
					$node->effective_weight = $node->effective_weight + 1;
					if($node->effective_weight > $node->weight) {
						$node->effective_weight = $node->weight;
					}
				}

				if($tmpWeight >= $randWeight) {
					$best = $node;
					break;
				}
			}

			//表明所有的节点都挂掉了。需要重新恢复，然后再选择
			if($best == null) {
				$rand_key = array_rand($nodes);
				$best = $nodes[$rand_key];
			}
		}

		$best->checked = $now;

		return $best;
	}
}