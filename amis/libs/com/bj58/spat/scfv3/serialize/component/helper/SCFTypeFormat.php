<?php
namespace com\bj58\spat\scf\serialize\component\helper;

class SCFTypeFormat
{
    const  SCFTYPE_VARINT = 0;
	const  SCFTYPE_FIXED64 = 1;
	const  SCFTYPE_LENGTH_DELIMITED = 2;
	const  SCFTYPE_FIXED32 = 3;
	const  SCFTYPE_NULL = 4;
	const  SCFTYPE_FIXED16 = 5;
	const  SCFTYPE_FIXED8 = 6;

	static $TAG_TYPE_BITS = 3;
	static $TAG_TYPE_MASK = 7;//(1 << $TAG_TYPE_BITS) - 1;

	public static function getTagSCFType($tag) {
	    return $tag & self::$TAG_TYPE_MASK;
	}

	public static function getTagOrderId($tag) {
	    return $tag >> self::$TAG_TYPE_BITS;
	}

	public static function makeTag($fieldNumber, $wireType) {
	    return ($fieldNumber << self::$TAG_TYPE_BITS) | $wireType;
	}
}

?>