<?php
namespace com\bj58\spat\scf\protocol\serializer;

abstract class SerializeBase {

    private $encoder;

    public function getEncoder() {
        return $this->encoder;
    }

    public function setEncoder($encoder) {
        $this->encoder = $encoder;
    }

    public static function getInstance($serializeType) {
        return SerializeBaseFactory::getInstance()->getSerializeType($serializeType);
    }

    /**
     *
     * @param Object $obj
     */
    public abstract function serialize($obj);

    /**
     *
     * @param byte[] $data
     * @param unknown $cls
     */
    public abstract function deserialize($data, $cls);

}