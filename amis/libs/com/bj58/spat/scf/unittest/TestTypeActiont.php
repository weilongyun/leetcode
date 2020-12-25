// <?php
use com\bj58\spat\scf\classloader\SCFClassLoader;
use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\client\SCFInit;
use com\bj58\spat\scf\unittest\entity\ArrayObj;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\spat\scf\unittest\entity\Entity;
use com\bj58\spat\scf\unittest\entity\Content;
use com\bj58\spat\scf\unittest\entity\ContentChild;
use com\bj58\spat\scf\unittest\entity\Info;
use com\bj58\spat\scf\unittest\enum\Color;
use com\bj58\spat\scf\unittest\enum\InfoEnum;
// require_once '../unittest/bootstrap.php';
require_once __DIR__. '/../classloader/SCFClassLoader.php';
// require_once "C:/Users/58/Zend/workspaces/DefaultWorkspace12.5/com.bj58.spat.scf/com/bj58/spat/scf/classLoader/SCFClassLoader.php";
class TestTypeActiont extends PHPUnit_Framework_TestCase
{
    /*
     * @setup
     */
    
    public static $scfName = "scftemplate";
    public static $serviceName = "TypeActionService";
    public static $obj;
    
    function setup() {
        $loader = new SCFClassLoader();                                                                                                                       
        $loader->registerNamespace('com\bj58\spat\scf', __DIR__ . '/../../../../..');
        $loader->register();
        echo "\n===============SCF INIT=================\n";
        self::$obj = SCFInit::InitGlobalScfKey(__DIR__ . '/scfkeyV1.key');
//                 SCFInit::Init(__DIR__ . '/..' . '/scf.config');
    }
    
    
    function testSendAndReturnInfoEnum() {
        $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
        $color = new Color();
        ObjectSerializer::GetTypeInfo($color);
        $infoEnum = new InfoEnum();
        $infoEnum->setId(123);
        $infoEnum->setColor($color::RED);
        $value = array( "InfoEnum" => $infoEnum );
        $responseBinarydata = $ps->invoke('sendAndReturnInfoEnum', $value);
        var_dump($responseBinarydata);
    }
    
//     function testSendAndReturnEnum() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $color = new Color();
//         ObjectSerializer::GetTypeInfo($color);
//         $value = array( "Color" => $color::RED );
//         $responseBinarydata = $ps->invoke('sendEnum', $value);
//         var_dump($responseBinarydata);
//     }
    
//     function testSendInfo() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
    
//         $info = new Info();
//         $info->setId(123);
//         //         $info->setDate(array(1));
//         print "===============invoke method:  returnDate  =================\n";
//         $responseBinarydata = $ps->invoke('sendInfo', array( "Info" => $info ));
//         var_dump($responseBinarydata);
//         return $responseBinarydata;
//     }
//     function testSendMapAndList() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
        
//         $map = array(
//             'z' => array('z','h','a','n','g'),
//             'l' => array('l','i')
//         );
//         $lst = array(
//             array('z','h','a','n','g'),
//             array('l','i')
//         ); 
// //         '1@Map<key = String, value = String>' => $map1,
//         $value = array(
//                     '1@Map<key = String, value = List<String>>' => $map ,
//                     '2@List<Set<String>>' => $lst 
//                 );
        
//         $responseBinarydata = $ps->invoke('sendMapAndList', $value);
//     }
    
//     function testSendAndReturnArrayObject(){
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $arr = array(1,2,3,4,5);
//         $arrObj = new ArrayObj();
//         $arrObj->setArr($arr);
//         print "===============invoke method:  returnDate  =================\n";
//         $responseBinarydata = $ps->invoke('sendArrayObject', array( "ArrayObj" => $arrObj ));
//         var_dump($responseBinarydata);
//         return $responseBinarydata;
//     }
//     function testSendArray(){
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $responseBinarydata = $ps->invoke('sendArray', array( 'int[]' => array(1,2,3,4)));
//         var_dump($responseBinarydata);
//     }
//     function testReturnArray(){
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $responseBinarydata = $ps->invoke('returnArray', array());
//         var_dump($responseBinarydata);
//     }
    
    
//     function testSendDate() {
        
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         print "===============invoke method:  returnDate  =================\n";
//         $responseBinarydata = $ps->invoke('sendDate', array( "Date" => 1232131213 ));
    
//         return $responseBinarydata;
//     }
    
//     function testNull() {
//         $ps = new ProxyStandard(self::$scfName, self::$serviceName);
//         $responseBinarydata = $ps->invoke('returnNK', array( 'int' => 1 ));
//     }
//     function testRreturnInt() {
//         for($i = 0; $i < 10 ; $i++){
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         print "=============invoke method: returnInt  ===================\n";
//         $responseBinarydata = $ps->invoke('returnInt', array());

//         $this->assertNotNull($responseBinarydata, "===================error:return is null===================");
//         print "$responseBinarydata\n";
//         }
//     }
    
//     function testRreturnIntByOnePara() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $d = 3123;
//         $value = array(
//             '1@Integer' => $d ,
//         );
//         print "=============invoke method: returnInt  ===================\n";
//         $responseBinarydata = $ps->invoke('returnInt', $value );
    
//         $this->assertNotNull($responseBinarydata, "===================error:return is null===================");
//         echo "\n";
//         print "$responseBinarydata\n";
//     }
    
//     function testRreturnIntByThreePara() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         $d = 3;
//         $i = 4;
//         $j = 5;
//         $value = array(
//             '1@int' => $d ,
//             '2@int' => $i ,
//             '3@int' => $j,
//         );
//         print "=============invoke method: returnInt  ===================\n";
//         $responseBinarydata = $ps->invoke('returnInt', $value );
    
//         $this->assertNotNull($responseBinarydata, "===================error:return is null===================");
//         echo "\n";
//         print "$responseBinarydata\n";
//     }
    
//     function testRreturnIntByThreePara2() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         $d = -13;
//         $i = 'zhangli';
//         $j = -5;
//         $value = array(
//             '1@int' => $d ,
//             '2@String' => $i ,
//             '3@int' => $j,
//         );
//         print "=============invoke method: returnInt  ===================\n";
//         $responseBinarydata = $ps->invoke('returnInt', $value );
    
//         $this->assertNotNull($responseBinarydata, "===================error:return is null===================");
//         echo "\n";
//         print "$responseBinarydata\n";
//         //         return $responseBinarydata;
//     }
    
    
//     function testRreturnMergerSet() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         $set1 = array("zhang","ZHANG");
//         $set2 = array("li");
//         $value = array(
//             '2@Set<String>' => $set1,
//             '1@Set<String>' => $set2
//         );
//         print "=============invoke method: returnMergeSet  ===================\n";
//         $responseBinarydata = $ps->invoke('returnMergeSet', $value );
    
//         $this->assertNotNull($responseBinarydata, "===================error:return is null===================");
//         echo "\n";
//         var_dump($responseBinarydata);;
//         //         return $responseBinarydata;
//     }
    
    
//     function testRreturnMergerList() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $lst1 = array("zhang");
//         $lst2 = array("li");
//         $value = array(
//             '2@List<String>' => $lst1,
//             '1@List<String>' => $lst2
//         );
//         print "=============invoke method: returnMergeList  ===================\n";
//         $responseBinarydata = $ps->invoke('returnMergeList', $value );
    
//         $this->assertNotNull($responseBinarydata, "===================error:return is null===================");
//         var_dump($responseBinarydata);
//         //         return $responseBinarydata;
//     }
    
    
//     function testRreturnMergeStr() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         $set1 = array("");
//         $value = array(
//             '2@String' => 'zhang ',
//             '1@String' => 'li'
//         );
//         print "=============invoke method: returnMergeStr  ===================\n";
//         $responseBinarydata = $ps->invoke('returnMergeStr', $value );
    
//         $this->assertNotNull($responseBinarydata, "===================error:return is null===================");
//         var_dump($responseBinarydata);
//         //         return $responseBinarydata;
//     }
    
    
//     function testRreturnMergerMap() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         $map1 = array(
//             '1' => 'zhang',
//         );
        
//         $map2 = array(
//             '2' => 'li',
//         );

//         $value = array(
//             '1@Map<key = String, value = String>' => $map1,
//             '2@Map<key = String, value = String>' => $map2,
//         );
//         print "=============invoke method: returnMergeMap  ===================\n";
//         $responseBinarydata = $ps->invoke('returnMergeMap', $value );
    
//         $this->assertNotNull($responseBinarydata, "===================error:return is null===================");
//         echo "\n";
//         print "$responseBinarydata\n";
//         //         return $responseBinarydata;
//     }

    
//     function testReturnAddResult() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         $d = 12.34;
//         $i = 234;
//         $value = array(
//             '1@Integer' => $i,
//             '2@float' => $d
//         );
//         print "=============invoke method: returnAddResult  ===================\n";
//         $responseBinarydata = $ps->invoke('returnAddResult', $value );
    
//         $this->assertNotNull($responseBinarydata, "===================error:return is null===================");
//         var_dump($responseBinarydata);
//         //         return $responseBinarydata;
//     }

//     function testReturnInteger() {

//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);

//         print "===============invoke method:  returnInteger  =================\n";
//         $responseBinarydata = $ps->invoke('returnInteger', array());

//         $this->assertNotNull($responseBinarydata, "==================error:return is null====================");
//         print $responseBinarydata."\n";
//         return $responseBinarydata;
//     }

//     function testReturnLstLong() {

//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         print "===============invoke method:  returnLstLong  =================\n";
//         $longValue = 1;
//         $responseBinarydata = $ps->invoke('returnLstLong', array());
    
//         $this->assertNotNull($responseBinarydata, "=================error:return is null=====================");
//         echo PHP_EOL;
        
//         foreach($responseBinarydata as $key=>$value)
//         {
//             echo $key.'=>'.$value."\n";
//         }
//         return $responseBinarydata;
//     }

//     function testReturnLstString() {

//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);

//         print "===============invoke method:  returnLstString  =================\n";
//         $longValue = 1;
//         $responseBinarydata = $ps->invoke('returnLstString', array());

//         $this->assertNotNull($responseBinarydata, "===============error:return is null==================");
//         $responseBinarydata;

//         foreach($responseBinarydata as $key=>$value)
//             {
//                 echo $key.'=>'.$value."\n";
//             }
//         return $responseBinarydata;
//     }

//     function testReturnMap() {
    
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         print "===============invoke method:  returnMap  =================\n";
//         $longValue = 1;
//         $responseBinarydata = $ps->invoke('returnMap', array());
    
//         $this->assertNotNull($responseBinarydata, "===============error:return is null==================");
//         var_dump($responseBinarydata);
    
//     }

//     function testReturnDoubleList() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);

//         print "===============invoke method:  returnDoubleList  =================\n";
//         $longValue = 1;
//         $responseBinarydata = $ps->invoke('returnDoubleList', array());

//         $this->assertNotNull($responseBinarydata, "===============error:return is null==================");
//         var_dump($responseBinarydata);

//         foreach($responseBinarydata as $key=>$value)
//         {
//             echo '('.$key.", (";
//             foreach ($value as $key => $value)
//             {
//                 echo "   ".$value;
//             }
//             echo ") )\n";
//         }
//         return $responseBinarydata;
//     }
    
//     function testReturnNull() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);

//         print "===============invoke method:  returnNull  =================\n";
//         $responseBinarydata = $ps->invoke('returnNK', array( 'int' => 0 ));

//         $this->assertNull($responseBinarydata, "===============error:return is not null==================");
//         echo $responseBinarydata."\n";
//         return $responseBinarydata;
//     }
    
//     function testReturnBigDecimal() {
    
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         print "===============invoke method:  returnBigDecimal  =================\n";
//         $responseBinarydata = $ps->invoke('returnBigDecimal', array());
    
//         $this->assertNotNull($responseBinarydata, "===============error:return is not null==================");
//         echo $responseBinarydata."\n";
//         return $responseBinarydata;
//     }
    
//     function testReturnDate() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         print "===============invoke method:  returnDate  =================\n";
//         $responseBinarydata = $ps->invoke('returnDate', array());
    
//         $this->assertNotNull($responseBinarydata, "===============error:return is not null==================");
//         foreach($responseBinarydata as $key=>$value)
//         {
//             echo $key.'=>'.$value."\n";
//         }
        
//         return $responseBinarydata;
//     }
    
//     function testReturnDBNULL() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         print "===============invoke method:  returnDBNULL  =================\n";
//         $responseBinarydata = $ps->invoke('returnDBNULL', array());
    
//         $this->assertNull($responseBinarydata, "===============error:return is not null==================");
//         echo $responseBinarydata."\n";
//         return $responseBinarydata;
//     }
    
    
//     function testReturnboolean() {
    
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         print "===============invoke method:  returnboolean  =================\n";
//         $responseBinarydata = $ps->invoke('returnboolean', array());
    
//         $this->assertNotNull($responseBinarydata, "===============error:return is not null==================");
//         echo $responseBinarydata."\n";
//         var_dump($responseBinarydata);
//         return $responseBinarydata;
//     }
    
//     function testReturnGKeyValuePair() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         print "===============invoke method:  returnGKeyValuePair  =================\n";
//         $responseBinarydata = $ps->invoke('returnGKeyValuePair', array());
    
//         $this->assertNotNull($responseBinarydata, "===============error:return is not null==================");
//         $this->assertNotNull($responseBinarydata->getValue(),"==================value is null==============");
//         $this->assertNotNull($responseBinarydata->getKey(),"==================key is null==============");
//         var_dump($responseBinarydata->getKey());
//         var_dump($responseBinarydata->getValue());
//     }
    
//     function testReturnSet() {
    
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         print "===============invoke method:  returnSet  =================\n";
//         $responseBinarydata = $ps->invoke('returnSet', array());
    
//         $this->assertNotNull($responseBinarydata, "===============error:return is not null==================");
//         foreach($responseBinarydata as $key=>$value)
//         {
//             echo $key.'=>'.$value."\n";
//         }
        
//         $this->assertNotNull($responseBinarydata,"==================key is null==============");
//         $this->assertNotEquals(sizeof($responseBinarydata, 0), 0,"=====没有数据返回！！！！==========");
//         return $responseBinarydata;
//     }
    
//     function testReturnByte_uper() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);

//         print "===============invoke method:  returnByteC  =================\n";
//         $responseBinarydata = $ps->invoke('returnByteC', array());
        
//         echo $responseBinarydata."\n";


//     }
//     function testReturnbyte_lower() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);

//         print "===============invoke method:  returnbyte  =================\n";
//         $responseBinarydata = $ps->invoke('returnbyte', array());
//         echo $responseBinarydata."\n";
//     }

// //     function testReturnComplexMap() {
        
// //         @ini_set('memory_limit', '512M');
// //         SCFInit::Init(__DIR__ . '/..' . '/scf.config');
        
// //         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
// //         print "===============invoke method:  returnComplexMap  =================\n";
// //         $responseBinarydata = $ps->invoke('returnComplexMap', array());
        
// //         $responseBinarydata = $ps->invoke('returnComplexMap2', array());
        
// //         $responseBinarydata = $ps->invoke('returnComplexMap3', array());
        
        
// //         $responseBinarydata = $ps->invoke('returnComplexMap4', array());
        
        
// // //         var_dump($responseBinarydata);
    
    
// //     }

//     function testReturnComplexMap5() {

//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);

//         print "===============invoke method:  returnComplexMap  =================\n";

//         $responseBinarydata = $ps->invoke('returnComplexMap5', array());


//         var_dump($responseBinarydata);
//     }
    
    
//     function testReturnMultilayerList() {
    
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $entity = new Entity();
//         ObjectSerializer::GetTypeInfo($entity);
    
//         print "===============invoke method:  returnMultilayerList  =================\n";
//         $responseBinarydata = $ps->invoke('returnMultilayerList', array());
//         var_dump($responseBinarydata);
    
    
//     }
    
    
//     function testReturnMultilayerComplexType() {
    
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $entity = new Entity();
//         ObjectSerializer::GetTypeInfo($entity);
    
    
//         print "===============invoke method:  returnMultilayerComplexType  =================\n";
//         $responseBinarydata = $ps->invoke('returnMultilayerComplexType', array());
//         var_dump($responseBinarydata);
    
    
//     }


//     function testSendList() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $type = array('zhang','li');
//         print "===============invoke method:  sendList  =================\n";
//         $responseBinarydata = $ps->invoke('sendList', array( 'List<String>' => $type ));
//         var_dump($responseBinarydata);
//     }

//     function testSendSet() {
    
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $type = array('zhang','li','li');
//         print "===============invoke method:  sendSet  =================\n";
//         $responseBinarydata = $ps->invoke('sendSet', array( 'Set<String>' => $type ));
//         var_dump($responseBinarydata);
//     }
//     function testSendMap() {
    
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $map = array(
//             'just' => 1, 
//             'a' => 2 
//         );
        
//         $value = array( 
//             'Map<key = String, value = Integer>' => $map //此处map的格式需严格按照样本来写，多出空格都容易报错
//         );
//         print "===============invoke method:  sendMap  =================\n";
//         $responseBinarydata = $ps->invoke('sendMap', $value);
//         var_dump($responseBinarydata);
//     }
    

//     function testSendMap2() {

//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $map = array(
//             1 => 'just',
//             2 => 'a',
//             3 => 'test'
//         );

//         $value = array(
//             'Map<key = Integer, value = String>' => $map
//         );
//         print "===============invoke method:  sendMap2  =================\n";
//         $responseBinarydata = $ps->invoke('sendMap2', $value);
//         var_dump($responseBinarydata);
//     }

//     function testSendBigDecimal() {

//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
        
//         print "===============invoke method:  sendBigDecimal  =================\n";
//         $responseBinarydata = $ps->invoke('sendBigDecimal', array( 'BigDecimal' => 31.222222222222222222222222222222222 ));
//         var_dump($responseBinarydata);
//     }

//     function testSendComplexMap() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);

//         $lst1 = array( 'zhang', 'li');
        
//         $map1 = array('jiagou' => $lst1);
        
//         $map2 = array('58' => $map1);//由于array中key只能是
        
//         print "===============invoke method:  sendComplexMap  =================\n";
//         $responseBinarydata = $ps->invoke('sendComplexMap', array( 'Map<key = String, value = Map<key = String, value = List<String>>>' => $map2 ));
//         var_dump($responseBinarydata);
//         $responseBinarydata = $ps->invoke('sendComplexMap', array( 'Map<key = String, value = Map<key = String, value = List<String>>>' => $map2 ));
        
        
//     }

    

    
//     function testReturnContent(){
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $content = new Content();
//         ObjectSerializer::GetTypeInfo($content);

//         print "===============invoke method:  returnChild  =================\n";
//         $responseBinarydata = $ps->invoke('returnContent', array());
//         var_dump($responseBinarydata->getContent());
//         var_dump($responseBinarydata->getTitle());
//     }
//     function testSendContent(){

//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);


//         $content = new Content();
//         $content->setTitle("LI");
//         $content->setContent("ZHANG");
//         print "===============invoke method:  sendChild  =================\n";
//         $responseBinarydata = $ps->invoke('sendContent', array( 'Content' => $content ));
// //         var_dump($responseBinarydata->getContent());

//     }

// //     function testSendHashMap2(){

        
        
// //         SCFInit::Init(__DIR__ . '/..' . '/scf.config');
// //         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
// //         $content = new Content();
// //         $entity = new Entity();
// //         $map = array(
// //             "content" => $content, 
// //             "map" => $map 
// //         );
        
// //         $value = array( 
// //             'Map<key = String, value = Content>' => $map //此处map的格式需严格按照样本来写，多出空格都容易报错
// //         );
// //         print "===============invoke method:  sendMap  =================\n";
// //         $responseBinarydata = $ps->invoke('sendHashMap2', $value);
// //         var_dump($responseBinarydata);

// //     }

//     function testSendHashMap3(){
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $map = array(
//             "content" => "content",
//             "map" => "map"
//         );
    
//         $value = array(
//             'HashMap<key = String, value = String>' => $map //此处map的格式需严格按照样本来写，多出空格都容易报错
//         );
//         print "===============invoke method:  sendMap  =================\n";
//         $responseBinarydata = $ps->invoke('sendHashMap3', $value);
//         var_dump($responseBinarydata);
    
//     }

//     function testSendHashSet1(){
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $set = array(
//             "content",
//             "map"
//         );
        
//         $value = array(
//             'Set<String>' => $set //此处map的格式需严格按照样本来写，多出空格都容易报错
//         );
//         print "===============invoke method:  sendMap  =================\n";
//         $responseBinarydata = $ps->invoke('sendSet', $value);
//         //         $responseBinarydata = $ps->invoke('sendSet', array( 'Set<String>' => $type ));
//         var_dump($responseBinarydata);

//     }


//     function testSendArrayList(){
// //         SCFInit::Init(__DIR__ . '/..' . '/scf.config');
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $lst = array(
//             "content",
//             "map",
//             "map"
//         );
        
//         $value = array(
//             'ArrayList<String>' => $lst //此处map的格式需严格按照样本来写，多出空格都容易报错
//         );
//         print "===============invoke method:  sendArrayList1  =================\n";
//         $responseBinarydata = $ps->invoke('sendArrayList1', $value);
//         //         $responseBinarydata = $ps->invoke('sendSet', array( 'Set<String>' => $type ));
//         var_dump($responseBinarydata);
    
//     }
    
//     function testReturnArrayList1(){
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
    
//         print "===============invoke method:  sendArrayList1  =================\n";
//         $responseBinarydata = $ps->invoke('returnArrayList1', array());
//         //         $responseBinarydata = $ps->invoke('sendSet', array( 'Set<String>' => $type ));
//         var_dump($responseBinarydata);
//     }

    
//     function testSleep(){
//         echo time();
//         for( $i = 0; $i<1; $i++){
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $ps->invoke('sleep', array( 'Long' => 3 ));
//         }
//         echo "结束";
//     }
    
    
    
//     function testSendChild(){

//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $content = new ContentChild();


// //         var_dump(content::$_SCFNAME);
// //         var_dump(content::$_TSPEC);
// //         $content->setLst(array("zhang","li"));
//         $content->setC(123);
//         $content->setB(123.3);
//         $content->setA("li");
//         $content->setTitle("LI");
//         $content->setContent("ZHANG");
//         print "===============invoke method:  sendChild  =================\n";
//         $responseBinarydata = $ps->invoke('sendChild', array( '1@ContentChild' => $content ));
//         var_dump($responseBinarydata);
// //         var_dump($responseBinarydata->getContentc());

//     }
    
//     function testSendObject() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $type = new Entity();
        
//         $lst= array("zhang","li");
//         $set= array("ZHANG","LI");
//         $map= array("zhang" => "li" );
// //         $content = new Content();
// //         $content->setTitle("zhang");
// //         $content->setContent("li");
//         $content = 'content';
//         $type->setId(1);
//         $type->setName("zhangli");
//         $type->setLst($lst);
//         $type->setMap($map);
//         $type->setSet($set);
//         $type->setContent($content);
//         print "===============invoke method:  sendObject  =================\n";
//         $responseBinarydata = $ps->invoke('sendObject', array( 'Entity' => $type ));
//         var_dump($responseBinarydata);
//     }

//     function testReturnBytesC(){
        
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $expression=$ps->invoke('returnBytesC', array());
//         var_dump($expression);
//         echo "结束";
//     }
    
//     function testReturnObject() {
    
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $entity = new Entity();
//         ObjectSerializer::GetTypeInfo($entity);
//         $content = new Content();
//         ObjectSerializer::GetTypeInfo($content);
//         print "===============invoke method:  returnObject  =================\n";
//         $responseBinarydata = $ps->invoke('returnObject', array());
//         $entity = new Entity();
//         $entity = $responseBinarydata;
//         var_dump($entity);
//     }
    
//     function testReturnChild(){
       
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $content = new Content();
//         ObjectSerializer::GetTypeInfo($content);
    
//         $content = new ContentChild();
//         ObjectSerializer::GetTypeInfo($content);
//         print "===============invoke method:  returnChild  =================\n";
//         $responseBinarydata = $ps->invoke('returnChild', array());
//         var_dump($responseBinarydata->getB());
//         var_dump($responseBinarydata->getA());
//         var_dump($responseBinarydata->getC());
//         var_dump($responseBinarydata->getLst());
//         var_dump($responseBinarydata->getContent());
//         var_dump($responseBinarydata->getTitle());
//     }

//     function testSendComplex() {
//         $ps = new ProxyStandard($this::$scfName, $this::$serviceName,self::$obj);
//         $map = array( 'zhang' => array(
//                     array('zhang' => array(array("zhang","li"))
//                 )
//             ) 
//         );
//         $value = array(
//             '1@Map<key = String, value = List<Map<key = String, value = Set<List<String>>>>>' => $map
//         );
//         $res = $ps->invoke('sendComplex', $value);
//         var_dump($res);
//     }
}
