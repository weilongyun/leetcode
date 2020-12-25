<?php
/**
 * Author: rongxiaolong
 * Date  : 2016/5/17
 * Time  : 17:25
 * Brief : 使用PHP内置的mcrypt进行加密
 */

namespace Libs\Util;

class McryptHelper
{
    const DEFAULT_KEY = '9p57dvr6'; //MCRYPT_DES算法支持的密钥最大长度是8位

    /*
     * 加密
     * @param  string $originStr
     * @return string $encryptedStr
     */
    public static function Encrypt ($originStr, $key) {
        $td   = mcrypt_module_open(MCRYPT_DES, '', 'ecb', ''); //使用MCRYPT_DES算法,ecb模式
        $size = mcrypt_enc_get_iv_size($td);                   //设置初始向量的大小
        $iv   = mcrypt_create_iv($size, MCRYPT_RAND);          //创建初始向量
        if ( empty($key) ) {
            $key = self::DEFAULT_KEY;
        }
        mcrypt_generic_init($td, $key, $iv);       //初始处理
        $encode = mcrypt_generic($td, $originStr); //加密
        mcrypt_generic_deinit($td);                //结束处理
        mcrypt_module_close($td);
        $encryptedStr = utf8_encode(base64_encode($encode)); //base64encode和utf-8encode
        return $encryptedStr;
    }

    /*
     * 解密
     * @param  string $encryptedStr
     * @return string $originStr
     */
    public static function Decrypt ($encryptedStr, $key) {
        $td   = mcrypt_module_open(MCRYPT_DES, '', 'ecb', ''); //使用MCRYPT_DES算法,ecb模式
        $size = mcrypt_enc_get_iv_size($td);                   //设置初始向量的大小
        $iv   = mcrypt_create_iv($size, MCRYPT_RAND);          //创建初始向量
        if ( empty($key) ) {
            $key = self::DEFAULT_KEY;
        }
        mcrypt_generic_init($td, $key, $iv);                   //初始处理
        $encode = base64_decode(utf8_decode($encryptedStr));   //utf-8decode和base64decode
        $decrypted = mdecrypt_generic($td, $encode);           //解密
        $originStr = rtrim($decrypted, "\0");                  //解密后,可能会有后续的\0,需去掉
        mcrypt_generic_deinit($td);                            //结束
        mcrypt_module_close($td);
        return $originStr;
    }

}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */