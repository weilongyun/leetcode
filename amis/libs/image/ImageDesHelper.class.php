<?php

namespace Libs\Image;

class ImageDesHelper {

    // 初始置换表IP
    private static $IP_Table = array(
            57, 49, 41, 33, 25, 17,  9,  1, 59, 51, 43, 35, 27, 19, 11,  3,
            61, 53, 45, 37, 29, 21, 13,  5, 63, 55, 47, 39, 31, 23, 15,  7,
            56, 48, 40, 32, 24, 16,  8,  0, 58, 50, 42, 34, 26, 18, 10,  2,
            60, 52, 44, 36, 28, 20, 12,  4, 62, 54, 46, 38, 30, 22, 14,  6
    );

    // 逆初始置换表IP^-1
    private static $IP_1_Table = array(
            39,  7, 47, 15, 55, 23, 63, 31, 38,  6, 46, 14, 54, 22, 62, 30,
            37,  5, 45, 13, 53, 21, 61, 29, 36,  4, 44, 12, 52, 20, 60, 28,
            35,  3, 43, 11, 51, 19, 59, 27, 34,  2, 42, 10, 50, 18, 58, 26,
            33,  1, 41,  9, 49, 17, 57, 25, 32,  0, 40,  8, 48, 16, 56, 24
    );


    // 扩充置换表E
    private static $E_Table = array(
            31,  0,  1,  2,  3,  4,  3,  4,  5,  6,  7,  8,  7,  8,  9, 10,
            11, 12, 11, 12, 13, 14, 15, 16, 15, 16, 17, 18, 19, 20, 19, 20,
            21, 22, 23, 24, 23, 24, 25, 26, 27, 28, 27, 28, 29, 30, 31,  0
    );

    // 置换函数P
    private static $P_Table = array(
            15,  6, 19, 20, 28, 11, 27, 16,  0, 14, 22, 25,  4, 17, 30,  9,
             1,  7, 23, 13, 31, 26,  2,  8, 18, 12, 29,  5, 21, 10,  3, 24
    );

    // S盒
    private static $S = array(
        array( // S1
            array(14,  4, 13,  1,  2, 15, 11,  8,  3, 10,  6, 12,  5,  9,  0,  7),
            array( 0, 15,  7,  4, 14,  2, 13,  1, 10,  6, 12, 11,  9,  5,  3,  8),
            array( 4,  1, 14,  8, 13,  6,  2, 11, 15, 12,  9,  7,  3, 10,  5,  0),
            array(15, 12,  8,  2,  4,  9,  1,  7,  5, 11,  3, 14, 10,  0,  6, 13),
        ),
        array( // S2
            array(15,  1,  8, 14,  6, 11,  3,  4,  9,  7,  2, 13, 12,  0,  5, 10),
            array( 3, 13,  4,  7, 15,  2,  8, 14, 12,  0,  1, 10,  6,  9, 11,  5),
            array( 0, 14,  7, 11, 10,  4, 13,  1,  5,  8, 12,  6,  9,  3,  2, 15),
            array(13,  8, 10,  1,  3, 15,  4,  2, 11,  6,  7, 12,  0,  5, 14,  9),
        ),
        array( // S3
            array(10,  0,  9, 14,  6,  3, 15,  5,  1, 13, 12,  7, 11,  4,  2,  8),
            array(13,  7,  0,  9,  3,  4,  6, 10,  2,  8,  5, 14, 12, 11, 15,  1),
            array(13,  6,  4,  9,  8, 15,  3,  0, 11,  1,  2, 12,  5, 10, 14,  7),
            array( 1, 10, 13,  0,  6,  9,  8,  7,  4, 15, 14,  3, 11,  5,  2, 12),
        ),
        array( // S4
            array( 7, 13, 14,  3,  0,  6,  9, 10,  1,  2,  8,  5, 11, 12,  4, 15),
            array(13,  8, 11,  5,  6, 15,  0,  3,  4,  7,  2, 12,  1, 10, 14,  9),
            array(10,  6,  9,  0, 12, 11,  7, 13, 15,  1,  3, 14,  5,  2,  8,  4),
            array( 3, 15,  0,  6, 10,  1, 13,  8,  9,  4,  5, 11, 12,  7,  2, 14),
        ),
        array( // S5
            array( 2, 12,  4,  1,  7, 10, 11,  6,  8,  5,  3, 15, 13,  0, 14,  9),
            array(14, 11,  2, 12,  4,  7, 13,  1,  5,  0, 15, 10,  3,  9,  8,  6),
            array( 4,  2,  1, 11, 10, 13,  7,  8, 15,  9, 12,  5,  6,  3,  0, 14),
            array(11,  8, 12,  7,  1, 14,  2, 13,  6, 15,  0,  9, 10,  4,  5,  3),
        ),
        array( // S6
            array(12,  1, 10, 15,  9,  2,  6,  8,  0, 13,  3,  4, 14,  7,  5, 11),
            array(10, 15,  4,  2,  7, 12,  9,  5,  6,  1, 13, 14,  0, 11,  3,  8),
            array( 9, 14, 15,  5,  2,  8, 12,  3,  7,  0,  4, 10,  1, 13, 11,  6),
            array( 4,  3,  2, 12,  9,  5, 15, 10, 11, 14,  1,  7,  6,  0,  8, 13),
        ),
        array( // S7
            array( 4, 11,  2, 14, 15,  0,  8, 13,  3, 12,  9,  7,  5, 10,  6,  1),
            array(13,  0, 11,  7,  4,  9,  1, 10, 14,  3,  5, 12,  2, 15,  8,  6),
            array( 1,  4, 11, 13, 12,  3,  7, 14, 10, 15,  6,  8,  0,  5,  9,  2),
            array( 6, 11, 13,  8,  1,  4, 10,  7,  9,  5,  0, 15, 14,  2,  3, 12),
        ),
        array( // S8
            array(13,  2,  8,  4,  6, 15, 11,  1, 10,  9,  3, 14,  5,  0, 12,  7),
            array( 1, 15, 13,  8, 10,  3,  7,  4, 12,  5,  6, 11,  0, 14,  9,  2),
            array( 7, 11,  4,  1,  9, 12, 14,  2,  0,  6, 10, 13, 15,  3,  5,  8),
            array( 2,  1, 14,  7,  4, 10,  8, 13, 15, 12,  9,  0,  3,  5,  6, 11),
        ),
    );

    // 置换选择1
    private static $PC_1 = array(
            56, 48, 40, 32, 24, 16,  8,  0,
            57, 49, 41, 33, 25, 17,  9,  1,
            58, 50, 42, 34, 26, 18, 10,  2,
            59, 51, 43, 35, 62, 54, 46, 38,
            30, 22, 14,  6, 61, 53, 45, 37,
            29, 21, 13,  5, 60, 52, 44, 36,
            28, 20, 12,  4, 27, 19, 11,  3,
    );

    // 置换选择2
    private static $PC_2 = array(
            13, 16, 10, 23,  0,  4,  2, 27,
            14,  5, 20,  9, 22, 18, 11,  3,
            25,  7, 15,  6, 26, 19, 12,  1,
            40, 51, 30, 36, 46, 54, 29, 39,
            50, 44, 32, 46, 43, 48, 38, 55,
            33, 52, 45, 41, 49, 35, 28, 31,
    );

    // 对左移次数的规定
    private static $MOVE_TIMES  = array(
            1, 1, 2, 2, 2, 2, 2, 2, 1, 2, 2, 2, 2, 2, 2, 1
    );

    // 密钥置换1
    private static function DES_PC1_Transform(array $key, array &$tempbts) {
        for ($cnt = 0; $cnt < 56; $cnt++) {
            $tempbts[$cnt] = $key[self::$PC_1[$cnt]];
        }
    }

    // 密钥置换2
    private static function DES_PC2_Transform(array $key, array &$tempbts) {
        for ($cnt = 0; $cnt < 48; $cnt++) {
            $tempbts[$cnt] = $key[self::$PC_2[$cnt]];
        }
    }

    // 循环左移
    private static function DES_ROL(array &$data, $time) {

        $temp = array_fill(0, 56, 0);

        // 保存将要循环移动到右边的位
        self::arraycopy($data, 0, $temp, 0, $time);
        self::arraycopy($data, 28, $temp, $time, $time);

        // 前28位移动
        self::arraycopy($data, $time, $data, 0, 28-$time, 1);
        self::arraycopy($temp, 0, $data, 28-$time, $time);

        // 后28位移动
        self::arraycopy($data, 28+$time, $data, 28, 28-$time);
        self::arraycopy($temp, $time, $data, 56-$time, $time);
    }

    // IP置换
    private static function DES_IP_Transform(array &$data) {
        $temp = array_fill(0, 64, 0);
        for ($cnt = 0; $cnt < 64; $cnt++) {
            $temp[$cnt] = $data[self::$IP_Table[$cnt]];
        }
        self::arraycopy($temp, 0, $data, 0, 64);
    }

    // IP逆置换
    private static function DES_IP_1_Transform(array &$data) {
        $temp = array_fill(0, 64, 0);
        for ($cnt = 0; $cnt < 64; $cnt++) {
            $temp[$cnt] = $data[self::$IP_1_Table[$cnt]];
        }
        self::arraycopy($temp, 0, $data, 0, 64);
    }

    // 扩展置换
    private static function DES_E_Transform(array &$data) {
        $temp = array_fill(0, 48, 0);
        for ($cnt = 0; $cnt < 48; $cnt++) {
            $temp[$cnt] = $data[self::$E_Table[$cnt]];
        }
        self::arraycopy($temp, 0, $data, 0, 48);
    }

    // P置换
    private static function DES_P_Transform(array &$data) {
        $temp = array_fill(0, 32, 0);
        for ($cnt = 0; $cnt < 32; $cnt++) {
            $temp[$cnt] = $data[self::$P_Table[$cnt]];
        }
        self::arraycopy($temp, 0, $data, 0, 32);
    }

    // 异或
    private static function DES_XOR(array &$R, array &$L, $count) {
        for ($cnt = 0; $cnt < $count; $cnt++) {
            $R[$cnt] ^= $L[$cnt];
        }
    }

    // S盒置换
    private static function DES_SBOX(array &$data) {
        for ($cnt = 0; $cnt < 8; $cnt++) {
            $cur1 = $cnt * 6;
            $cur2 = $cnt << 2;

            // 计算在S盒中的行与列
            $line = ($data[$cur1] << 1) + $data[$cur1 + 5];
            $row = ($data[$cur1 + 1] << 3) + ($data[$cur1 + 2] << 2)
                + ($data[$cur1 + 3] << 1) + $data[$cur1 + 4];
            $output = self::$S[$cnt][$line][$row];

            // 化为2进制
            $data[$cur2]     = (($output & 0X08) >> 3);
            $data[$cur2 + 1] = (($output & 0X04) >> 2);
            $data[$cur2 + 2] = (($output & 0X02) >> 1);
            $data[$cur2 + 3] = ($output & 0x01);
        }
    }

    // 交换
    private static function DES_Swap(array &$left) {
        $temp = array_fill(0, 32, 0);
        self::arraycopy($left, 0, $temp, 0, 32);
        self::arraycopy($left, 32, $left, 0, 32);
        self::arraycopy($temp, 0, $left, 32, 32);
    }

    // 生成子密钥
    public static function DES_MakeSubKeys(array $key, array &$subKeys) {
        $temp = array_fill(0, 56, 0);
        self::DES_PC1_Transform($key, $temp);
        for ($cnt = 0; $cnt < 16; $cnt++) {// 16轮跌代，产生16个子密钥
            self::DES_ROL($temp, self::$MOVE_TIMES[$cnt]);// 循环左移
            self::DES_PC2_Transform($temp, $subKeys[$cnt] );
        }
    }

    // 加密单个分组
    public static function DES_EncryptBlock(array $plainBlock, array $subKeys) {
        $plainBits = array_fill(0, 64, 0);
        $copyRight = array_fill(0, 48, 0);

        self::Char8ToBit64($plainBlock, $plainBits);

        // 初始置换（IP置换）
        self::DES_IP_Transform($plainBits);

        // 16轮迭代
        for ($cnt = 0; $cnt < 16; $cnt++) {
            self::arraycopy($plainBits, 32, $copyRight, 0, 32);
            // 将右半部分进行扩展置换，从32位扩展到48位
            self::DES_E_Transform($copyRight);
            // 将右半部分与子密钥进行异或操作
            self::DES_XOR($copyRight, $subKeys[$cnt], 48);
            // 异或结果进入S盒，输出32位结果
            self::DES_SBOX($copyRight);
            // P置换
            self::DES_P_Transform($copyRight);
            // 将明文左半部分与右半部分进行异或
            self::DES_XOR($plainBits, $copyRight, 32);
            if ($cnt != 15) {
                // 最终完成左右部的交换
                self::DES_Swap($plainBits);
            }
        }
        // 逆初始置换（IP^1置换）
        self::DES_IP_1_Transform($plainBits);
        return self::Bit64ToChar8($plainBits);
    }


    public static function arraycopy(&$src, $srcPos, &$desc, $destPos, $length) {
        if ($src === $desc) {
            $source = $src;
        } else {
            $source = &$src;
        }

        for ($i=0; $i<$length; $i++) {
            $desc[$destPos+$i] = $source[$srcPos+$i];
        }
    }

    // 将长度为8的字符串转为二进制位串
    public static function Char8ToBit64(array $byte, array &$bit) {
        for($cnt = 0; $cnt < 8; $cnt++) {
            for ($i = 0; $i < 8; $i++) {
                $bit[$cnt * 8 + $i] = (($byte[$cnt]) >> $i) & 1;
            }
        }
    }

    // 将二进制位串转为长度为8的字符串
    public static function Bit64ToChar8(array $bit) {
        $char = array_fill(0, 8, 0);
        for ($cnt = 0; $cnt < 8; $cnt++) {
            for ($i = 0; $i < 8; $i++) {
                $char[$cnt] |= $bit[$cnt * 8 +$i] << $i;
            }
        }
        return $char;
    }

    // 将字节转为十六进制字符串
    public static function ByteToHexStr(array $byte) {
        $str = '';
        $byte_len = count($byte);
        for ($cnt = 0; $cnt < $byte_len; $cnt++) {
            $hex = dechex($byte[$cnt] & 0xff);
            strlen($hex) < 2 && $hex = "0" . $hex;
            $str .= $hex;
        }
        return $str;
    }

    public static function urlEncode($filename, array $customInfo) {
        if (empty($filename) || empty($customInfo)) {return '';}

        $bKey = array_fill(0, 64, 0);
        $subKeys = array_fill(0, 16, array_fill(0, 48, 0));
        $plainBlock = array_fill(0, 8, 0);

        $urlID = strpos($filename, 'n_s') === 0 ? substr($filename, 4) : substr($filename, 2);
        $urlID_byte = array_map('ord', str_split($urlID));
        self::Char8ToBit64($urlID_byte, $bKey);
        self::DES_MakeSubKeys($bKey, $subKeys);

        $hexStr= '';
        $times = 0;
        while (true) {
            self::arraycopy($customInfo, $times, $plainBlock, 0, 8);
            $hexStr .= self::ByteToHexStr(self::DES_EncryptBlock($plainBlock, $subKeys));
            $times += 8;
            if ($times * 2 >= count($customInfo)) {
                break;
            }
        }

        return $filename . "_" . $hexStr;
    }

}
