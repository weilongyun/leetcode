<?php

class Autoloader {
    
    private static $PlatLibs = array(
        'com' => TRUE,       
        'WTable' => TRUE,
        'wcacheclient' => TRUE,
    );

    /**
     * Singleton.
     */
    public static function register($root_path_setting) {
        static $singleton = NULL;
        is_null($singleton) && $singleton = new self($root_path_setting);
        return $singleton;
    }

    /**
     *
     * @var string
     */
    private $root_path_setting = array();

    private function __construct($root_path_setting) {
        $this->root_path_setting = $root_path_setting;
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * Get file path of source file.
     */
    private function getFilepath($class_name) {
        // class name contains namespaces
        $pieces = explode('\\', $class_name);

        $root_path = $this->root_path_setting['default'];
        $space = $pieces[0];
        if (isset($this->root_path_setting[$pieces[0]])) {
            $root_path = $this->root_path_setting[$pieces[0]];
        } elseif ($space == 'Thrift') {
            $root_path = LIB_PATH . DIRECTORY_SEPARATOR . "thrift";
        }
        // get rid of the leading root namespace
        array_shift($pieces);

        $class_name = array_pop($pieces);
        $isPlatLib = isset(self::$PlatLibs[$space]);
        $base_path = function () use ($root_path, $pieces, $isPlatLib) {
            if ($isPlatLib) {
                return empty($pieces) ? $root_path : $root_path . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $pieces);                
            } else {   
                return empty($pieces) ? $root_path : $root_path . DIRECTORY_SEPARATOR . strtolower(implode(DIRECTORY_SEPARATOR, $pieces));
            }
        };
        if ($isPlatLib) { //针对平台提供的类做了hack
            return $base_path() . "/{$class_name}.php";
        }
        return $base_path() . "/{$class_name}.class.php";
    }

    /**
     * The method that actually triggers require().
     * require() is better then require_once()
     */
    private function autoload($class_name) {
        $filepath = $this->getFilepath($class_name);
        file_exists($filepath) && $this->onceRequire($filepath);
    }

    private function onceRequire($filepath) {
        static $files = array();
        isset($files[$filepath]) or require $filepath;
        $files[$filepath] = 1;
    }
}
