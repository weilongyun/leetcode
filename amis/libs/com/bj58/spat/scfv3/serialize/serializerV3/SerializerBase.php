<?php
namespace com\bj58\spat\scf\serialize\serializerV3;

abstract class SerializerBase
{

    /**
     *
     * @param Object $obj
     * @param SCFOutStream $outStream
     */
    public abstract function WriteObject($obj, $outStream, $etype = null, $generic = false);

    /**
     *
     * @param SCFInStream $inStream
     * @param Class $defType
     */
    public abstract function ReadObject($inStream, $defType, $etype = null, $generic = false);
}