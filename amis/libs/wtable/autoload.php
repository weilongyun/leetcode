<?php 
namespace WTable;

spl_autoload_register(
    function ($class) {
        if ('\\' == $class[0]) {
            $class = substr($class, 1);
        }
        $prefix = 'WTable';
        $base_dir = __DIR__;
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
