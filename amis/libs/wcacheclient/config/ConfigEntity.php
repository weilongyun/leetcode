<?php
namespace wcacheclient\config;

class ConfigEntity
{
    private  $keyPrefix;
    
    private $address;
    
    private $port;
    
    private $clusterId;
    
    private $readTimeOut;
    /**
     * @return the $keyPrefix
     */
    public function getKeyPrefix()
    {
        return $this->keyPrefix;
    }

    /**
     * @return the $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return the $port
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return the $clusterId
     */
    public function getClusterId()
    {
        return $this->clusterId;
    }

    /**
     * @return the $readTimeOut
     */
    public function getReadTimeOut()
    {
        return $this->readTimeOut;
    }

    /**
     * @param field_type $keyPrefix
     */
    public function setKeyPrefix($keyPrefix)
    {
        $this->keyPrefix = $keyPrefix;
    }

    /**
     * @param field_type $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @param field_type $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @param field_type $clusterId
     */
    public function setClusterId($clusterId)
    {
        $this->clusterId = $clusterId;
    }

    /**
     * @param field_type $readTimeOut
     */
    public function setReadTimeOut($readTimeOut)
    {
        $this->readTimeOut = $readTimeOut;
    }

    
    public function __toString()
    {
        return "keyPrefix:".$this->keyPrefix.",address:".$this->address.",port:".$this->port.",clusterId:".$this->clusterId.",readTimeOut:".$this->readTimeOut."\n";
    }
    
  
}