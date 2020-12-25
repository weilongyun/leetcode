<?php
namespace com\bj58\spat\scf\client\configuration\scfmanager;

class SSMRespData
{
    private $version = 0;//int
    private $serviceName;//String
    private $configChanged;//boolean
    private $lastConfigTime;//long
    private $flag;//object SSMRespDataType
    private $config;//String
    private $forbidCode;//int

    /**
     * @return byte[]
     */
    public function toBytes($ssd)
    {
        $res = json_encode($ssd);
        return $res;
    }

    /**
     * @returnSSMRespData
     * @param String $buf
     */
    public static function fromBytes($buf)
    {
        $rp = json_decode($buf);
        return $rp;
    }

 /**
     * @return the $version
     */
    public function getVersion()
    {
        return $this->version;
    }

 /**
     * @return the $serviceName
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

 /**
     * @return the $configChanged
     */
    public function getConfigChanged()
    {
        return $this->configChanged;
    }

 /**
     * @return the $lastConfigTime
     */
    public function getLastConfigTime()
    {
        return $this->lastConfigTime;
    }

 /**
     * @return the $flag
     */
    public function getFlag()
    {
        return $this->flag;
    }

 /**
     * @return the $config
     */
    public function getConfig()
    {
        return $this->config;
    }

 /**
     * @return the $forbidCode
     */
    public function getForbidCode()
    {
        return $this->forbidCode;
    }

 /**
     * @param number $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

 /**
     * @param field_type $serviceName
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

 /**
     * @param field_type $configChanged
     */
    public function setConfigChanged($configChanged)
    {
        $this->configChanged = $configChanged;
    }

 /**
     * @param field_type $lastConfigTime
     */
    public function setLastConfigTime($lastConfigTime)
    {
        $this->lastConfigTime = $lastConfigTime;
    }

 /**
     * @param field_type $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

 /**
     * @param field_type $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

 /**
     * @param field_type $forbidCode
     */
    public function setForbidCode($forbidCode)
    {
        $this->forbidCode = $forbidCode;
    }
}

?>