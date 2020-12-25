<?php
namespace com\bj58\spat\scf\protocol\utility;

use com\bj58\spat\scf\protocol\utility\ProtocolConst;
use com\bj58\spat\scf\protocol\sfp\Protocol;
use com\bj58\spat\scf\protocol\sfp\SFPStruct;
use com\bj58\spat\scf\protocol\utility\ByteConverter;
use com\bj58\spat\scf\protocol\sfp\enumeration\CompressType;
use com\bj58\spat\scf\protocol\sfp\enumeration\SerializeType;
use com\bj58\spat\scf\protocol\sfp\enumeration\PlatformType;
use com\bj58\spat\scf\protocol\compress\CompressBase;
use com\bj58\spat\scf\protocol\sfp\enumeration\SDPType;
use com\bj58\spat\scf\protocol\serializer\SerializeBase;
use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\protocol\sfp\enumeration\SDPTypeFactory;
class ProtocolHelper
{
    private static $_instance = null;

    private function _construct()
    {
    }

    private function _clone()
    {
    }

    static public function getInstance()
    {
        if (is_null(self::$_instance) || isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param byte[] $buffer
     * @return
     */
    public static function getVersion($buffer)
    {
        if (null != $buffer) {
            return $buffer[0];
        } else {
            throw new ScfException('serializer or deserializer stream is null or empty!');
        }
    }

    /**
     *
     * @param byte[] buf
     * @return boolean
     */
    public static function checkHeadDelimiter($buf)
    {
        if(count($buf) == count(ProtocolConst::$P_START_TAG)){
            for($i=0; $i < count($buf); $i++) {
                if($buf[i] != ProtocolConst::$P_START_TAG[$i]) {
                    return false;
                }
            }
            return true;
        } else{
            return false;
        }
    }

    /**
     * transfer bytes to protocol v1
     * @param boolean rights
     * @return Protocol
     * @throws Exception
     */
    public function pV1FromBytes ($data, $initObj = '')
    {
        try {
            $p = new Protocol();

            $version = unpack('c', substr($data, 0, 1));
            $p->setVERSION($version[1]);
            $startIndex = SFPStruct::$Version;
            $totalLengthByte = '';
            $totalLengthByte = substr($data, $startIndex, SFPStruct::$TotalLen);
            $p->setTotalLen(ByteConverter::bytesToIntLittleEndian($totalLengthByte));

            $startIndex += SFPStruct::$TotalLen;
            $sessionIDByte = '';
            $sessionIDByte = substr($data, $startIndex, SFPStruct::$SessionId);
            $p->setSessionID(ByteConverter::bytesToIntLittleEndian($sessionIDByte));
            $startIndex += SFPStruct::$SessionId;//9

            $serviceId = unpack('c', substr($data, $startIndex, SFPStruct::$ServerId));
            $p->setServiceID($serviceId[1]);

            $startIndex += SFPStruct::$ServerId;//10
            $SDPType = unpack('c', substr($data, $startIndex, SFPStruct::$SDPType));
            $p->setSDPType($SDPType[1]);

            $startIndex += SFPStruct::$SDPType;
            $compressType = unpack('c', substr($data, $startIndex, SFPStruct::$CompressType));
            $ct = CompressType::getCompressType($compressType[1]);
            $p->setCompressType($ct);

            $startIndex += SFPStruct::$CompressType;
            $serializeType = unpack('c', substr($data, $startIndex, SFPStruct::$SerializeType));
            $st = SerializeType::getSerializeType($serializeType[1]);
            $p->setSerializerType($st);

            $startIndex += SFPStruct::$SerializeType;
            $platformType = unpack('c', substr($data, $startIndex, SFPStruct::$Platform));
            $p->setPlatformType(PlatformType::getPlatformType($platformType[1]));

            $startIndex += SFPStruct::$Platform;

            $sdpData = '';
            $sdpData = substr($data, $startIndex, strlen($data) - $startIndex);
            $sdpData = CompressBase::getInstance($ct)->unzip($sdpData);

            $p->setUserData($sdpData);
            $p->setSdpEntity(SerializeBase::getInstance($st)->deserialize($sdpData, SDPTypeFactory::getSDPClass($p, $initObj), $initObj));
            return $p;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * byte[] $data
     * boolean $rights;
     * byte[] desKey
     */
    public function pV2FromBytes($data, $initObj = '')
    {
        try {
            $p = new Protocol();

            $version = unpack('c', substr($data, 0, 1));
            $p->setVERSION($version[1]);
            $startIndex = SFPStruct::$Version;
            $totalLengthByte = '';
            $totalLengthByte = substr($data, $startIndex, SFPStruct::$TotalLen);

            $p->setTotalLen(ByteConverter::bytesToIntLittleEndian($totalLengthByte));

            $startIndex += SFPStruct::$TotalLen;
            $sessionIDByte = '';
            $sessionIDByte = substr($data, $startIndex, SFPStruct::$SessionId);
            $p->setSessionID(ByteConverter::bytesToIntLittleEndian($sessionIDByte));
            $startIndex += SFPStruct::$SessionId;//9

            $serviceId = unpack('c', substr($data, $startIndex, SFPStruct::$ServerId));
            $p->setServiceID($serviceId[1]);

            $startIndex += SFPStruct::$ServerId;//10
            $SDPType = unpack('c', substr($data, $startIndex, SFPStruct::$SDPType));
            $p->setSDPType($SDPType[1]);

            $startIndex += SFPStruct::$SDPType;
            $compressType = unpack('c', substr($data, $startIndex, SFPStruct::$CompressType));
            $ct = CompressType::getCompressType($compressType[1]);
            $p->setCompressType($ct);

            $startIndex += SFPStruct::$CompressType;
            $serializeType = unpack('c', substr($data, $startIndex, SFPStruct::$SerializeType));
            $st = SerializeType::getSerializeType($serializeType[1]);
            $p->setSerializerType($st);

            $startIndex += SFPStruct::$SerializeType;
            $platformType = unpack('c', substr($data, $startIndex, SFPStruct::$Platform));
            $p->setPlatformType(PlatformType::getPlatformType($platformType[1]));

            $startIndex += SFPStruct::$Platform;
            $tireisasLenByte ='';
            $tireisasLenByte = substr($data, $startIndex, SFPStruct::$TiresiasLen);
            $tireisasLen = ByteConverter::byteToShortLittleEndian($tireisasLenByte[1]);

            $startIndex += SFPStruct::$TiresiasLen;
            $tiresiasData = '';
            $tiresiasData = substr($data, $startIndex, $tireisasLen);
            $tiresiasData = CompressBase::getInstance($ct)->unzip($tiresiasData);

            $startIndex += $tireisasLen;
            $keyLenByte = '';
            $keyLenByte = substr($data, $startIndex, SFPStruct::$KeyLen);
            $keyLen = ByteConverter::byteToShortLittleEndian($keyLenByte[1]);

            $startIndex += SFPStruct::$KeyLen;
            $keyData = '';
            $keyData = substr($data, $startIndex, $keyLen);
            $keyData = CompressBase::getInstance($ct)->unzip($keyData);

            $startIndex += $keyLen;
            $sdpData = '';
            $sdpData = substr($data, $startIndex, strlen($data) - $startIndex);
            $sdpData = CompressBase::getInstance(ct)->unzip($sdpData);

            $p->setUserData($sdpData);
            $serialize = SerializeBase::getInstance($st);
            $p->setTiresiasData($serialize->deserialize($tiresiasData, SCFType::STRING, $initObj));
            $p->setKey($serialize->deserialize($keyData, SCFType::STRING, $initObj));
            $p->setSdpEntity($serialize->deserialize($sdpData, SDPTypeFactory::getSDPClass($p, $initObj), $initObj));
            return $p;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    /**
     * transfer protocol v1 to bytes
     * @param Protocol $p
     * @return byte[]
     * @throws Exception
     */
    public function pV1ToBytes($p, $initObj = '')
    {
        try {
            $serialize = SerializeBase::getInstance($p->getSerializerType());
            $compress = CompressBase::getInstance($p->getCompressType());

            $p->setSDPType($p->getSdpType());
            $sdpData = $serialize->serialize($p->getSdpEntity(), $initObj);

            $sdpData = $sdpData -> getBuf();
            $sdpData = $compress->zip($sdpData);

            $protocolLen = $p->getHEAD_STACK_LENGTH() + strlen($sdpData);
            $p->setTotalLen($protocolLen);

            $data = '';
            $data .= pack('c', $p->getVERSION());

            $data .= ByteConverter::intToBytesLittleEndian($p->getTotalLen());

            $data .= ByteConverter::intToBytesLittleEndian($p->getSessionID());

            $data .= pack('c', $p->getServiceID());

            $data .= pack('c', $p->getSDPType());

            $data .= pack('c', $p->getCompressType());

            $data .= pack('c', $p->getSerializerType());

            $data .= pack('c', $p->getPlatformType());

            $data .= $sdpData;

            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function pV2ToBytes($p, $initObj = '')
    {
        try {
            $serialize = SerializeBase::getInstance($p->getSerializerType());
            $compress = CompressBase::getInstance($p->getCompressType());

            $p->setSDPType($p->getSdpType());
            $sdpData = $serialize->serialize($p->getSdpEntity(), $initObj);
            $tiresiasData = $serialize->serialize($p->getTiresiasData(), $initObj);
            $keyData = $serialize->serialize($p->getKey(), $initObj);
            $sdpData = $sdpData -> getBuf();
            $sdpData = $compress->zip($sdpData);
            $tiresiasData = $tiresiasData->getBuf();
            $tiresiasData = $compress->zip($tiresiasData);
            $keyData = $keyData-> getBuf();
            $keyData = $compress->zip($keyData);

            $protocolLen = $p->getHEAD_STACK_LENGTH() + SFPStruct::$TiresiasLen + strlen($tiresiasData) + SFPStruct::$KeyLen + strlen($keyData) + strlen($sdpData);
            $p->setTotalLen($protocolLen);

            $data = '';
            $data .= pack('c', $p->getVERSION());

            $data .= ByteConverter::intToBytesLittleEndian($p->getTotalLen());

            $data .= ByteConverter::intToBytesLittleEndian($p->getSessionID());

            $data .= pack('c', $p->getServiceID());

            $data .= pack('c', $p->getSDPType());

            $data .= pack('c', $p->getCompressType());

            $data .= pack('c', $p->getSerializerType());

            $data .= pack('c', $p->getPlatformType());

            $data .= ByteConverter::shortToBytesLittleEndian(strlen($tiresiasData));

            $data .= $tiresiasData;

            $data .= ByteConverter::shortToBytesLittleEndian(strlen($keyData));

            $data .= $keyData;

            $data .= $sdpData;

            return $data;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}