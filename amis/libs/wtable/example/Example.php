<?php
/**WTable使用示例
 * 
 * include_once 'WTableClient.php';
 * $client = new WTable(bid, rwPass, dns);
 * $client->init();
 * $client->set(1,"row1","col1","v1",100);
 * $reply = $client->get(1,"row1", "col1");
 * print_r($reply);
 * @author spat
 * @package WTable\Example
 */
require_once __DIR__.'/../autoload.php';
use WTable\client\WTableClient;
use WTable\exception\WTableException;
use WTable\exception\WTableError;
use WTable\client\CasArgs;
use WTable\client\SetArgs;
use WTable\client\SetExArgs;
use WTable\client\GetArgs;
use WTable\client\DelArgs;
use WTable\client\IncrArgs;
use WTable\helper\ExampleLog;

echo "Welcome to Wtable</br>";

$TID = 2;  //tableId

// exampleLog : 用户可以实现helper/ILog接口来实现日志的输出，如helper/ExampleLog，并通过new WtableClient传入；
//$exampleLog = new ExampleLog("/home/work/test.log");
//根据参数构造WTable客户端，参数分别为bid, passwd, namecenter, log文件
//$client = new WtableClient(655361,"gVbFGAxqlW4xxDcB", "nametestv1.wtable.58dns.org", $exampleLog);

//根据参数构造WTable客户端,默认情况下日志文件为: ../log/wtable.log
$client = new WtableClient(655361,"gVbFGAxqlW4xxDcB", "nametestv1.wtable.58dns.org");

/* clinet初始化,默认连接超时为100ms,发送数据超时为800ms */
$client->init(); //default timeout is 800ms

/* clientc初始化，可以设置自定义的发送数超时和连接超时,单位为ms*/
//$client->init(1000,200);

//default space one-op
try {
	echo "------------default space one-op--------------\n";
	$client->set($TID,"row1","col1","value1",100);
	$reply = $client->get($TID,"row1","col1");
	echo "get:\n";
	echo "tableId=".$reply->tableId.",rowkey=".$reply->rowKey.",colkey=".$reply->colKey.",value=".$reply->value.",score=".$reply->score.",ttl=".$reply->ttl.".cas=".$reply->cas.PHP_EOL;
	echo "after incr 100:\n";
	$reply = $client->incr($TID,"row1","col1",100);
	echo "tableId=".$reply->tableId.",rowkey=".$reply->rowKey.",colkey=".$reply->colKey.",score=".$reply->score.PHP_EOL;
	echo "after del:\n";
	$client->del($TID,"row1","col1");
	$reply = $client->get($TID,"row1","col1");
	if($reply->errCode == WTableError::EcNotExist) {
		echo "errCode is EcNotExist(".$reply->errCode."), the record has been deleted!\n";
	} else {
		echo "the record has not been deleted!\n ";
	}
	//ttl
	echo "ttl example...".PHP_EOL;
	$client->setEx($TID, "row1","col1","value1",100,10);
	$reply = $client->get($TID, "row1", "col1");
	echo "before timeout get:".PHP_EOL;
	echo "tableId=".$reply->tableId.",rowkey=".$reply->rowKey.",colkey=".$reply->colKey.",value=".$reply->value.",score=".$reply->score.",ttl=".$reply->ttl.".cas=".$reply->cas.PHP_EOL;
	$client->expire($TID, "row1", "col1", 2, CasArgs::CAS_DEFAULT);
	$reply = $client->get($TID, "row1", "col1");
	echo "after expire(2) get:".PHP_EOL;
	echo "tableId=".$reply->tableId.",rowkey=".$reply->rowKey.",colkey=".$reply->colKey.",value=".$reply->value.",score=".$reply->score.",ttl=".$reply->ttl.".cas=".$reply->cas.PHP_EOL;
	sleep(3);
	$reply = $client->get($TID, "row1", "col1");
	echo "after timeout get:".PHP_EOL;
	if($reply->errCode == WTableError::EcNotExist) {
		echo "errCode is EcNotExist(".$reply->errCode."), the record is timeout!\n";
	} else {
		echo "the record is not timeout!\n ";
	}
	
} catch (WTableException $e) {
	echo $e->getFile()."(".$e->getLine()."):errCode=".$e->getCode().",message=".$e->getMessage()."\n";
}

//z space one-op
try {
	echo "------------z space one-op-------------\n";
	$client->zSet($TID,"row1","col1","value1",100);
	$reply = $client->zGet($TID,"row1","col1");
	echo "zget:\n";
	echo "tableId=".$reply->tableId.",rowkey=".$reply->rowKey.",colkey=".$reply->colKey.",value=".$reply->value.",score=".$reply->score.",ttl=".$reply->ttl.".cas=".$reply->cas.PHP_EOL;
	echo "after zincr 100:\n";
	$reply = $client->zIncr($TID,"row1","col1",100);
	echo "tableId=".$reply->tableId.",rowkey=".$reply->rowKey.",colkey=".$reply->colKey.",score=".$reply->score.PHP_EOL;
	echo "after zdel:\n";
	$client->zdel($TID,"row1","col1");
	$reply = $client->zGet($TID,"row1","col1");
	if($reply->errCode == WTableError::EcNotExist) {
		echo "errCode is EcNotExist(".$reply->errCode."), the record has been deleted!\n";
	} else {
		echo "the record has not been deleted!\n ";
	}
	//for ttl
	echo "ttl example...".PHP_EOL;
	$client->zSetEx($TID, "row1","col1","value1",100,10);
	$reply = $client->zGet($TID, "row1", "col1");
	echo "before timeout zGet:".PHP_EOL;
	echo "tableId=".$reply->tableId.",rowkey=".$reply->rowKey.",colkey=".$reply->colKey.",value=".$reply->value.",score=".$reply->score.",ttl=".$reply->ttl.".cas=".$reply->cas.PHP_EOL;
	$client->zExpire($TID, "row1", "col1", 0, CasArgs::CAS_DEFAULT);
	$reply = $client->zGet($TID, "row1", "col1");
	echo "after expire(0) zGet:".PHP_EOL;
	echo "tableId=".$reply->tableId.",rowkey=".$reply->rowKey.",colkey=".$reply->colKey.",value=".$reply->value.",score=".$reply->score.",ttl=".$reply->ttl.".cas=".$reply->cas.PHP_EOL;
	$client->zExpire($TID,"row1","col1",2, CasArgs::CAS_DEFAULT);
	echo "expire(2)...";
	sleep(3);
	$reply = $client->zGet($TID, "row1", "col1");
	echo "after timeout zGet:".PHP_EOL;
	if($reply->errCode == WTableError::EcNotExist) {
		echo "errCode is EcNotExist(".$reply->errCode."), the record is timeout!\n";
	} else {
		echo "the record is not timeout!\n ";
	}
} catch (WTableException $e) {
	echo $e->getFile()."(".$e->getLine()."):errCode=".$e->getCode().",message=".$e->getMessage()."\n";
}

//default space multi-op
try {
	echo "-----------------default space multi-op-------------------\n";
	$setArgs = array(new SetArgs($TID, "row1", "col1", "value1", 100),
		new SetArgs($TID,"row1","col2","value2",200),
		new SetArgs($TID,"row1","col3","value3",300));
	$client->mSet($setArgs);

	$getArgs = array(new GetArgs($TID,"row1","col1"),
		new GetArgs($TID,"row1","col2"),
		new GetArgs($TID,"row1","col3"),
		new GetArgs($TID,"row1","col4"));
	$reply = $client->mGet($getArgs);
	echo "mget...\n";
	for($i = 0 ; $i < count($reply); $i++){
		if($reply[$i]->errCode == WTableError::EcNotExist) {
			echo "record rowKey=".$reply[$i]->rowKey.",colKey=".$reply[$i]->colKey." is not exist!\n";
		} else {
			echo "tableId=".$reply[$i]->tableId.",rowkey=".$reply[$i]->rowKey.",colkey=".$reply[$i]->colKey.",value=".$reply[$i]->value.",score=".$reply[$i]->score.",ttl=".$reply[$i]->ttl.".cas=".$reply[$i]->cas.PHP_EOL;
		}
	}

	$incrArgs = array(new IncrArgs($TID, "row1","col1",50),
		new IncrArgs($TID, "row1","col2",50),
		new IncrArgs($TID, "row1","col3",50));
	$reply = $client->mIncr($incrArgs);
	echo "mincr...\n";
	for($i = 0; $i < count($reply);$i++) {
		echo "tableId=".$reply[$i]->tableId.",rowkey=".$reply[$i]->rowKey.",colkey=".$reply[$i]->colKey.",score=".$reply[$i]->score.PHP_EOL;
	}

	$delArgs = array(new DelArgs($TID, "row1","col1"),
		new DelArgs($TID, "row1","col2"),
		new DelArgs($TID, "row1","col3"));
	$client->mDel($delArgs);
	$reply = $client->mGet(array_slice($getArgs, 0, 3));
	echo "after mdel...\n";
	for($i = 0; $i < count($reply); $i++) {
		if($reply[$i]->errCode == WTableError::EcNotExist) {
			echo "record rowKey=".$reply[$i]->rowKey.",colKey=".$reply[$i]->colKey." has been deleted!\n";
		} else {
			echo "record rowKey=".$reply[$i]->rowKey.",colKey=".$reply[$i]->colKey." has not been deleted!\n";
		}
	}
	//ttl
	echo "ttl example\n";
	$setExArgs = array(new SetExArgs($TID, "row1", "col1", "value1", 100, 0),
		new SetExArgs($TID,"row1","col2","value2", 200, 2),
		new SetExArgs($TID,"row1","col3","value3",300, 10));
	$client->mSetEx($setExArgs);
	$reply = $client->mGet($getArgs);
	echo "before timeout mget...\n";
	for($i = 0 ; $i < count($reply); $i++){
		if($reply[$i]->errCode == WTableError::EcNotExist) {
			echo "record rowKey=".$reply[$i]->rowKey.",colKey=".$reply[$i]->colKey." is not exist!\n";
		} else {
			echo "tableId=".$reply[$i]->tableId.",rowkey=".$reply[$i]->rowKey.",colkey=".$reply[$i]->colKey.",value=".$reply[$i]->value.",score=".$reply[$i]->score.",ttl=".$reply[$i]->ttl.".cas=".$reply[$i]->cas.PHP_EOL;
		}
	}
	sleep(3);
	echo "after 3 seconds mget...\n";
	$reply = $client->mGet($getArgs);
	for($i = 0 ; $i < count($reply); $i++){
		if($reply[$i]->errCode == WTableError::EcNotExist) {
			echo "record rowKey=".$reply[$i]->rowKey.",colKey=".$reply[$i]->colKey." is not exist!\n";
		} else {
			echo "tableId=".$reply[$i]->tableId.",rowkey=".$reply[$i]->rowKey.",colkey=".$reply[$i]->colKey.",value=".$reply[$i]->value.",score=".$reply[$i]->score.",ttl=".$reply[$i]->ttl.".cas=".$reply[$i]->cas.PHP_EOL;
		}
	}
	$client->mDel($delArgs);
	
	
} catch (WTableException $e) {
	echo $e->getFile()."(".$e->getLine()."):errCode=".$e->getCode().",message=".$e->getMessage()."\n";
}

//z space multi-op
try {
	echo "------------------z space multi-op-----------------\n";
	$reply = $client->zmSet($setArgs);

	$reply = $client->zmGet($getArgs);
	echo "zmget...\n";
	for($i = 0 ; $i < count($reply); $i++){
		if($reply[$i]->errCode == WTableError::EcNotExist) {
			echo "record rowKey=".$reply[$i]->rowKey.",colKey=".$reply[$i]->colKey." is not exist!\n";
		} else {
			echo "tableId=".$reply[$i]->tableId.",rowkey=".$reply[$i]->rowKey.",colkey=".$reply[$i]->colKey.",value=".$reply[$i]->value.",score=".$reply[$i]->score.",ttl=".$reply[$i]->ttl.".cas=".$reply[$i]->cas.PHP_EOL;
		}
	}

	$reply = $client->zmIncr($incrArgs);
	echo "zmincr...\n";
	for($i = 0; $i < count($reply);$i++) {
		echo "tableId=".$reply[$i]->tableId.",rowkey=".$reply[$i]->rowKey.",colkey=".$reply[$i]->colKey.",score=".$reply[$i]->score.PHP_EOL;
	}

	$client->zmDel($delArgs);
	$reply = $client->zmGet(array_slice($getArgs, 0, 3));
	echo "after zmdel...\n";
	for($i = 0; $i < count($reply); $i++) {
		if($reply[$i]->errCode == WTableError::EcNotExist) {
			echo "record rowKey=".$reply[$i]->rowKey.",colKey=".$reply[$i]->colKey." has been deleted!\n";
		} else {
			echo "record rowKey=".$reply[$i]->rowKey.",colKey=".$reply[$i]->colKey." has not been deleted!\n";
		}
	}
	//ttl
	echo "ttl example\n";
	$reply = $client->zmSetEx($setExArgs);
	$reply = $client->zmGet($getArgs);
	echo "before timeout mget...\n";
	for($i = 0 ; $i < count($reply); $i++){
		if($reply[$i]->errCode == WTableError::EcNotExist) {
			echo "record rowKey=".$reply[$i]->rowKey.",colKey=".$reply[$i]->colKey." is not exist!\n";
		} else {
			echo "tableId=".$reply[$i]->tableId.",rowkey=".$reply[$i]->rowKey.",colkey=".$reply[$i]->colKey.",value=".$reply[$i]->value.",score=".$reply[$i]->score.",ttl=".$reply[$i]->ttl.".cas=".$reply[$i]->cas.PHP_EOL;
		}
	}
	sleep(3);
	echo "after 3 seconds mget...\n";
	$reply = $client->zmGet($getArgs);
	for($i = 0 ; $i < count($reply); $i++){
		if($reply[$i]->errCode == WTableError::EcNotExist) {
			echo "record rowKey=".$reply[$i]->rowKey.",colKey=".$reply[$i]->colKey." is not exist!\n";
		} else {
			echo "tableId=".$reply[$i]->tableId.",rowkey=".$reply[$i]->rowKey.",colkey=".$reply[$i]->colKey.",value=".$reply[$i]->value.",score=".$reply[$i]->score.",ttl=".$reply[$i]->ttl.".cas=".$reply[$i]->cas.PHP_EOL;
		}
	}
	$client->zmDel($delArgs);
} catch (WTableException $e) {
	echo $e->getFile()."(".$e->getLine()."):errCode=".$e->getCode().",message=".$e->getMessage()."\n";
}

//cas
try {
	echo "----------------cas example-----------------\n";
	$client->set($TID,"row1","col1","value1",100);
	$reply = $client->get($TID,"row1","col1",CasArgs::CAS_LOCK);
	echo "get:\n";
	echo "tableId=".$reply->tableId.",rowkey=".$reply->rowKey.",colkey=".$reply->colKey.",value=".$reply->value.",score=".$reply->score.",ttl=".$reply->ttl.".cas=".$reply->cas.PHP_EOL;
	//fail
	$client->incr($TID,"row1","col1",20);
	try {
		$reply = $client->set($TID,"row1","col1","value2",200,$reply->cas);
	}catch (WTableException $e) {
		echo "errCode=".$e->getCode().",message=".$e->getMessage()."\n";
	}
	//succ
	echo "re-get cas...\n";
	$reply = $client->get($TID,"row1","col1",CasArgs::CAS_LOCK);
	echo "tableId=".$reply->tableId.",rowkey=".$reply->rowKey.",colkey=".$reply->colKey.",value=".$reply->value.",score=".$reply->score.",ttl=".$reply->ttl.".cas=".$reply->cas.PHP_EOL;
	$client->set($TID,"row1","col1","value2",200,$reply->cas);
	echo "change succ by new cas $reply->cas ...\n";
	$client->del($TID,"row1","col1");
} catch (WTableException $e) {
	echo $e->getFile()."(".$e->getLine()."):errCode=".$e->getCode().",message=".$e->getMessage()."\n";
}

//scan
try {
	echo "----------------scan---------------\n";
	$setExArgs = array(new SetExArgs($TID, "row1", "col1", "value1", 100, 0),
		new SetExArgs($TID,"row1","col2","value2", 200, 2),
		new SetExArgs($TID,"row1","col3","value3",300, 2),
		new SetExArgs($TID,"row1","col4","value4", 400, 2),
		new SetExArgs($TID,"row1","col5","value5", 500, 10));
	$client->mSetEx($setExArgs);
	sleep(3);
	$reply = $client->scan($TID,"row1",true,2);
	while(true){
		for($i = 0; $i < count($reply->kvs); $i++){
			echo "tableId=".$reply->tableId.",rowKey=".$reply->rowKey.",colKey=".$reply->kvs[$i]->colKey.",value=".$reply->kvs[$i]->value.",score=".$reply->kvs[$i]->score.",ttl=".$reply->kvs[$i]->ttl."\n";
		}
		if($reply->end){
			break;
		}
		$reply = $client->scanMore($reply);
	}
} catch (WTableException $e) {
	echo $e->getFile()."(".$e->getLine()."):errCode=".$e->getCode().",message=".$e->getMessage()."\n";
}

//zscan
try {
	echo "----------------zscan------------------\n";
	$client->zmSetEx($setExArgs);
	sleep(3);
	$reply = $client->zScan($TID,"row1",false,true,2);
	while(true){
		for($i = 0; $i < count($reply->kvs); $i++){
			echo "tableId=".$reply->tableId.",rowKey=".$reply->rowKey.",colKey=".$reply->kvs[$i]->colKey.",value=".$reply->kvs[$i]->value.",score=".$reply->kvs[$i]->score.",ttl=".$reply->kvs[$i]->ttl."\n";
		}
		if($reply->end){
			break;
		}
		$reply = $client->scanMore($reply);
	}
} catch (WTableException $e) {
	echo $e->getFile()."(".$e->getLine()."):errCode=".$e->getCode().",message=".$e->getMessage()."\n";
}

return;

//dumpDB
try {
	echo "---------------dump db------------------\n";
	$reply = $client->dumpDB();
	while(true){
		for($i = 0; $i < count($reply->kvs); $i++){
			$kv = $reply->kvs[$i];
			echo "tableId=".$kv->tableId.",colspace=".$kv->colSpace.",rowKey=".$kv->rowKey.",colKey=".$kv->colKey.",value=".$kv->value.",score=".$kv->score.",ttl=".$reply->kvs[$i]->ttl."\n";
		}
		if($reply->end){
			break;
		}
		$reply = $client->dumpMore($reply);
	}
} catch (WTableException $e) {
	echo $e->getFile()."(".$e->getLine()."):errCode=".$e->getCode().",message=".$e->getMessage()."\n";
}

//dumpTable
try {
	echo "--------------dump table----------------\n";
	$reply = $client->dumpTable($TID);
	while(true){
		for($i = 0; $i < count($reply->kvs); $i++){
			$kv = $reply->kvs[$i];
			echo "tableId=".$kv->tableId.",colspace=".$kv->colSpace.",rowKey=".$kv->rowKey.",colKey=".$kv->colKey.",value=".$kv->value.",score=".$kv->score.",ttl=".$reply->kvs[$i]->ttl."\n";
		}
		if($reply->end){
			break;
		}
		$reply = $client->dumpMore($reply);
	}
} catch (WTableException $e) {
	echo $e->getFile()."(".$e->getLine()."):errCode=".$e->getCode().",message=".$e->getMessage()."\n";
}

