<?php

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\client\SCFInit;
use com\bj58\spat\scf\test\News;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\spat\scf\serialize\classes\GKeyValuePair;
use com\bj58\spat\scf\unittest\Test1;
use com\bj58\spat\scf\unittest\entity\Content;
use com\bj58\spat\scf\unittest\entity\Entity;
use com\bj58\spat\scf\classloader\SCFClassLoader;
// require_once 'bootstrap.php';

require_once __DIR__ . '/../classLoader/SCFClassLoader.php';
require_once __DIR__ . '/../protocol/sdp/ExceptionProtocol.php';

$GEN_DIR = realpath(dirname(__FILE__));

var_dump(__DIR__ . '/../classLoader/SCFClassLoader.php');
$loader = new SCFClassLoader();
$loader->registerNamespace('com\bj58\spat\scf', __DIR__ . '/../../../../..');
$loader->register();

function testExtends()
{
    SCFInit::Init("E:\\scf.config", 'E:\\error_log.log');
    $ps = new ProxyStandard('scfdemo', 'PhpService');
    $type = new Entity();
    $lst = array(
        "zhang",
        "li"
    );
    $set = array(
        "ZHANG",
        "LI"
    );
    $map = array(
        "zhang" => "li"
    );
    $content = new Content();
    $content->setTitle("zhang");
    $content->setContent("li");
    $type->setId(1);
    $type->setName("zhangli");
    $type->setLst($lst);
    $type->setMap($map);
    $type->setSet($set);
    $type->setContent($content);
    var_dump($type);
    print "===============invoke method:  sendObject  =================\n";
    $responseBinarydata = $ps->invoke('sendObject', array(
        'Entity' => $type
    ));
    var_dump($responseBinarydata);
}

// testExtends();
function getListNews()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $ns = new News();
        $ns->setName('client');
        $ns->setId(0);
        $ns->setTitle('just a test');

        $lst = array(
            10,
            20,
            30,
            45
        );

        $value = array(
            'News' => $ns,
            'List<Integer>' => $lst
        );
        $responseBinarydata = $ps->invoke('getListNews', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getTest1()
{
    try {
        SCFInit::Init("E:\\scf.config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $type = new Test1();
        ObjectSerializer::GetTypeInfo($type);
        $map = array(
            1 => 'just',
            2 => 'a',
            3 => 'test'
        );
        $value = array(
            'HashMap<key = Integer, value = String>' => $map
        );
        $responseBinarydata = $ps->invoke('getTest1', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getMapNews()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $ns = new News();
        $ns->setName('client');
        $ns->setId(0);
        $ns->setTitle('just a test');

        $ns2 = new News();
        $ns2->setName('client2');
        $ns2->setId(1);
        $ns2->setTitle('just a test 2!');

        $lst = array(
            $ns,
            $ns2
        );
        $value = array(
            'List<News>' => $lst
        );
        $responseBinarydata = $ps->invoke('getMapNews', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getListMapNews()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $ns = new News();
        $ns->setName('client');
        $ns->setId(0);
        $ns->setTitle('just a test');

        $ns2 = new News();
        $ns2->setName('client2');
        $ns2->setId(1);
        $ns2->setTitle('just a test 2!');

        $lst = array(
            $ns,
            $ns2
        );
        $lst2 = array(
            $ns
        );
        $map = array(
            'first' => $lst,
            'second' => $lst2
        );
        $value = array(
            'Map<key = String, value = List<News>>' => $map
        );
        $responseBinarydata = $ps->invoke('getListMapNews', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getMapListNews()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $ns = new News();
        $ns->setName('client');
        $ns->setId(0);
        $ns->setTitle('just a test');

        $ns2 = new News();
        $ns2->setName('client2');
        $ns2->setId(1);
        $ns2->setTitle('just a test 2!');

        $map = array(
            'test1' => $ns,
            'test2' => $ns2
        );
        $lst = array(
            $map
        );
        $value = array(
            'List<Map<key = String, value = News>>' => $lst
        );
        $responseBinarydata = $ps->invoke('getMapListNews', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getStr()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $d = 12.345;
        $str = 'jsadgwerd';
        $value = array(
            'double' => $d,
            'String' => $str
        );
        $responseBinarydata = $ps->invoke('getStr', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getDouble()
{
    try {
        // SCFInit::Init("E:\\scf_config");
        SCFInit::InitScfKey('E:\\scfkey.key');
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $d = 12.34;
        $i = 234;
        $value = array(
            'float' => $d,
            'int' => $i
        );
        $responseBinarydata = $ps->invoke('getDouble', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getFloat()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $f = 12.345;
        $d = 234.4567;
        $value = array(
            'float' => $f,
            'double' => $d
        );
        $responseBinarydata = $ps->invoke('getFloat', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getLong()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $f = 12.34;
        $l = 2345465745;
        $value = array(
            'float' => $f,
            'long' => $l
        );
        $responseBinarydata = $ps->invoke('getLong', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getDateTest()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $date = getdate();
        $value = array(
            'Date' => $date
        );
        $responseBinarydata = $ps->invoke('getDate2', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}


// var_dump($responseBinarydata);

function getTest2()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');

        $type = new News();
        ObjectSerializer::GetTypeInfo($type);
        $type = new Test1();
        ObjectSerializer::GetTypeInfo($type);

        $test = new Test1();
        $lst = array(
            11,
            22,
            33,
            44
        );
        $test->setLst($lst);
        $maps = array(
            1 => 'test',
            2 => 'test2'
        );
        $test->setMaps($maps);
        $ns = new News();
        $ns->setId(58);
        $ns->setName('tongcheng');
        $ns->setTitle('shenqidewangzhan');
        $test->setNews($ns);
        $value = array(
            'Test1' => $test
        );
        $responseBinarydata = $ps->invoke('getTest2', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getArray()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $ns = new News();
        $ns->setId(58);
        $ns->setName('tongcheng');
        $ns->setTitle('shenqidewangzhan');

        $ns2 = new News();
        $ns2->setName('client2');
        $ns2->setId(1);
        $ns2->setTitle('just a test 2!');
        $arr = array(
            $ns,
            $ns2
        );

        $ints = array(
            1,
            2,
            3,
            4
        );
        $value = array(
            'News[]' => $arr,
            'Integer[]' => $ints
        );
        $responseBinarydata = $ps->invoke('getArray', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getArray2()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $ns = new News();
        $ns->setId(58);
        $ns->setName('tongcheng');
        $ns->setTitle('shenqidewangzhan');

        $ns2 = new News();
        $ns2->setName('client2');
        $ns2->setId(1);
        $ns2->setTitle('just a test 2!');
        $arr = array(
            $ns,
            $ns2
        );

        $ints = array(
            1,
            2,
            3,
            4
        );
        $value = array(
            'News[]' => $arr,
            'Integer[]' => $ints
        );
        $responseBinarydata = $ps->invoke('getArray2', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getArray3()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $ns = new News();
        $ns->setId(58);
        $ns->setName('tongcheng');
        $ns->setTitle('shenqidewangzhan');

        $ns2 = new News();
        $ns2->setName('client2');
        $ns2->setId(1);
        $ns2->setTitle('just a test 2!');
        $arr = array(
            $ns,
            $ns2
        );

        $arr = array(
            $ns,
            $ns2
        );
        $arr2 = array(
            $ns2
        );
        $arrs = array(
            $arr,
            $arr2
        );
        $value = array(
            'List<News[]>' => $arrs
        );
        $responseBinarydata = $ps->invoke('getArray3', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getArray4()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');

        $arr = array(
            122.123,
            12.546
        );
        $value = array(
            'Double[]' => $arr
        );
        $responseBinarydata = $ps->invoke('getArray4', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getArray5()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');

        $arr = array(
            122123435,
            125565796
        );
        $value = array(
            'Long[]' => $arr
        );
        $responseBinarydata = $ps->invoke('getArray5', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getArray6()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');

        $arr = array();
        $responseBinarydata = $ps->invoke('getArray6', $arr);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getBoolean()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $gkv = new GKeyValuePair("time", "money");
        $arr = array(
            $gkv
        );
        $value = array(
            'boolean' => $arr
        );
        $responseBinarydata = $ps->invoke('getArray5', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function getGKV()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');

        $arr = array(
            'true'
        );
        $value = array(
            'GKeyValue<String, String>' => $arr
        );
        $responseBinarydata = $ps->invoke('getGKV', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}

function testObject()
{
    try {
        SCFInit::Init("E:\\scf_config");
        $ps = new ProxyStandard('scfdemo', 'PhpService');
        $lst1 = array(
            'zhang',
            'li'
        );
        $map1 = array(
            'jiagou' => lst1
        );
        $map2 = array(
            '58' => $map1
        ); // Map<String, Map<String, List<String>>>
        $value = array(
            'Map<key = String, value = Map<key = String, value = List<String>>>' => $map2
        );
        $responseBinarydata = $ps->invoke('test', $value);
        return $responseBinarydata;
    } catch (Exception $e) {
        echo $e->getMessage(), PHP_EOL;
    }
}


// $content = new ContentChild();
// ObjectSerializer::GetTypeInfo($content);

// $start = '18, 17, 13, 10, 9';
// $end = '9, 10, 13, 17, 18';
// $s = null;
// foreach (explode(',', $start) as $v) {
//     $s = $s . pack('C', trim($v));
// }
// $e = null;
// foreach (explode(',', $end) as $v) {
//     $e = $e . pack('C', trim($v));
// }

@ini_set('memory_limit', '64M');
$num = 0;
while ($num < 5) {
    $responseBinarydata = getDouble();
    var_dump($responseBinarydata);
    $num ++;
}

// $type = new News();
// ObjectSerializer::GetTypeInfo($type);
// $type = new Test1();
// ObjectSerializer::GetTypeInfo($type);
// $writeBinaryData = $s . $responseBinarydata . $e;

// try {12
//     //     $obj = new ScfSocket('10.9.128.219', '16130');
//     $obj = new ScfSocket('127.0.0.1', '16002');
//     $obj->open();
//     $binarydata = $obj->request($writeBinaryData);
//     $obj->close();

//     $version = substr($binarydata, 0, 1);
//     $version = unpack('c', $version);
//     //testing
//     $result = Protocol::fromBytes($binarydata);
//     if ($result->getSdpType() == SDPType::Response) {
//         $responseProtocol = $result->getSdpEntity();
//         $res = $responseProtocol-> getResult();
//         var_dump($res);
//     } else if ($result->getSdpType() == SDPType::Exception) {
//         throw new Exception($result->getSdpEntity()->getErrorCode());
//     } else {
//         throw new \Exception("userdatatype error!");
//     }
// }
// catch (Exception $e) {
//     echo $e->getMessage(), PHP_EOL;
// }




