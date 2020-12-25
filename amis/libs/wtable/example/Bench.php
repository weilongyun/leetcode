<?php
/** WTable性能测试工具
 *  php Bench.php -b bid -p passwd -h nc_ip -n req_num [-c client_num default 1] [-d data_size default 8] [-t set,get... default set] [-z z-space default false]
 *  @author spat
 *  @package WTable\Tool
 */
include_once __DIR__."/../autoload.php" ;
use WTable\client\WTableClient;
function usage(){
	die($_SERVER['argv'][0]." -b bid -p passwd -h nc_ip -n req_num [-c client_num default 1] [-d data_size default 8] [-t set,get... default set] [-z z-space default false]\n");
}



$bid = 0;
$passwd = "";
$nc_ip = "";
$req_num = -1;
$c = 1;
$test_case = "set";
$z = false;
$data_size = 8;
$table_id = 0;
$or_data = "xxxxxxxx";
$ops = getopt("b:p:h:n:c:d:t:z");
foreach ($ops as $key => $value) {
	switch($key){
		case "b" : 
			$bid = (int)$value;
			break;
		case "p" : 
			$passwd = $value;
			break;
		case "n" :
			$req_num = (int)$value;
			break;
		case "c" :
			$c = (int)$value;
			break;
		case "d" : 
			$data_size = (int)$value;
			break;
		case "t" :
			$test_case = $value;
			break;
		case "z" :
			$z = (bool)$value;
			break;
		case "h" :
			$nc_ip = $value;
			break;
		default:
			usage();
	}
}
if(0 === $bid || 0 === strcmp($passwd, "") || -1 === $req_num || 0 === strcmp($passwd, "")) {
	usage();
}
echo "bid=$bid, passwd=$passwd, namec=$nc_ip, req_num=$req_num, client=$c, data_size=$data_size, test=$test_case, zspace=$z".PHP_EOL;
if($data_size > 8) {
	for($i = 8; $i < $data_size; $i++) {
		$or_data .= 'x';
	}
}

switch($test_case) {
	case "set":
		test_set();
		break;
	case "get":
		test_get();
		break;
	default:
		usage();
}
function benchmark($op) {
	$step = $GLOBALS['req_num'] / $GLOBALS['c'];
	$start_ms = get_millsecond();
	for($i = 0; $i < $GLOBALS['c']; $i++) {
		$start = $i * $step;
		$pid = pcntl_fork();
		if(-1 === $pid){
			echo "false".PHP_EOL;
		} else if(!$pid) {
			$end = $start + $step;
			//$pid = getmypid();
			//@apcu_add("$pid",0);
			for($j = $start; $j < $end; $j++) {
				$op($j);
				//@apcu_inc("$pid");
			}
			//@apcu_store("$pid", -1);
			//child exit
			return;
		} 
		/*
		else{
			$child_pids[] = $pid;
		}*/
	}
	//parent
	$normal = true;
	/*
	while(true){
		usleep(1000000);
		$over = 0;
		$cost = 0;
		foreach($child_pids as $key => $pid){
			unset($item);
			if(false === ($item = @apcu_fetch("$pid"))){
				echo "fetch failed\n";
				continue;
			}
			if(-1 === $item){
				$over++;
				continue;
			}
			@apcu_store("$pid", 0);
			$cost += $item;
		}
		if($over >= $GLOBALS['c']){
			break;
		}
		$cost = $cost;
		echo $cost."op/s\n";
	}
	*/
	for($i = 0; $i < $GLOBALS['c']; $i++) {
		pcntl_wait($status);
		if(false === pcntl_wifexited($status)) {
			$normal = false;
		}
	}
	
	$cost = get_millsecond() - $start_ms;
	if(false === $normal) {
		echo "bench faild".PHP_EOL;
	}else {
		$speed = ($GLOBALS['req_num'] * 1000 )/ $cost;
		echo $GLOBALS['c']." clients do ".$GLOBALS['req_num']." requests cost ".$cost."ms, speed is ".$speed."op/s".PHP_EOL;
	}
}
function test_set(){
	$op = function($v) {
		$client = new WtableClient($GLOBALS['bid'], $GLOBALS['passwd'], $GLOBALS['nc_ip']);
				$client->init();
		$key = sprintf("%010u", $v);
		$row_key = substr($key, 0, 7);
		$col_key = substr($key, 7, 3);
		if($GLOBALS['z']) {
			$client->zSet($GLOBALS['table_id'], $row_key, $col_key, $GLOBALS['or_data'], $v);
		} else {
			$client->set($GLOBALS['table_id'], $row_key, $col_key, $GLOBALS['or_data'], $v);
		}
	};
	benchmark($op);
}
function test_get(){
	$op = function($v) {
		$client = new WtableClient($GLOBALS['bid'], $GLOBALS['passwd'], $GLOBALS['nc_ip']);
				$client->init();
		$key = sprintf("%010u", $v);
		$row_key = substr($key, 0, 7);
		$col_key = substr($key, 7, 3);
		if($GLOBALS['z']) {
			$client->zGet($GLOBALS['table_id'], $row_key, $col_key);
		} else {
			$client->get($GLOBALS['table_id'], $row_key, $col_key);
		}
	};
	benchmark($op);
}

function get_millsecond(){
		return (int)(1000*microtime(true));
}

function sig_handle() {
	
}
