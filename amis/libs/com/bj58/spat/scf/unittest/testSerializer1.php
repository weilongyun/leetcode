<?php
use com\bj58\spat\scf\classloader\SCFClassLoader;
use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\client\SCFInit;
use com\bj58\spat\scf\unittest\entity\Info;
// use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
// require_once '../unittest/bootstrap.php';
require_once __DIR__. '/../classLoader/SCFClassLoader.php';


// $scfName = "scftemplate";
// $serviceName = "TypeActionService";

// $loader = new SCFClassLoader();
// $loader->registerNamespace('com\bj58\spat\scf', __DIR__ . '/../../../../..');
// $loader->register();
// echo "\n===============SCF INIT=================\n";
// $obj = SCFInit::InitGlobalScfKey(__DIR__ . '/scfkeyV1.key');

// $ps = new ProxyStandard($scfName, $serviceName,$obj);
// require_once __DIR__.'/InfoV1.php';
// $info = new Info();
// $info->setMap(array('zhang' => 'li'));
// $info->setName('zhang');
// $info->setSet(array('zhang','li'));
// $info->setContent('li');
// $info->setLst(array('zhang','li'));
// $info->setId(123);
// print "===============invoke method:  returnDate  =================\n";
// $responseBinarydata = $ps->invoke('sendInfo', array( "Info" => $info ));
// var_dump($responseBinarydata);
// echo 'successful !!!!!'.PHP_EOL;
// return $responseBinarydata;

class testSerializer1  extends PHPUnit_Framework_TestCase{
    public static $scfName = "scftemplate";
    public static $serviceName = "TypeActionService";
    public static $obj;

    function setup() {
        $loader = new SCFClassLoader();
        $loader->registerNamespace('com\bj58\spat\scf', __DIR__ . '/../../../../..');
        $loader->register();
        echo "\n===============SCF INIT=================\n";
        self::$obj = SCFInit::InitGlobalScfKey(__DIR__ . '/scfkeyV1.key');

        //                 SCFInit::Init(__DIR__ . '/scf.config');
    }

    function testSendInfo() {

        $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         require_once __DIR__.'/InfoV1.php';
        $info = new Info();
//         $info->setMap(array('zhang' => 'li'));
//         $info->setName('zhang');
//         $info->setSet(array('zhang','li'));
//         $info->setContent('li');
//         $info->setLst(array('zhang','li'));
        var_dump($info);
        $info->setId(123);
        print "===============invoke method:  returnDate  =================\n";
        $responseBinarydata = $ps->invoke('sendInfo', array( "Info" => $info ));
        var_dump($responseBinarydata);
        echo 'successful !!!!!'.PHP_EOL;
        return $responseBinarydata;
    }
}