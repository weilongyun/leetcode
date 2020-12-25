<?php
namespace com\bj58\spat\scf\transport\loadbalancer;

class SF_RoundRobinBalancer extends SF_LoadBalancerBase{

	public function match($nodes) {
		//表示还没有选择过，这时候就random选择一台机器。
		//如果在一个context里边调用多次，在下次顺序选择机器
		$len = count($nodes);
		if($len == 1) {
			return current($nodes);
		}
		$node=null;
		$best = null;

		$now = time();
		$total = 0;

		shuffle($nodes);
		while($best == null) {
			foreach ($nodes as $node) {
				if( !$this->checkNode($node)) {

					continue;
				}

				$node->current_weight = $node->current_weight  + $node->effective_weight;
				$total = $total + $node->effective_weight;

				if($node->effective_weight < $node ->weight) {   //增加effective_weight比重
					$node->effective_weight = $node->effective_weight + 1;
				}

				if($best == null || $node->current_weight > $best->current_weight) {  // 找出更优node
					$best = $node;
				}
			}

			//表明所有的节点都挂掉了。需要重新恢复，然后再选择
			if($best == null) {
				$rand_key = array_rand($nodes);
				$best = $nodes[$rand_key];
			}

			// 该节点失败过，重新取最健康的
			$times = $this->getErrorTimes($best);
			if ($times) {
				$best->current_weight = $best->current_weight - $total * $times;
				$best = null;
			}
		}

		$best->current_weight = $best->current_weight - $total;
		$best->checked = $now;

		return $best;
	}

}