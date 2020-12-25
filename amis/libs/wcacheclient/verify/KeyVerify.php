<?php
namespace wcacheclient\verify;
use wcacheclient\exception\WcacheException;

class KeyVerify 
{
    private static $keyPrefix;
    const  MAX_KEY_LENGTH = 250;
    public static function verifyKey($key, $keyPrefix) 
    {
        if (strlen($key) === 0) {
            throw new WcacheException("Key must contain at least one character . ");
        }
        $keyFix = $keyPrefix . $key;
        if (strlen($keyFix) > self::MAX_KEY_LENGTH) {
            $maxKeylen = self::MAX_KEY_LENGTH;
            throw new WcacheException("Key is too long maxlen =  $maxKeylen . ");
        } 
        if (stripos($key,"\r") !== false) {
            throw new WcacheException("Key contains invalid characters:  $key . ");
        } else if (stripos($key,"\n") !== false) {
            throw new WcacheException( "Key contains invalid characters:  $key . ");
        }
    }
    
    public static function verifySetKeys($items, $keyPrefix) 
    {
        $keys = array_keys($items);
        self::verifyuKeys($keys, $keyPrefix);
    }
    
//     public static function verifyGetKeys($items, $keyPrefix)
//     {
//          self::verifyuKeys($items, $keyPrefix);       
//     }
    
    public static function verifyuKeys($items, $keyPrefix) 
    {
        if (empty($items) === true) {
            throw new WcacheException( "the key's num is empty . ");
        } elseif (count($items) > 100) {
            throw new WcacheException( "the key's num > 100 ");
        }
        foreach ($items as $key) {
            self::verifyKey($key, $keyPrefix);
        }
    }
    
}
//     $res =  stristr("Hello world!",111);
//     var_dump("res ========== $res");

// $res = stripos('You love php, \n I love php too!','\r');
// if ($res === false) {
//     echo "no \r";
// }
// echo "res === $res";
// $a=array("Volvo"=>"XC90","BMW"=>"X5","Toyota"=>"Highlander");
// print_r(array_keys($a));

// $a=array("Volvo"=>"XC90","BMW"=>"X5","Toyota"=>"Highlander");
// //  $a = array();
//  if (empty($a) === true) {
//      echo " empty . \n";
//  } else {
//      echo "no empty . \n";
//  }
 
