<?php
use com\bj58\spat\scf\classloader\SCFClassLoader;
use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\client\SCFInit;
require_once '../unittest/bootstrap.php';




class TestBigDataActionService extends PHPUnit_Framework_TestCase
{
    /*
     * @setup
     */
    public static $scfName = "scfdemo";
    public static $serviceName = "BigDataActionService";
    
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
    
    function testReturnBigData() {
        @ini_set('memory_limit', '512M');
        echo SCFInit::$DEFAULT_CONFIG_PATH;
        SCFInit::Init(__DIR__ . '/..' . '/scf_config');

        $ps = new ProxyStandard(self::$scfName, self::$serviceName);

        print "=============invoke method===================\n";
        $responseBinarydata = $ps->invoke('returnBigData', array());

        $this->assertNotNull($responseBinarydata, "======================================");

        print "$responseBinarydata\n";
        //         return $responseBinarydata;
    }

    
    
}
