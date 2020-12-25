<?php
namespace com\bj58\spat\scf\protocol\sfp;

use com\bj58\spat\scf\protocol\utility\ProtocolHelper;
use com\bj58\spat\scf\exception\ScfException;

class Protocol
{
    private $VERSION = 1;
    private $totalLen;//int
    private $sessionId;//int
    private $serviceId;//byte
    private $sdpType;
    private $compressType;
    private $serializerType;
    private $platformType;
    private $userData;//byte[]
    private $sdpEntity;//object
    private $tiresiasData = "";//string
    private $key = "";//string

    /**
     * Э��ͷ14��byte
     */
    private static $HEAD_STACK_LENGTH = 14;

    public function __construct($sessionId = '', $serviceId = '', $sdpType = '', $compressType = '', $serializeType = '', $platformType = '', $sdpEntity = '')
    {
        $this->sessionId = $sessionId;
        $this->serviceId = $serviceId;
        $this->sdpType = $sdpType;
        $this->compressType = $compressType;
        $this->serializerType = $serializeType;
        $this->platformType = $platformType;
        $this->sdpEntity = $sdpEntity;
    }

    public function getHEAD_STACK_LENGTH()
    {
        return self::$HEAD_STACK_LENGTH;
    }

    public function getVERSION()
    {
        return $this->VERSION;
    }

    public function setVERSION($VERSION)
    {
        $this->VERSION = $VERSION;
        return $this;
    }

    public function getTotalLen()
    {
        return $this->totalLen;
    }

    public function setTotalLen($totalLen)
    {
        $this->totalLen = $totalLen;
        return $this;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }

    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getServiceId()
    {
        return $this->serviceId;
    }

    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
        return $this;
    }

    public function getSdpType()
    {
        return $this->sdpType;
    }

    public function setSdpType($sdpType)
    {
        $this->sdpType = $sdpType;
        return $this;
    }

    public function getCompressType()
    {
        return $this->compressType;
    }

    public function setCompressType($compressType)
    {
        $this->compressType = $compressType;
        return $this;
    }

    public function getSerializerType()
    {
        return $this->serializerType;
    }

    public function setSerializerType($serializerType)
    {
        $this->serializerType = $serializerType;
        return $this;
    }

    public function getPlatformType()
    {
        return $this->platformType;
    }

    public function setPlatformType($platformType)
    {
        $this->platformType = $platformType;
        return $this;
    }

    public function getUserData()
    {
        return $this->userData;
    }

    public function setUserData($userData)
    {
        $this->userData = $userData;
        return $this;
    }

    public function getSdpEntity()
    {
        return $this->sdpEntity;
    }

    public function setSdpEntity($sdpEntity)
    {
        $this->sdpEntity = $sdpEntity;
        return $this;
    }

    public function getTiresiasData()
    {
        return $this->tiresiasData;
    }

    public function setTiresiasData($tiresiasData)
    {
        $this->tiresiasData = $tiresiasData;
        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * transfer byte[] to protocol
     * @param byte[] data
     * @return Protocol
     * @throws Exception
     */
    public static function fromBytes($data, $initObj = '')
    {
        try {
            $version = unpack('c', substr($data, 0, 1));
            switch ($version[1]) {
                case '1':
                    return ProtocolHelper::getInstance()->pV1FromBytes($data, $initObj);
                case '2':
                    return ProtocolHelper::getInstance()->pV2FromBytes($data, $initObj);
                default:
                    throw new ScfException("protocol version unsupport, cannot fromBytes!, version is " . $version[1]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * transfer protocol to byte[]
     * @param $p protocol
     * @return byte[]
     * @throws Exception
     */
    public static function toBytes($p, $initObj = '')
    {
        try {
            switch ($p->getVERSION()) {
                case 1:
                    return ProtocolHelper::getInstance()->pV1ToBytes($p, $initObj);
                case 2:
                    return ProtocolHelper::getInstance()->pV2ToBytes($p, $initObj);
                default:
                    throw new ScfException("protocol version unsupport， cannot toBytes!, version is " . $p->getVERSION());
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}