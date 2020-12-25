<?php 
namespace wcacheclient\util;

spl_autoload_register(
    function ($class) {
        if ('\\' == $class[0]) {
            $class = substr($class, 1);
        }
        $prefix = 'wcacheclient';
        $base_dir = __DIR__ ;
        $base_dir = dirname($base_dir);
        $len = strlen($prefix);
        if(strncmp($prefix, $class, $len) !== 0) {
            return;
        }
        $relative_class = substr($class, $len);
        $file = $base_dir.str_replace('\\',DIRECTORY_SEPARATOR, $relative_class).'.php';
        if(is_readable($file)){
            require_once $file;
        }
    }
);
