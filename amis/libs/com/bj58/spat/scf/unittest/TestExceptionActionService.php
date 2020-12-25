<?php
use com\bj58\spat\scf\classloader\SCFClassLoader;
use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\client\SCFInit;
require_once '../unittest/bootstrap.php';




class TestExceptionActionService extends PHPUnit_Framework_TestCase
{
    /*
     * @setup
     */
    public static $scfName = "scfdemo";
    public static $serviceName = "ExceptionActionService";

    function setup() {
        $GEN_DIR = realpath(dirname(__FILE__));
        $loader = new SCFClassLoader();
        $loader->registerNamespace('SCF', __DIR__ . '/../..');
        $loader->registerDefinition('shared', $GEN_DIR);
        $loader->registerDefinition('test', $GEN_DIR);
        $loader->register();
        echo "===============SCF INIT=================\n";
    }

    /*
     * @tests
     */
    function testThrowException() {
        echo SCFInit::$DEFAULT_CONFIG_PATH;
        $isError= false;
        SCFInit::Init(__DIR__ . '/..' . '/scf_config');

        $ps = new ProxyStandard($this::$scfName, $this::$serviceName);

        print "=============invoke method===================\n";
        try {
            $responseBinarydata = $ps->invoke('throwException', array());
        } catch (Exception $e) {
            echo $e->getMessage()."\n";
            echo $e->getFile()."\n";
            echo $e->getLine()."\n";
            echo $e->getPrevious()."\n";
            echo $e->getTraceAsString()."\n";
//             $isError = true;
        }
            
        $this->assertTrue($isError,"================服务端抛出异常未被客户端检测到！！===================");
    }
    
    
    
    function testThrowError() {
        
        
        echo SCFInit::$DEFAULT_CONFIG_PATH;
        $isError= false;
        SCFInit::Init(__DIR__ . '/..' . '/scf_config');
    
        $ps = new ProxyStandard($this::$scfName, $this::$serviceName);
    
        print "=============invoke method:throwError===================\n";
        try {
            $responseBinarydata = $ps->invoke('throwError', array());
        } catch (Exception $e) {
          
            echo $e->getMessage()."\n";
            echo $e->getFile()."\n";
            echo $e->getLine()."\n";
            echo $e->getPrevious()."\n";
            echo $e->getTraceAsString()."\n";
            $isError = true;
        }
        
        $this->assertTrue($isError,"================服务端抛出异常未被客户端检测到！！===================");
    }
    
    function testThrowRuntimeException() {
        echo SCFInit::$DEFAULT_CONFIG_PATH;
        $isError= false;
        SCFInit::Init(__DIR__ . '/..' . '/scf_config');
    
        $ps = new ProxyStandard($this::$scfName, $this::$serviceName);
    
        print "=============invoke throwRuntimeException===================\n";
        try {
            $responseBinarydata = $ps->invoke('throwRuntimeException', array());
        } catch (Exception $e) {
    
            echo $e->getMessage()."\n";
            echo $e->getFile()."\n";
            echo $e->getLine()."\n";
            echo $e->getPrevious()."\n";
            echo $e->getTraceAsString()."\n";
            $isError = true;
        }
            
            $this->assertTrue($isError,"================服务端抛出异常未被客户端检测到！！===================");
    }
    
    
    
    function testThrowThrowable() {
        
        echo SCFInit::$DEFAULT_CONFIG_PATH;
        $isError= false;
        SCFInit::Init(__DIR__ . '/..' . '/scf_config');
    
        $ps = new ProxyStandard($this::$scfName, $this::$serviceName);
    
        print "=============invoke throwThrowable===================\n";
        try {
            $responseBinarydata = $ps->invoke('throwThrowable', array());
        } catch (Exception $e) {
    
            echo $e->getMessage()."\n";
            echo $e->getFile()."\n";
            echo $e->getLine()."\n";
            echo $e->getPrevious()."\n";
            echo $e->getTraceAsString()."\n";
            $isError = true;
        }
        
        $this->assertTrue($isError,"================服务端抛出异常未被客户端检测到！！===================");
    }
    
    
    
    function testThrowMyException() {
        echo SCFInit::$DEFAULT_CONFIG_PATH;
        $isError= false;
        SCFInit::Init(__DIR__ . '/..' . '/scf_config');
    
        $ps = new ProxyStandard($this::$scfName, $this::$serviceName);
    
        print "=============invoke throwMyException===================\n";
        try {
            $responseBinarydata = $ps->invoke('throwMyException', array());
        } catch (Exception $e) {
    
            echo $e->getMessage()."\n";
            echo $e->getFile()."\n";
            echo $e->getLine()."\n";
            echo $e->getPrevious()."\n";
            echo $e->getTraceAsString()."\n";
            $isError = true;
        }
        
        $this->assertTrue($isError,"================服务端抛出异常未被客户端检测到！！===================");
    }
    
    
    

}
