<?php

use com\bj58\spat\scf\classloader\SCFClassLoader;
use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\client\SCFInit;
require_once '../unittest/bootstrap.php';

class TestSpecAction extends PHPUnit_Framework_TestCase
{
    /*
     * @setup
     */
    public static $scfName = "scfdemo";
    public static $serviceName = "SpecActionService";
    
    function setup() {
        $GEN_DIR = realpath(dirname(__FILE__));
        $loader = new SCFClassLoader();
        $loader->registerNamespace('SCF', __DIR__ . '/../..');
//         $loader->registerDefinition('shared', $GEN_DIR);
//         $loader->registerDefinition('test', $GEN_DIR);
        $loader->register();
        echo "\n===============SCF INIT=================\n";
    }

    
    function testRreturnInt() {
        echo SCFInit::$DEFAULT_CONFIG_PATH;
        SCFInit::Init(__DIR__ . '/..' . '/scf_config');

        $ps = new ProxyStandard($this::$scfName, $this::$serviceName);

        print "=============invoke method===================\n";
        $responseBinarydata = $ps->invoke('returnSpecStr', array());

        $this->assertNotNull($responseBinarydata, "======================================");

        print "$responseBinarydata\n";
        //         return $responseBinarydata;
    }
    
    function testReturnSpeStr(){
        
        SCFInit::Init(__DIR__."/../scf_config");
        $ps = new ProxyStandard($this::$scfName, $this::$serviceName);
        print "=============invoke method : returnSpecChar===================\n";
        $responseData = $ps->invoke("returnSpecChar", Array());
        echo $responseData."\n";
    }
    
    
    function testReturnSpecLang(){

        SCFInit::Init(__DIR__."/../scf_config");
        $ps = new ProxyStandard($this::$scfName, $this::$serviceName);
        print "=============invoke method : returnSpecLang===================\n";
        $responseData = $ps->invoke("returnSpecLang", Array());
        echo $responseData."\n";
    }
    
    
    
    function testReturnSpecRegular(){

        SCFInit::Init(__DIR__."/../scf_config");
        $ps = new ProxyStandard($this::$scfName, $this::$serviceName);
        print "=============invoke method : returnSpecRegular===================\n";
        $responseData = $ps->invoke("returnSpecRegular", Array());
        echo $responseData."\n";
    } 
    
    
    function testReturnBlankStr(){
    
        SCFInit::Init(__DIR__."/../scf_config");
        $ps = new ProxyStandard($this::$scfName, $this::$serviceName);
        print "=============invoke method : returnBlankStr===================\n";
        $responseData = $ps->invoke("returnBlankStr", Array());
        echo $responseData."\n";
    }
    
    
    function testReturnBigDecimalObj(){

        SCFInit::Init(__DIR__."/../scf_config");
//         ini_set("memory_limit","100M");
        $ps = new ProxyStandard($this::$scfName, $this::$serviceName);
        print "=============invoke method : returnBigDecimalObj===================\n";
        $responseData = $ps->invoke("returnBigDecimalObj", Array());
        echo $responseData."\n";
    }
    
    
}