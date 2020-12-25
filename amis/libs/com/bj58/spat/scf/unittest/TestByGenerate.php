<?php
use SCF\unittest\ITypeAction;
use SCF\classloader\SCFClassLoader;
use SCF\client\SCFInit;
require_once '../unittest/bootstrap.php';
class TestByGenerate extends PHPUnit_Framework_TestCase{
    
    
    public static $scfName = "scfdemo";
    public static $serviceName = "TypeActionService";
    
    
    
    function setup() {
         
        $GEN_DIR = realpath(dirname(__FILE__));
        $loader = new SCFClassLoader();
        $loader->registerNamespace('SCF', __DIR__ . '/../..');
        //         $loader->registerDefinition('shared', $GEN_DIR);
        //         $loader->registerDefinition('test', $GEN_DIR);
        $loader->register();
        echo "===============SCF INIT=================\n";
        
        SCFInit::Init(__DIR__ . '/..' . '/scf.config');
//         SCFInit::InitScfKey(__DIR__ . '/..' . '/scfkey.key');
    }
    
    
//     function testReturnInt(){
//         $type = new ITypeAction(self::$scfName, self::$serviceName);
        
//         $rep = $type->returnInt();
        
//         var_dump($rep);
//     }
    
    function testReturnInt2(){
        $type = new ITypeAction(self::$scfName, self::$serviceName);
    
        $rep = $type->returnInt_PHP_2(12);
    
        var_dump($rep);
    }
    
//     function testReturnInt3(){
//         $type = new ITypeAction(self::$scfName, self::$serviceName);
    
//         $rep = $type->returnInt_PHP_3(3,4,5);
    
//         var_dump($rep);
//     }
    
//     function testReturnInt4(){
//         $type = new ITypeAction(self::$scfName, self::$serviceName);
    
//         $rep = $type->returnInt_PHP_4(3,"zhangli",5);
    
//         var_dump($rep);
//     }
    
//     function testreturnString(){
//         $type = new ITypeAction(self::$scfName, self::$serviceName);
    
//         $rep = $type->return100k();
    
//         var_dump($rep);
//     }
    
//     function testReturnAddResult(){
//         $type = new ITypeAction(self::$scfName, self::$serviceName);
    
//         $rep = $type->returnAddResult(31,321.2);
    
//         var_dump($rep);
//     }
    
    
//     function testReturnArrayList1(){
//         $type = new ITypeAction(self::$scfName, self::$serviceName);
    
//         $rep = $type->returnArrayList1();
    
//         var_dump($rep);
//     }

//     function testreturnMergeList(){
//         $type = new ITypeAction(self::$scfName, self::$serviceName);
    
//         $lst1 = array("zhang","li");
//         $lst2 = array("wang","yu");
//         $rep = $type->returnMergeList($lst1, $lst2);
        
    
//         var_dump($rep);
//     }

    function testreturnMergeList(){
        $type = new ITypeAction(self::$scfName, self::$serviceName);
    
        $map1 = array( "zhang" => "li");
        $map2 = array( "wang" => "yu");
        $rep = $type->returnMergeMap($map1 , $map2);
    
    
        var_dump($rep);
    }
    
    
}