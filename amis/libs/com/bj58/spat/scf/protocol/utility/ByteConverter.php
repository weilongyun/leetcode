<?php
namespace com\bj58\spat\scf\protocol\utility;

class ByteConverter
{

    /**
     * byte array to int (little endian)
     * @param byte[] buf
     */
    public static function bytesToIntLittleEndian($buf)
    {
        $int32 = unpack('V', $buf);
        $value = $int32[1];
        if ($value > 0x7fffffff) {
            $value = 0 - (($value - 1) ^ 0xffffffff);
        }
        return $value;
    }

    public static function bytesToIntBigEndian($buf)
    {
        $int32 = unpack('N', $buf);
        $value = $int32[1];
        if ($value > 0x7fffffff) {
            $value = 0 - (($value - 1) ^ 0xffffffff);
        }
        return $value;
    }
    /**
     *
     * @param byte[] $buf
     * @param int $offset
     */
    public static function bytesToShortLittleEndian($buf, $offset)
    {
        return ((($buf[$offset] << 8) & 0xff00) | ($buf[$offset + 1] & 0xff));
    }

    public static function bytesToShortBigEndian($buf, $offset)
    {
        return ($buf[$offset] & 0xff | (($buf[$offset + 1] << 8) & 0xff00));
    }

    /**
     * int to byte array (little endian)
     * @param int $n
     */
    public static function intToBytesLittleEndian($n)
    {
        $data = pack('V', $n);
        return $data;
    }

    public static function intToBytesBigEndian($n)
    {
        $data = pack('N', $n);
        return $data;
    }

    public static function shortToBytesLittleEndian($n)
    {
        $data = pack('v', $n);
        return $data;
    }

    /**
     * @param byte[] $buffer
     */
    public static function byteToShortLittleEndian($buffer)
    {
        $arr = unpack('v', $buffer);
        $value = $arr[1];
        if ($value > 0x7fff) {
            $value = 0 - (($value - 1) ^ 0xffff);
        }
        return $value;
    }

     /**
      *@param byte[] $buf
      *@param int $offset
      */
    public static function bytesToIntLittleEndianWithOffset($buf, $offset)
    {
        $buffer = substr($buf, $offset, 4);
        $int32 = unpack('V', $buffer);
        $value = $int32[1];
        if ($value > 0x7fffffff) {
            $value = 0 - (($value - 1) ^ 0xffffffff);
        }
        return $value;
    }

}