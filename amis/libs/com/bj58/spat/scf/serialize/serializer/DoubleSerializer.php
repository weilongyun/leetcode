<?php
namespace com\bj58\spat\scf\serialize\serializer;
use com\bj58\spat\scf\serialize\serializer\SerializerBase;
class DoubleSerializer extends SerializerBase
{
 /* *
  * @param SCFOutStream $outStream
  * @see \serialize\SerializerBase\SerializerBase::WriteObject()
  */
 public function WriteObject($obj, $outStream, $etype = null)
 {
     $buf = pack("d", $obj);
     $outStream->write($buf);
 }

 public function ReadObject($inStream, $defType, $etype = null)
 {
     $res = $inStream->read(8);
     $data = unpack("d", $res);
    return $data[1];
 }

}