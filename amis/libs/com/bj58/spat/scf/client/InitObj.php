<?php
namespace com\bj58\spat\scf\client;

class InitObj
{
    private $defaultlogPath = '';
    private $defaultScfkeyPath = '';

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
}

?>