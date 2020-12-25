<?php
namespace com\bj58\spat\scf\transport\client;
/**
 * virtual interface for all ClientFactory
 */
interface SF_ClientFactory
{
    public function getClient($builder, $host, $port);
}
