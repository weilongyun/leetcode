<?php
namespace wcacheclient\verify;
use wcacheclient\exception\WcacheException;

class ClusterVerify
{
    const type = 'php';
    public  function verifyCluster($clusterId) 
    {
        $len = strlen($clusterId);
        $sub = substr($clusterId, $len - 3);
        if (strcmp($sub, self::type) != 0) {
            throw new WcacheException("the cluster isn't belong to php . ");
        }
    }

}
