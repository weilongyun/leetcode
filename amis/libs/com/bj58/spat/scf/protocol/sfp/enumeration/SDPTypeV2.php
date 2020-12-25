<?php
namespace com\bj58\spat\scf\protocol\sfp\enumeration;

use com\bj58\spat\scf\protocol\sdp\ResponseProtocol;
use com\bj58\spat\scf\protocol\sdp\ExceptionProtocol;
use com\bj58\spat\scf\protocol\sdp\HandclaspProtocol;
use com\bj58\spat\scf\protocol\sdp\ResetProtocol;
use com\bj58\spat\scf\protocol\sdp\RequestProtocol;
use com\bj58\spat\scf\exception\ScfException;
use com\bj58\spat\scf\serialize\serializerV2\Serializer;

class SDPTypeV2
{
    const Response = 1;
    const Request = 2;
    const Exception = 3;
    const Config = 4;
    const Handclasp = 5;
    const Reset = 6;
    const StringKey = 7;

        public static function getSDPClass($SDPType)
        {
            switch ($SDPType) {
                case 1:
                    $type = new ResponseProtocol();
                    Serializer::GetTypeInfo($type);
                    return $type;
                case 2:
                    $type = new RequestProtocol();
                    Serializer::GetTypeInfo($type);
                    return $type;
                case 3:
                    $type = new ExceptionProtocol();
                    Serializer::GetTypeInfo($type);
                    return $type;
                case 4:
                    return "Config";
                case 5:
                    $type = new HandclaspProtocol();
                    Serializer::GetTypeInfo($type);
                    return $type;
                case 6:
                    $type = new ResetProtocol();
                    Serializer::GetTypeInfo($type);
                    return $type;
                case 7:
                    return "StringKey";
                default:
                    throw new ScfException("nuknown SDP: " . type);
            }
        }
    /**
     *
     * @param Object $obj
     * return byte
     */
    public function getSDPType($obj)
    {
        $type = get_class($obj);
        $num = strripos($type, '\\');
        $type = substr($type, $num +1);
        switch ($type) {
            case "ResponseProtocol":
                return SDPType::Response;
            case "RequestProtocol":
                return SDPType::Request;
            case "Config":
                return SDPType::Config;
            case "HandclaspProtocol":
                return SDPType::Handclasp;
            case "ResetProtocol":
                return SDPType::Reset;
            case "string":
                return SDPType::StringKey;
            default:
                 return SDPType::Exception;
        }
    }
}
