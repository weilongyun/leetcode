<?php
namespace com\bj58\spat\scf\client;

class InitObj
{
    private $defaultlogPath = '';
    private $defaultScfkeyPath = '';
    private $serivalizeKey = '';
    private $entityVersion = '';


    public function __construct($defaultScfkeyPath = '', $defaultlogPath = '')
    {
        $this->defaultScfkeyPath = $defaultScfkeyPath;
        $this->defaultlogPath = $defaultlogPath;
    }

 /**
     * @return the $defaultlogPath
     */
    public function getDefaultlogPath()
    {
        return $this->defaultlogPath;
    }

 /**
     * @return the $defaultScfkeyPath
     */
    public function getDefaultScfkeyPath()
    {
        return $this->defaultScfkeyPath;
    }

 /**
     * @param Ambigous <string, unknown> $defaultlogPath
     */
    public function setDefaultlogPath($defaultlogPath)
    {
        $this->defaultlogPath = $defaultlogPath;
    }

 /**
     * @param Ambigous <string, unknown> $defaultScfkeyPath
     */
    public function setDefaultScfkeyPath($defaultScfkeyPath)
    {
        $this->defaultScfkeyPath = $defaultScfkeyPath;
    }

    public function getSerivalizeKey()
    {
        return $this->serivalizeKey;
    }

    public function setSerivalizeKey($serivalizeKey)
    {
        $this->serivalizeKey = $serivalizeKey;
        return $this;
    }

    public function getEntityVersion()
    {
        return $this->entityVersion;
    }

    public function setEntityVersion($entityVersion)
    {
        $this->entityVersion = $entityVersion;
        return $this;
    }
}

?>