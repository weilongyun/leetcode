<?php
namespace com\bj58\spat\scf\protocol\serializer;

use com\bj58\spat\scf\protocol\sfp\enumeration\SerializeType;
class SerializeBaseFactory {
    private static $_instance = null;

    private function _construct() {
    }

    private function _clone(){
    }

    static public function getInstance() {
        if (is_null(self::$_instance) || isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getSerializeType($serializeType) {
        if ($serializeType === SerializeType::SCFBinary) {
            return new SCFSerialize();
        } else if ($serializeType === SerializeType::SCFBinaryV2) {
            return new SCFSerializeV2();
        } else if ($serializeType === SerializeType::SCFBinaryV3) {
            return new SCFSerializeV3();
        }
    }
}