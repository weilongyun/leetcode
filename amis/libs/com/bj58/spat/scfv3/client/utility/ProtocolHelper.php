<?php
namespace com\bj58\spat\scf\client\utility;

use com\bj58\spat\scf\protocol\sfp\Protocol;
use com\bj58\spat\scf\protocol\sfp\enumeration\SDPType;
use com\bj58\spat\scf\protocol\sfp\enumeration\CompressType;
use com\bj58\spat\scf\protocol\sfp\enumeration\SerializeType;
use com\bj58\spat\scf\protocol\sfp\enumeration\PlatformType;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\protocol\sfp\enumeration\ProtocolType;
use com\bj58\spat\scf\client\utility\keyload\KeyLoad;

class ProtocolHelper
{
  public static function createProtocol($requestProtocol, $sessionId, $serviceName, $keyPath, $scfKeyPathMd5)
  {
      try {
          $config = $GLOBALS[$keyPath]['scf_config'][$serviceName];
          if (null !== $config) {
              $serialize = $config['serialize'];
              $serializerType = SerializeType::getSerializeTypeNum($serialize);
              $sendP = new Protocol($sessionId, $config['id'], SDPType::Request,
                  CompressType::UnCompress, $serializerType, PlatformType::PHP, $requestProtocol);
              $key = $scfKeyPathMd5 . '_keyContent';
              $sendP->setKey(KeyLoad::getKeyContent($keyPath, $key));
              $protocolType = $config['protocolType'];
              if (null == $protocolType) {
                  LogHelper::logWarnMsg("read prtocolType form config is " . $protocolType);
              } else {
                  $protocolType = ProtocolType::getProtocolType($protocolType);
                  $sendP->setVERSION($protocolType);
              }
              return $sendP;
          } else {
              throw new ScfException("read config error. config is null or empty. serviceName is " . $serviceName);
          }
      } catch (\Exception $e) {
          throw $e;
      }
    }
}