<?php
namespace WTable\util;

class Byte{
    const LEFT = 0xffffffff00000000;
    const RIGHT = 0x00000000ffffffff;
	//pack chars
	public static function packChars($string){
		$ret = "";
		if(0 === strlen($string)) {
			return "";
		}
		$tmp = array_map('ord', str_split($string));
		foreach($tmp as $v) {
			$ret .= pack('c', $v);
		}
		return $ret;
	}
	//pack uint8 or int8
	private static function pInt8($str,$signed){
		$format = $signed ? "c" : "C";
		return pack($format, $str);
	}
	public static function packInt8($str){
		return self::pInt8($str, true);
	}
	public static function packUint8($str){
		return self::pInt8($str, false);
	}
	//pack uint16 or int16
	private static function pInt16($str,$signed){
		$format = $signed ? "s" : "S";
		if(pack('L', 1) === pack('N', 1)) {
			return pack($format, $str);
		} else {
			return strrev(pack($format, $str));
		}
	}
	public static function packInt16($str){
		return self::pInt16($str, true);
	}
	public static function packUint16($str){
		return self::pInt16($str, false);
	}
	//pack uint32 or int 32
	private static function pInt32($str, $signed){
		$format = $signed ? "l" : "L";
		if(pack('L', 1) === pack('N', 1))
			return pack($format, $str);
		else
			return strrev(pack($format, $str));
	}
	public static function packInt32($str){
		return self::pInt32($str, true);
	}
	public static function packUint32($str){
		return self::pInt32($str, false);
	}
	//pack uint64 or int 64
	private static function pInt64($str, $signed) {
	    $format = $signed ? 'l2' : 'L2';
	    if (PHP_INT_SIZE == 4) {
	        $neg = $str < 0;
	        if ($neg) {
	            $str *= -1;
	        }
	        $hi = (int)($str / 4294967296);
	        $lo = (int)$str;
	        if ($neg) {
	            $hi = ~$hi;
	            $lo = ~$lo;
	            if (($lo & (int)0xffffffff) == (int)0xffffffff) {
	                $lo = 0;
	                $hi++;
	            } else {
	                $lo++;
	            }
	        }
	        if(pack('L', 1) === pack('N', 1)) {
	            return pack($format, $hi, $lo);
	        }else{
	            return strrev(pack($format, $lo, $hi));
	        }
	        	
	    } else {
	        $hi = ($str & self::LEFT) >> 32;
	        $lo = $str & self::RIGHT;
	        if(pack('L', 1) === pack('N', 1)){
	            return pack($format, $hi, $lo);
	        }
	        else{
	            return strrev(pack($format, $lo, $hi));
	        }
	    }
	}
	/*
	private static function pInt64($str, $signed){
		$format = $signed ? "q" : "Q";
		if(pack('L', 1) === pack('N', 1)){
			return pack($format,$str);
		}
		else{
			return strrev(pack($format,$str));
		}
	}
	*/
	public static function packInt64($str) {
		return self::pInt64($str, true);
	}
	public static function packUint64($str) {
		return self::pInt64($str, false);
	}
	//unpack chars
	public static function unpackChars($str,$start,$length)
	{
		$ret = "";
		if(0 == $length) {
			return "";
		}
		$tmp = unpack('c*',substr($str, $start, $length));
		foreach($tmp as $v){
			$ret.=sprintf('%c',$v);
		}
		return $ret;
	}
	
	//unpack uint8 or int8
	private static function upInt8($str, $start, $signed){
		$format = $signed ? "c" : "C";
		$tmp = unpack($format,substr($str, $start, 1));
		return $tmp[1];
	}
	public static function unpackInt8($str, $start) {
		return self::upInt8($str, $start, true);
	}
	public static function unpackUint8($str, $start) {
		return self::upInt8($str, $start, false);
	}
	//unpack uint16 or int16
	private static function upInt16($str, $start, $signed){
		$format = $signed ? "s" : "S";
		if(pack('L', 1) === pack('N', 1)){
			$tmp = unpack($format, substr($str, $start, 2));
		}else{
			$tmp = unpack($format, strrev(substr($str, $start, 2)));
		}
		return $tmp[1];
	}
	public static function unpackInt16($str, $start) {
		return self::upInt16($str, $start, true);
	}
	public static function unpackUint16($str, $start) {
		return self::upInt16($str, $start, false);
	}
	//unpack uint32 or int32
	private static function upInt32($str, $start, $signed){
		$format = $signed ? "l" : "L";
		if(pack('L', 1) === pack('N', 1)) {
			$tmp = unpack($format, substr($str, $start, 4));
		} else {
			$tmp = unpack($format, strrev(substr($str, $start, 4)));
		}
		return $tmp[1];
	}
	public static function unpackInt32($str, $start) {
		return self::upInt32($str, $start, true);
	}
	public static function unpackUint32($str, $start) {
		return self::upInt32($str, $start, false);
	}
	//unpack uint64 or int64
	private static function upInt64($str, $start, $signed){
	    $format = $signed ? 'l2' : 'L2';
	    // If we are on a 32bit architecture we have to explicitly deal with
	    // 64-bit twos-complement arithmetic since PHP wants to treat all ints
	    // as signed and any int over 2^31 - 1 as a float
	    if (PHP_INT_SIZE == 4) {
	        if(pack('L', 1) === pack('N', 1)) {
	            $arr = unpack($format, substr($str, $start, 8));
	        }else{
	            $arr = unpack($format, strrev(substr($str, $start, 8)));
	        }
	        $hi = $arr[1];
	        $lo = $arr[2];
	        $isNeg = $lo  < 0;
	        if ($isNeg) {
	            $hi = ~$hi & (int)0xffffffff;
	            $lo = ~$lo & (int)0xffffffff;
	            if ($hi == (int)0xffffffff) {
	                $lo++;
	                $hi = 0;
	            } else {
	                $hi++;
	            }
	        }
	        // Force 32bit words in excess of 2G to pe positive - we deal wigh sign
	        // explicitly below
	        	
	        if ($hi & (int)0x80000000) {
	            $hi &= (int)0x7fffffff;
	            $hi += 0x80000000;
	        }
	        if ($lo & (int)0x80000000) {
	            $lo &= (int)0x7fffffff;
	            $lo += 0x80000000;
	        }
	        	
	        $value = $lo * 4294967296 + $hi;
	        	
	        if ($isNeg) {
	            $value = 0 - $value;
	        }
	        return $value;
	    } else {
	        if(pack('L', 1) === pack('N', 1)) {
	            $tmp = unpack($format, substr($str, $start, 8));
	            return ($tmp[1] << 32) | ($tmp[2] & self::RIGHT);
	        } else {
	            $tmp = unpack($format, strrev(substr($str, $start, 8)));
	            return ($tmp[2] << 32) | ($tmp[1] & self::RIGHT);
	        }
	    }
	}
	public static function unpackInt64($str, $start){
		return self::upInt64($str, $start, true);
	}
	public static function unpackUint64($str, $start){
		return self::upInt64($str, $start, false);
	}
	public static function appendBytes($des, $src) {
		return $des.$src;
	}
}
