<?php

namespace Libs\Util;

class FileType {

    const MAX_HEADER_LEN = 24;

    private $type_map = array();
    private $ref = null;

    public static function getFileTypeByName($filename) {
        if (empty($filename)) return self::Unknown;
        $content = file_get_contents($filename, false, null, 0, self::MAX_HEADER_LEN);
        return self::getInstence()->_getFileTypeByContent($content);
    }

    public static function getFileTypeByContent($content) {
        return self::getInstence()->_getFileTypeByContent($content);
    }

    public static function getFileTypeName($filetype) {
        return self::getInstence()->_getFileTypeName($filetype);
    }

    public static function isMp4($filetype) {
        $filename = self::getFileTypeName($filetype);
        if (strpos($filename, "MP4_") === 0) {
            return true;
        }
        return false;
    }

    private static function getInstence() {
        static $instence = null;
        if (is_null($instence)) {
            $instence = new self();
        }
        return $instence;
    }

    private function __construct() {
        $this->ref = new \ReflectionClass(self::class);
        $const = $this->ref->getConstants();
        $this->type_map = array_flip($const);
    }

    private function __clone() {}

    private function _getFileTypeName($filetype) {
        if (isset($this->type_map[$filetype])) {
            return $this->type_map[$filetype];
        }
        return self::Unknown;
    }

    private function _getFileTypeByContent($content) {
        if (empty($content)) {return self::Unknown;}

        $content = substr($content, 0, self::MAX_HEADER_LEN);
        $content_len = strlen($content);
        $hex_table = array();
        for($i = 0; $i < $content_len; $i++) {
            $hex = bin2hex($content[$i]);
            strlen($hex) < 2 && $hex = "0" . $hex;
            $hex_table[$i] = strtoupper($hex);
        }

        $hex_str = '';
        for($i = 0; $i < $content_len; $i++) {
            $hex_str .= $hex_table[$i];
            if (isset($this->type_map[$hex_str])) {
                return $hex_str;
            }
        }

        // check mp4
        $header = str_pad('', 8, '0') . implode('', array_slice($hex_table, 4, 8));
        if (isset($this->type_map[$header])) {
            return $header;
        }

        return self::Unknown;
    }

    // Unknown
    const Unknown = "UNKNOWN";
    // JEPG.
    const JPEG = "FFD8FF";
    // PNG.
    const PNG = "89504E47";
    // GIF.
    const GIF = "47494638";
    // TIFF.
    const TIFF = "49492A00";
    // Windows Bitmap.
    const BMP = "424D";
    // CAD.
    const DWG = "41433130";
    // Adobe Photoshop.
    const PSD = "38425053";
    // Rich Text Format.
    const RTF = "7B5C727466";
    // XML.
    const XML = "3C3F786D6C";
    // HTML.
    const HTML = "68746D6C3E";
    // CSS.
    const CSS = "48544D4C207B0D0A0942";
    // JS.
    const JS = "696B2E71623D696B2E71";
    // Email [thorough only].
    const EML = "44656C69766572792D646174653A";
    // Outlook Express.
    const DBX = "CFAD12FEC5FD746F";
    // Outlook  = pst).
    const PST = "2142444E";
    const XLS_DOC = "D0CF11E0";
    const XLSX_DOCX = "504B030414000600080000002100";
    // MS Access.
    const MDB = "5374616E64617264204A";
    // Visio FIXME
    const VSD = "d0cf11e0a1b11ae10000";
    // WPS文字wps、表格et、演示dps都是一样的
    const WPS = "d0cf11e0a1b11ae10000";
    // torrent
    const TORRENT = "6431303A637265617465";
    // WordPerfect.
    const WPD = "FF575043";
    // Postscript.
    const EPS = "252150532D41646F6265";
    // Adobe Acrobat.
    const PDF = "255044462D312E";
    // Quicken.
    const QDF = "AC9EBD8F";
    // Windows Password.
    const PWL = "E3828596";
    // ZIP Archive.
    const ZIP = "504B0304";
    // RAR Archive.
    const RAR = "52617221";
    // JSP Archive.
    const JSP = "3C2540207061676520";
    // JAVA Archive.
    const JAVA = "7061636B61676520";
    // CLASS Archive.
    const JAVA_CLASS = "CAFEBABE0000002E00";
    // JAR Archive.
    const JAR = "504B03040A000000";
    // MF Archive.
    const MF = "4D616E69666573742D56";
    //EXE Archive.
    const EXE = "4D5A9000030000000400";
    //CHM Archive.
    const CHM = "49545346030000006000";
    // Wave.
    const WAV = "57415645";
    // AVI.
    const AVI = "41564920";
    // Real Audio.
    const RAM = "2E7261FD";
    // Real Media.
    const RM = "2E524D46";
    // MPEG  = mpg).
    const MPG = "000001BA";
    // Quicktime.
    const MOV = "6D6F6F76";
    // Windows Media.
    const ASF = "3026B2758E66CF11";
    // MIDI.
    const MID = "4D546864";
    // MP3.
    const MP3 = "49443303000000002176";
    // FLV.
    const FLV = "464C5601050000000900";

    // MP4.
    /*
     * Ref:
     *      http://www.ftyps.com
     *      http://www.mp4ra.org/filetype.html
     *      http://www.file-recovery.com/signatures.htm
     */
    const MP4_F4A  = "000000006674797046344120";
    const MP4_F4B  = "000000006674797046344220";
    const MP4_F4P  = "000000006674797046345020";
    const MP4_F4V  = "000000006674797046345620";
    const MP4_M4A  = "00000000667479704D344120";
    const MP4_M4B  = "00000000667479704D344220";
    const MP4_M4P  = "00000000667479704D345020";
    const MP4_MSNV = "00000000667479704D534E56";
    const MP4_NDAS = "00000000667479704E444153";
    const MP4_NDSC = "00000000667479704E445343";
    const MP4_NDSH = "00000000667479704E445348";
    const MP4_NDSM = "00000000667479704E44534D";
    const MP4_NDSP = "00000000667479704E445350";
    const MP4_NDSS = "00000000667479704E445353";
    const MP4_NDXC = "00000000667479704E445843";
    const MP4_NDXH = "00000000667479704E445848";
    const MP4_NDXM = "00000000667479704E44584D";
    const MP4_NDXP = "00000000667479704E445850";
    const MP4_NDXS = "00000000667479704E445853";
    const MP4_avc1 = "000000006674797061766331";
    const MP4_iso2 = "000000006674797069736F32";
    const MP4_isom = "000000006674797069736F6D";
    const MP4_mmp4 = "00000000667479706D6D7034";
    const MP4_mp41 = "00000000667479706D703431";
    const MP4_mp42 = "00000000667479706D703432";
    const MP4_mp71 = "00000000667479706D703731";

}
