<?php
namespace com\bj58\spat\scf\client\utility;

class XMLHelper
{
    public static function getXMLDocFromStr($xmlStr)
    {
        try {
            $dom = new \DOMDocument('1.0', 'utf-8');
            $dom->loadXML($xmlStr);
            $dom->saveXML();
            return $dom;
        } catch (\Exception $e) {
            throw $e;
        }
        return null;
    }
}

?>