<?php
require_once __DIR__. '/SFConfig.php';
require_once __DIR__. '/bootstrap.php';

# 请求数据
$dataRaw = '18, 17, 13, 10, 9, 1, 121, 0, 0, 0, 1, 0, 0, 0, 3, 2, 0, 4, 1, -5, 107, -6, 25, 0, -23, 3, 0, 0, 19, 0, 0, 0, 19, 0, 0, 0, 0, -22, 3, 0, 0, 1, 0, 0, 0, 39, 5, -10, -65, 39, 5, -10, -65, 0, -21, 3, 0, 0, 18, 0, 0, 0, 0, -20, 3, 0, 0, 3, 0, 0, 0, 105, 110, 116, 9, 0, 0, 0, 100, 0, 0, 0, 18, 0, 0, 0, 0, -19, 3, 0, 0, 11, 0, 0, 0, 78, 101, 119, 115, 83, 101, 114, 118, 105, 99, 101, 18, 0, 0, 0, 0, -18, 3, 0, 0, 7, 0, 0, 0, 115, 97, 121, 78, 101, 119, 115, 9, 10, 13, 17, 18';

$requestBinaryData = null;
foreach(explode(',', $dataRaw) as $v) {
    $requestBinaryData = $requestBinaryData . pack('c', trim($v));
}
$serviceName = '58.service.test';

# 获取数据
$builder = new SF_ScfClientBuilder();
$builder->clientFactory(new SF_ScfClientFactory()) //scf client
    ->loadBalance(new SF_RandomLoadBalancerFactory()) //负载均衡策略
//    ->loadBalance(new SF_RoundRobinLoadBalancerFactory()) //负载均衡策略
    ->destName($serviceName);  //58服务名
$impl=$builder->build();

try{
    $responseBinaryData = $impl->request($requestBinaryData);
    echo 'GetData:', implode(', ', unpack('c*', $responseBinaryData)), PHP_EOL;
}
catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
    exit;
}

# 当前节点
$node = $impl->getCurrentNode();
echo sprintf('Current Host:%s port:%s weight:%s', $node->getHost(), $node->getPort(), $node->getWeight()), PHP_EOL;