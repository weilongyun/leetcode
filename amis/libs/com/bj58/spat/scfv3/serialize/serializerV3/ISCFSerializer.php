<?php
namespace  com\bj58\spat\scf\serialize\serializerV2;
interface ISCFSerializer
{
    /**
     * serizlizer
     * @param SCFOutStream $outStream
     */
    function Serializer($outStream)
    {
    }

    /**
     * derializer
     * @param SCFInStream $inStream
     */
    function Derializer($inStream)
    {}
}

?>