<?php
namespace com\bj58\spat\scf\transport\client;

class SF_ScfClientFactory implements SF_ClientFactory {

    public function getClient($builder, $host, $port) {

        $client = new SF_ScfClient(
            $host,
            $port
        );

        $tcpConnectTimeout = $builder->tcpConnectTimeout;
        $responseTimeout = $builder->timeout;

        $client->setSendTimeout($tcpConnectTimeout->inMilliseconds());
        $client->setRecvTimeout($responseTimeout->inMilliseconds());

        return $client;
    }
}