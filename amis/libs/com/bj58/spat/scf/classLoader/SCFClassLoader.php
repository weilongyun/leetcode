<?php

namespace com\bj58\spat\scf\classloader;

class SCFClassLoader
{
    /**
     * Namespaces path
     * @var array
     */
    protected $namespaces = array();

    public function __construct()
    {
    }

    /**
     * Registers a namespace.
     *
     * @param string       $namespace The namespace
     * @param array|string $paths     The location(s) of the namespace
     */
    public function registerNamespace($namespace, $paths)
    {
        $this->namespaces[$namespace] = (array) $paths;
    }

    /**
     * Registers this instance as an autoloader.
     *
     * @param Boolean $prepend Whether to prepend the autoloader or not
     */
    public function register($prepend = false)
    {
        spl_autoload_register(array($this, 'loadClass'), true, $prepend);
    }

    /**
     * Loads the given class, definition or interface.
     *
     * @param string $class The name of the class
     */
    public function loadClass($class)
    {
        if (($file = $this->findFile($class)) != false)
        {
            require_once $file;
        }
    }
    /**
     * Find class in namespaces or definitions directories
     * @param string $class
     * @return string
     */
    public function findFile($class)
    {
        // Remove first backslash
        if ('\\' == $class[0])
        {
            $class = substr($class, 1);
        }

        if (false !== $pos = strrpos($class, '\\'))
        {
            // Namespaced class name
            $namespace = substr($class, 0, $pos);

            // Iterate in normal namespaces
            foreach ($this->namespaces as $ns => $dirs)
            {
                //Don't interfere with other autoloaders
                if (0 !== strpos($namespace, $ns))
                {
                    continue;
                }

                foreach ($dirs as $dir)
                {
                    $className = substr($class, $pos + 1);

                    $file = $dir.DIRECTORY_SEPARATOR.
                    str_replace('\\', DIRECTORY_SEPARATOR, $namespace).
                    DIRECTORY_SEPARATOR.
                    $className.'.php';

                    if (file_exists($file))
                    {
                        return $file;
                    }
                }
            }

            // Remove first part of namespace
            $m = explode('\\', $class);

            // Ignore wrong call
            if(count($m) <= 1)
            {
                return;
            }
        }
    }
}
