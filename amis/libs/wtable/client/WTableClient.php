<?php
namespace WTable\client;
use WTable\net\CliRep;
use WTable\protocal\Protocal;
use WTable\protocal\PkgOneOp;
use WTable\protocal\PkgMultiOp;
use WTable\protocal\PkgDumpResp;
use WTable\exception\WTableInnerError;
use WTable\exception\WTableException;
use WTable\exception\WTableError;
use WTable\helper\InnerLog;
/**
 *    WTable客户端是用于对WTable数据库进行操作的客户端入口。<br>
 * 
 * <br>
 *    通过new WTableClient,并传入bid，passwd和dns创建一个客户端对象<br>
 * 并通过调用init函数完成客户端的初始化工作。<br>
 * 可以通过不同的path获取多个WTable客户端实例，连接多个WTable Server端。<br>
 * 
 * <br>
 *     wtable乐观锁支持说明：<br>
 *     乐观锁(CAS)：对于某个key，支持在其指定版本上执行修改，若其版本已经变化则修改失败，客户端可以重新获取最新版本再次尝试修改。 <br>
 *     乐观锁执行过程分成两个步骤： <br>
 *   1）使用CasArgs::CAS_LOCK参数调用带有Cas参数的get类函数，返回的GetReply对象具有一个cas值，表示该key的当前版本号。 <br>
 *   ***注意：get函数返回的cas值在5~10秒之后失效***。 <br>
 *   2）使用从get中返回的cas调用带有cas参数的set函数，若执行成功则保证是在get返回的版本上进行的修改。 <br>
 *     例如：<br>
 *   $reply = $client->get(tabId,rowKey,colKey,CasArgs::CAS_LOCK);<br>
 *   通过$reply->cas就可以获取到服务器返回的该key的版本号。<br>
 *   $client->set(tabId,rowKey,colKey,value,$reply->cas); <br>
 *   ***注意：由于复杂度等问题，请不要在在批量操作下使用CAS乐观锁；即在mGet,mZGet函数中不要使用CasArgs::CAS_Lock***<br>
 * 
 * <br>
 *     CAS取值说明（在读操作函数与写操作函数中有所不同）：<br>
 *   1）在get（等读操作函数）中，cas可以有如下三个值。<br>
 *      CasArgs::CAS_DEFAULT  请求随机发往Master或Slave，可能读取到旧数据，性能较好，通常Master与Slave同步非常快，因此读取到旧数据概率非常低。<br>
 *      CasArgs::CAS_MASTER 请求只发送到Master，能够读取到最新的值，若非必要请使用Cas.DEFAULT以减少Master服务器压力。<br>
 *      CasArgs::CAS_LOCK 请求只发送到Master，并且服务器会返回该Key的当前版本号，可以通过Reply::getCas()函数获取cas版本号，这个值可以传递给写操作函数使用，若非必要请尽量使用DEFAULT以减少服务器压力。<br>
 *   2）在set（等写操作函数）之中，cas的值可以有如下两种:<br>
 *      0 : 表示直接写，不进行版本判断。<br>
 * >=1000 : 该值应该是由带CasArgs::CAS_LOCK标记的get函数返回的cas值（不能自己设置，必须是服务器返回），服务器会判断
 *      key的当前版本号必须等于该值才修改，否则返回失败。<br>
 * 
 * <br>
 *     wtable内部数据空间说明：<br>
 *   wtable支持两种数据空间，默认空间(使用get、set、scan等函数)，Z空间(使用zGet、zSet、zScan等函数) 。<br>
 * 数据维度从大到小依次是，集群id（cid），数据库id（dbid），表id（tableId），行键（rowKey），列键（colKey）。<br>
 * 每个列键下可以保存两个值：value和score，value可以为空最大256KB，score为int64默认为0。<br>
 * 在同一个表id下可以有很多的rowKey，同一个rowKey可以有很多的colKey。<br>
 * 
 * <br>
 *     默认空间与Z空间的区别：<br>
 *  默认空间：数据存储一份，按照colKey排序，scan函数按照这个顺序返回。<br>
 *  Z空间：数据存储两份，分别按照colKey排序与score+colKey排序，zScan函数可以指定排序顺序，占用空间为默认空间的两倍。<br>
 *   注意：默认空间虽然不能按照score排序，但是每个colKey也可以存储score值；。<br>
 *   **操作函数区别：所有带z开头的函数都是操作Z空间，不带z开头的函数都是操作默认空间**。<br>
 * 
 * <br>
 *     默认空间与Z空间互相隔离。<br>
 *   由于默认空间与Z空间存储互相隔离，因此相同tableId+rowKey+colKey在默认空间与Z空间的存储并不会互相干扰。<br>
 *   如：set(tabId,rowKey,colKey,setValue,100); 产生一条默认空间的记录；<br>
 *   zSet(tabId,rowKey,colKey,zSetValue,200); 产生一条Z空间的记录，这两条记录共存并不会互相干扰。<br>
 * 
 * <b><br>
 *     WTable性能指标，最佳实践等其他更详细信息请参考Wiki。<br>
 * @link http://wiki.58corp.com/index.php?title=WTable
 * 
 * @author spat
 * @package WTable\client
 */
class WTableClient{
	const EMPTYSTR='';
	const DEFAULT_TIMEOUT = 800;
	const DEFAULT_CONN_TIMEOUT = 100;
	const MAX_PROXY_CON_NUM = 3;
	private $bid;
	private $password;
	private $dns;
	private $rep;
	private $isInited;
	private $hosts;
	private $proxyHosts;
	/** Construct
	 *  @param int bid WTable团队分配的bid.
	 *  @param str passwd bid对应的读写密码或只读密码.
	 *  @param str dns 分配的DNS地址.
	 */
	public function __Construct($bid ,$passwd ,$dns , $log=NULL){
		$this->bid = $bid;
		$this->password =$passwd;
		$this->dns=$dns;
		$this->rep=new CliRep($bid,$passwd,$dns);
		$this->isInited=false;
		if ($log !== NULL) {
		    InnerLog::setLog($log);
		}
	}
	/** 客户端初始化函数.
	 *  @param int timeout 收发等待的超时时间，单位ms，默认800ms,连接超时默认100ms
	 */
	public function init($timeout=self::DEFAULT_TIMEOUT, $connTimeout=self::DEFAULT_CONN_TIMEOUT){
		if($this->isInited){
			throw new WTableException("client init again!", WTableInnerError::IEcInitAgain);
	   	}
		$this->isInited = true;
		if ($this->rep === Null || $this->rep->net === NULL) {
			throw new WTableException("client init input error!", WTableInnerError::IEcInitArgsError);
		}
		
		$this->rep->setTimeout($timeout);
		$this->rep->setConnTimeout($connTimeout);
		$this->rep->init();
	}
	private function getErrCode($err, $base) {
		if ($err > WTableInnerError::EcInnerStart) {
			return $err;
		} else {
			return $base + $err;
		}
	}
	/** 测试服务是否可用.
	 *  @throws WTableException 错误码定义请参考WTable\exception\WTableError.
	 */
	public function ping(){
		$reply = $this->rep->doOneOp($this->rep->net, false, Protocal::CmdPing, 0, self::EMPTYSTR, self::EMPTYSTR, self::EMPTYSTR, 0, 0, CasArgs::CAS_DEFAULT);
		PkgOneOp::formatRespOneOp($reply);
	}
	/**查询默认空间中关键字为tableId+rowKey+colKey的数据。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param int tableId 表ID，允许值范围 [0 ~ 9] 
	 * @param str rowKey 行键值， 允许长度 [1 ~ 255] 
	 * @param str colKey 列键值， 允许长度 [0 ~ 8KB] 
	 * @param CasArgs cas CasArgs::CAS_DEFAULT 随机到Master、Slave读取，性能好，有很低的概率可能读取到旧数据（通常Master、Slave同步非常快）; <br>
	 * CasArgs::CAS_MASTER 请求只发往主库，能读取到最新值；CasArgs::CAS_LOCK 请求只发往主库，且返回key的版本号CAS，该CAS可以用于在set函数中指定版本号（请参考set函数说明）<br>
	 * @return GetReply $reply->errCode=WTableError::EcNotExist时为值不存在
	 * @throws WTableException错误码的定义请参考WTable\exception\WTableError\WTableError
	 */
	public function get($tableId,$rowKey,$colKey,$cas = CasArgs::CAS_DEFAULT){
		if(!is_int($tableId) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcGetFail);
		}
		$dwCas = ($cas===Null) ? CasArgs::CAS_DEFAULT : $cas;
		$reply = $this->rep->doOneOp($this->rep->net, false, Protocal::CmdGet, $tableId, $rowKey, $colKey, Null, 0, 0, $dwCas);
		return PkgOneOp::formatRespOneOp($reply);
	}
	/**查询z空间中关键字为tableId+rowKey+colKey的数据。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值，允许长度 [1 ~ 255]
	 * @param str colKey 列键值，允许长度 [0 ~ 8KB]
	 * @param CasArgs cas CasArgs::CAS_DEFAULT 随机到Master、Slave读取，性能好，有很低的概率可能读取到旧数据（通常Master、Slave同步非常快）; 
	 * CasArgs::CAS_MASTER 请求只发往主库，能读取到最新值；CasArgs::CAS_LOCK 请求只发往主库，且返回key的版本号CAS，该CAS可以用于在set函数中指定版本号（请参考set函数说明）
	 * @return GetReply $reply->errCode = WTableError::EcNotExist 时为值不存在
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError\WTableError
	 */
	public function zGet($tableId,$rowKey,$colKey,$cas = CasArgs::CAS_DEFAULT){
		if(!is_int($tableId) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcZGetFail);
		}
		$dwCas = ($cas===Null)? 0:$cas;
		$reply = $this->rep->doOneOp($this->rep->net, true, Protocal::CmdGet, $tableId, $rowKey, $colKey, Null, 0, 0, $dwCas);
		return PkgOneOp::formatRespOneOp($reply);
	}
	/**
	 * 设置一个值到默认空间之中，关键字为tableId+rowKey+colKey。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 *
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值，允许长度 [1 ~ 255]
	 * @param str colKey 列键值，允许长度 [0 ~ 8KB]
	 * @param str value 值， 允许长度 [0 ~ 256KB]
	 * @param longlong score 分值
	 * @param int cas 取值0表示总是修改，>0表示只有key对应的版本号为cas时才修改（key的cas值可通过get函数获取）
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError\WTableError
	 */
	public function set($tableId,$rowKey,$colKey,$value,$score,$cas = 0){
		$this->setEx($tableId,$rowKey,$colKey,$value,$score,0,$cas);
	}
	/**
	 * 设置一个值到z空间之中，关键字为tableId+rowKey+colKey。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 *
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值，允许长度 [1 ~ 255]
	 * @param str colKey 列键值，允许长度 [0 ~ 8KB]
	 * @param str value 值， 允许长度 [0 ~ 256KB]
	 * @param longlong score 分值
	 * @param int cas 取值0表示总是修改，>0表示只有key对应的版本号为cas时才修改（key的cas值可通过get函数获取）
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError\WTableError
	 */
	public function zSet($tableId,$rowKey,$colKey,$value,$score,$cas = 0){
		$this->zSetEx($tableId,$rowKey,$colKey,$value,$score,0,$cas);
	}
	/**
	 * 设置一个带有TTL的值到默认空间之中，关键字为tableId+rowKey+colKey。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 *
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值，允许长度 [1 ~ 255]
	 * @param str colKey 列键值，允许长度 [0 ~ 8KB]
	 * @param str value 值， 允许长度 [0 ~ 256KB]
	 * @param longlong score 分值
	 * @param int ttl 记录存在的生命周期，单位为秒，ttl=0时等同set
	 * @param int cas 取值0表示总是修改，>0表示只有key对应的版本号为cas时才修改（key的cas值可通过get函数获取）
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError\WTableError
	 */
	public function setEx($tableId,$rowKey,$colKey,$value,$score,$ttl,$cas = 0){
		if(!is_int($tableId) || !is_int($score) || !is_int($ttl) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcSetFail);
		}
		if($ttl < 0) {
			WTableError::getException(WTableError::EcInvTTL);
		}else if($ttl > 0) {
			$ttl += time();
		}
		$reply = $this->rep->doOneOp($this->rep->net, false, Protocal::CmdSet, $tableId, $rowKey, $colKey, $value, $score, $ttl, $cas);
		PkgOneOp::formatRespOneOp($reply);
	}
	/**
	 * 设置一个带有TTL的值到z空间之中，关键字为tableId+rowKey+colKey。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 *
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值，允许长度 [1 ~ 255]
	 * @param str colKey 列键值，允许长度 [0 ~ 8KB]
	 * @param str value 值， 允许长度 [0 ~ 256KB]
	 * @param longlong score 分值
	 * @param int ttl 记录存在的生命周期，单位为秒，ttl=0时等同set
	 * @param int cas 取值0表示总是修改，>0表示只有key对应的版本号为cas时才修改（key的cas值可通过get函数获取）
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function zSetEx($tableId,$rowKey,$colKey,$value,$score,$ttl,$cas = 0){
		if(!is_int($tableId) || !is_int($score) || !is_int($ttl) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcZSetFail);
		}
		if($ttl < 0) {
			WTableError::getException(WTableError::EcInvTTL);
		}else if($ttl > 0) {
			$ttl += time();
		}
		$reply = $this->rep->doOneOp($this->rep->net, true, Protocal::CmdSet, $tableId, $rowKey, $colKey, $value, $score, $ttl, $cas);
		PkgOneOp::formatRespOneOp($reply);
	}
	/**
	 * 删除默认空间关键字为tableId+rowKey+colKey的数据。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值，允许长度 [1 ~ 255]
	 * @param str colKey 列键值，允许长度 [0 ~ 8KB]
	 * @param int cas 取值0则直接删除，>0表示只有key对应的版本号为cas时才删除（key的cas值可通过get函数获取）,默认值是0
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function del($tableId,$rowKey,$colKey,$cas = 0){
		if(!is_int($tableId) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcDelFail);
		}
		$reply = $this->rep->doOneOp($this->rep->net, false, Protocal::CmdDel, $tableId, $rowKey,$colKey,Null,Null, 0, $cas);
		PkgOneOp::formatRespOneOp($reply);
	}
	/**
	 * 删除z空间关键字为tableId+rowKey+colKey的数据。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值，允许长度 [1 ~ 255]
	 * @param str colKey 列键值，允许长度 [0 ~ 8KB]	
	 * @param int cas 取值0则直接删除，>0表示只有key对应的版本号为cas时才删除（key的cas值可通过get函数获取）,默认值是0
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function zDel($tableId,$rowKey,$colKey,$cas = 0){
		if(!is_int($tableId) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcZDelFail);
		}
		$reply = $this->rep->doOneOp($this->rep->net, true, Protocal::CmdDel, $tableId, $rowKey,$colKey,Null,Null, 0, $cas);
		PkgOneOp::formatRespOneOp($reply);
	}
	/**
	 * 修改默认空间关键字为tableId+rowKey+colKey数据的score值。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值，允许长度 [1 ~ 255]
	 * @param str colKey 列键值，允许长度 [0 ~ 8KB]
	 * @param longlong score 分数的修改值，>0则原来score加上该值，<0则原来score减去该值
	 * @param int cas get返回的cas
	 * @return IncrReply 返回修改后的值
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function incr($tableId,$rowKey,$colKey,$score,$cas = 0){
		if(!is_int($tableId) || !is_int($score) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcIncrFail);
		}
		$reply = $this->rep->doOneOp($this->rep->net, false, Protocal::CmdIncr, $tableId, $rowKey,$colKey,Null,$score, 0, $cas);
		return PkgOneOp::formatRespOneOp($reply);
	}
	/**
	 * 修改z空间关键字为tableId+rowKey+colKey数据的score值。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值， 允许长度 [1 ~ 255]
	 * @param str colKey 列键值， 允许长度 [0 ~ 8KB]
	 * @param longlong score 分数的修改值，>0则原来score加上该值，<0则原来score减去该值
	 * @param int cas get返回的cas.
	 * @return IncrReply 返回修改后的值
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function zIncr($tableId,$rowKey,$colKey,$score,$cas = 0){
		if(!is_int($tableId) || !is_int($score) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcZIncrFail);
		}
		$reply = $this->rep->doOneOp($this->rep->net, true, Protocal::CmdIncr, $tableId, $rowKey,$colKey,Null,$score, 0, $cas);
		return PkgOneOp::formatRespOneOp($reply);
	}
	/**
	 * 在默认空间之中，修改关键字为tableId+rowKey+colKey的记录的ttl。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 *
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值，允许长度 [1 ~ 255]
	 * @param str colKey 列键值，允许长度 [0 ~ 8KB]
	 * @param int ttl time-to-live，单位为秒，ttl为0时清除已有的超时时间。
	 * @param int cas cas=0表示总是修改，>0表示只有key对应的版本号为cas时才修改（key的cas值可通过zGet函数获取）
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function expire($tableId, $rowKey, $colKey, $ttl, $cas) {
		if(!is_int($tableId) || !is_int($ttl) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcExpireFail);
		}
		if ($ttl < 0) {
			WTableError::getException(WTableError::EcInvTTL);
		} else if($ttl > 0) {
			$ttl += time();
		}
		$reply = $this->rep->doOneOp($this->rep->net, false, Protocal::CmdExpire, $tableId,
				$rowKey, $colKey, Null, 0, $ttl, $cas);
		PkgOneOp::formatRespOneOp($reply);
	}
	/**
	 * 在z空间之中，修改关键字为tableId+rowKey+colKey的记录的ttl。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * WTable支持乐观锁，详情请参考WtableClient类说明。<br>
	 *
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值，允许长度 [1 ~ 255]
	 * @param str colKey 列键值，允许长度 [0 ~ 8KB]
	 * @param int ttl time-to-live，单位为秒，ttl为0时清除已有的超时时间。
	 * @param int cas =0表示总是修改，>0表示只有key对应的版本号为cas时才修改（key的cas值可通过zGet函数获取）
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function zExpire($tableId, $rowKey, $colKey, $ttl, $cas) {
		if(!is_int($tableId) || !is_int($ttl) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcZExpireFail);
		}
		if ($ttl < 0) {
			WTableError::getException(WTableError::EcInvTTL);
		} else if($ttl > 0) {
			$ttl += time();
		}
		$reply = $this->rep->doOneOp($this->rep->net, true, Protocal::CmdExpire, $tableId,
				$rowKey, $colKey, Null, 0, $ttl, $cas);
		PkgOneOp::formatRespOneOp($reply);
	}
	//check multi-op input args if is right
	private static function checkMultiInput($args, $className){
		$check = function($v, $cName) {
			$cName = "WTable\client\\".$cName;
			return $v instanceof $cName;
		};
		for($i = 0; $i < count($args); $i++) {
			if(false === $check($args[$i], $className)) {
				return false;
			}
		}
		return true;
	}
	/**
	 * 以批量方式查询默认空间，一次批量操作上限为100。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 得到结果后，请逐个遍历每条记录的ErrorCode，以判断是否有部分请求失败。
	 * 只有当List中所有记录的结果都出现异常时，才会抛出异常。<br>
	 * 注意：请求包与返回包都不能超过2MB，超过将返回错误。<br>
	 * 批量操作请不要使用CAS乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param array args GetArgs的数组,参见WTable\Args
	 * @return array(GetReply) 查询到的列表
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function mGet($args) {
		if(count($args) < 1) {
			return array();
		}
		if(false === self::checkMultiInput($args, "GetArgs")) {
			throw new WTableException("mGet input not GetArgs!", WTableInnerError::IEcMGetFail);
		}
		$reply = $this->rep->doMultiOp($this->rep->net,false,Protocal::CmdMGet,$args);
		return PkgMultiOp::formatRespMultiOp($reply);
	}
	/**
	 * 以批量方式设置默认空间，一次批量操作上限为100。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 得到结果后，请逐个遍历每条记录的ErrorCode，以判断是否有部分请求失败。
	 * 只有当List中所有记录的结果都出现异常时，才会抛出异常。<br>
	 * 注意：请求包与返回包都不能超过2MB，超过将返回错误。<br>
	 * 批量操作请不要使用CAS乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param array args SetArgs类型的数组,参见WTable\Args
	 * @return array(SetReply)
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function mSet($args) {
		if(count($args) < 1) {
			return array();
		}
		if(false === self::checkMultiInput($args, "SetArgs")) {
			throw new WTableException("mSet input not SetArgs!", WTableInnerError::IEcMSetFail);
		}
		$reply = $this->rep->doMultiOp($this->rep->net,false,Protocal::CmdMSet,$args);
		return PkgMultiOp::formatRespMultiOp($reply);
	}
	/**
	 * 以批量方式设置默认空间，一次批量操作上限为100。<br>
	 * 允许设置记录的ttl，单位为秒，ttl为0表示不设置超时时间。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 得到结果后，请逐个遍历每条记录的ErrorCode，以判断是否有部分请求失败。
	 * 只有当List中所有记录的结果都出现异常时，才会抛出异常。<br>
	 * 注意：请求包与返回包都不能超过2MB，超过将返回错误。<br>
	 * 批量操作请不要使用CAS乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param array args SetExArgs类型的数组,参见WTable\Args
	 * @return array(SetReply)
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function mSetEx($args) {
		if(count($args) < 1) {
			return array();
		}
		if(false === self::checkMultiInput($args, "SetExArgs")) {
			throw new WTableException("mSetEx input not SetExArgs!", WTableInnerError::IEcMSetFail);
		}
		$tmp = self::multi2Timestamp($args);
		$reply = $this->rep->doMultiOp($this->rep->net, false, Protocal::CmdMSet, $tmp);
		return PkgMultiOp::formatRespMultiOp($reply);
	}
	/**
	 * 批量修改默认空间数据的分值,一次批量操作上限为100。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 得到结果后，请逐个遍历每条记录的ErrorCode，以判断是否有部分请求失败。
	 * 只有当List中所有记录的结果都出现异常时，才会抛出异常。<br>
	 * 注意：请求包与返回包都不能超过2MB，超过将返回错误。<br>
	 * 批量操作请不要使用CAS乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param array args IncrArgs类型的数组,参见WTable\Args
	 * @return array(IncrReply) IncrReply表示修改后的值
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function mIncr($args){
		if(count($args) < 1) {
			return array();
		}
		if(false === self::checkMultiInput($args, "IncrArgs")) {
			throw new WTableException("mIncr input not IncrArgs!", WTableInnerError::IEcMIncrFail);
		}
		$reply = $this->rep->doMultiOp($this->rep->net,false,Protocal::CmdMIncr,$args);
		return PkgMultiOp::formatRespMultiOp($reply);
	}
	/**
	 * 批量删除默认空间数据，一次批量操作上限为100。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 得到结果后，请逐个遍历每条记录的ErrorCode，以判断是否有部分请求失败。
	 * 只有当List中所有记录的结果都出现异常时，才会抛出异常。<br>
	 * 注意：请求包与返回包都不能超过2MB，超过将返回错误。<br>
	 * 批量操作请不要使用CAS乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param array args DelArgs的数组,参见WTable\Args
	 * @return array(IncrReply)
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function mDel($args){
		if(count($args) < 1) {
			return array();
		}
		if(false === self::checkMultiInput($args, "DelArgs")) {
			throw new WTableException("mDel input not DelArgs!", WTableInnerError::IEcMDelFail);
		}
		$reply = $this->rep->doMultiOp($this->rep->net,false,Protocal::CmdMDel,$args);
		return PkgMultiOp::formatRespMultiOp($reply);
	}
	//multi-change ttl to timestamp
	private static function multi2Timestamp($args) {
		$ret = array();
		$now = time();
		foreach($args as $elem) {
			$item = clone $elem;
			if($item->ttl < 0){
				WTableError::getException(WTableError::EcInvTTL);
			}else if($item->ttl > 0) {
				$item->ttl += $now;
			}
			$ret[] = $item;
		}
		return $ret;
	}
	
	/**
	 * 以批量方式查询z空间，一次批量操作上限为100。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 得到结果后，请逐个遍历每条记录的ErrorCode，以判断是否有部分请求失败。
	 * 只有当List中所有记录的结果都出现异常时，才会抛出异常。<br>
	 * 注意：请求包与返回包都不能超过2MB，超过将返回错误。<br>
	 * 批量操作请不要使用CAS乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param array args GetArgs类型的数组,参见WTable\Args
	 * @return array(GetReply) 查询到的列表
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function zmGet($args){
		if(count($args) < 1) {
			return array();
		}
		if(false === self::checkMultiInput($args, "GetArgs")) {
			throw new WTableException("zmGet input not GetArgs!", WTableInnerError::IEcMGetFail);
		}
		$reply = $this->rep->doMultiOp($this->rep->net,true,Protocal::CmdMGet,$args);
		return PkgMultiOp::formatRespMultiOp($reply);
	}
	/**
	 * 以批量方式设置z空间，一次批量操作上限为100。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 得到结果后，请逐个遍历每条记录的ErrorCode，以判断是否有部分请求失败。
	 * 只有当List中所有记录的结果都出现异常时，才会抛出异常。<br>
	 * 注意：请求包与返回包都不能超过2MB，超过将返回错误。<br>
	 * 批量操作请不要使用CAS乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param array args SetArgs的数组,参见WTable\Args
	 * @return array(SetReply)
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function zmSet($args){
		if(count($args) < 1) {
			return array();
		}
		if(false === self::checkMultiInput($args, "SetArgs")) {
			throw new WTableException("zmSet input not SetArgs!", WTableInnerError::IEcMSetFail);
		}
		$reply = $this->rep->doMultiOp($this->rep->net,true,Protocal::CmdMSet,$args);
		return PkgMultiOp::formatRespMultiOp($reply);
	}
	/**
	 * 以批量方式设置z空间，一次批量操作上限为100。<br>
	 * 允许设置记录的ttl，单位为秒，ttl为0表示不设置超时时间。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 得到结果后，请逐个遍历每条记录的ErrorCode，以判断是否有部分请求失败。
	 * 只有当List中所有记录的结果都出现异常时，才会抛出异常。<br>
	 * 注意：请求包与返回包都不能超过2MB，超过将返回错误。<br>
	 * 批量操作请不要使用CAS乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param array args SetExArgs的数组,参见WTable\Args
	 * @return array(SetReply)
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function zmSetEx($args) {
		if(count($args) < 1) {
			return array();
		}
		if(false === self::checkMultiInput($args, "SetExArgs")) {
			throw new WTableException("zmSetEx input not SetExArgs!", WTableInnerError::IEcMSetFail);
		}
		$tmp = self::multi2Timestamp($args);
		$reply = $this->rep->doMultiOp($this->rep->net, true, Protocal::CmdMSet, $tmp);
		return PkgMultiOp::formatRespMultiOp($reply);
	}
	/**
	 * 批量修改z空间数据的分值,一次批量操作上限为100。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 得到结果后，请逐个遍历每条记录的ErrorCode，以判断是否有部分请求失败。
	 * 只有当List中所有记录的结果都出现异常时，才会抛出异常。<br>
	 * 注意：请求包与返回包都不能超过2MB，超过将返回错误。<br>
	 * 批量操作请不要使用CAS乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param array args IncrArgs类型的数组,参见WTable\Args
	 * @return array(IncrReply) IncrReply表示修改后的值
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function zmIncr($args){
		if(count($args) < 1) {
			return array();
		}
		if(false === self::checkMultiInput($args, "IncrArgs")) {
			throw new WTableException("zmIncr input not IncrArgs!", WTableInnerError::IEcMIncrFail);
		}
		$reply= $this->rep->doMultiOp($this->rep->net,true,Protocal::CmdMIncr,$args);
		return PkgMultiOp::formatRespMultiOp($reply);
	}
	/**
	 * 批量删除z空间数据，一次批量操作上限为100。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 得到结果后，请逐个遍历每条记录的ErrorCode，以判断是否有部分请求失败。
	 * 只有当List中所有记录的结果都出现异常时，才会抛出异常。<br>
	 * 注意：请求包与返回包都不能超过2MB，超过将返回错误。<br>
	 * 批量操作请不要使用CAS乐观锁，详情请参考WtableClient类说明。<br>
	 * 
	 * @param array args DelArgs类型的数组,参见WTable\Args
	 * @return array(IncrReply)
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function zmDel($args){
		if(count($args) < 1) {
			return array();
		}
		if(false === self::checkMultiInput($args, "DelArgs")) {
			throw new WTableException("zmDel input not DelArgs!", WTableInnerError::IEcMDelFail);
		}
		$reply = $this->rep->doMultiOp($this->rep->net,true,Protocal::CmdMDel,$args);
		return PkgMultiOp::formatRespMultiOp($reply);
	}
	/**
	 * 扫描默认空间某个rowKey的数据。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 返回的记录条数由下列四个值的最小值决定：真实数据记录数，num参数，最大10000条记录限制，返回包达到1MB时的记录数，这四个值任何一个达到即返回
	 * 由于scan是一个相对耗时的操作，请不要太频繁执行以免影响到其他业务正常使用。<br>
	 * 
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值， 允许长度 [1 ~ 255]
	 * @param bool asc 排序方式
	 * @param int num 查询数量，建议小于1000，越小越好，值太大可能影响服务器响应速度。
	 * @return ScanReply 参见WTable\Args
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function scan($tableId, $rowKey, $asc=true, $num=100){
		if(!is_int($tableId) || !is_int($num) || !is_bool($asc)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcScanFail);
		}
		$reply = $this->rep->doScan($this->rep->net, false, $tableId, $rowKey, '',0, true, $asc, false, $num);
		return PkgMultiOp::formatRespScan($reply, $tableId, $rowKey, $num, false, $asc, false);
	}
	/**
	 * 扫描Z空间某个rowKey的数据。<br>
	 * 关于Z空间的详细信息请参考WtableClient类说明。<br>
	 * 返回的记录条数由下列四个值的最小值决定：真实数据记录数，num参数，最大10000条记录限制，返回包达到1MB时的记录数，这四个值任何一个达到即返回
	 * 由于scan是一个相对耗时的操作，请不要太频繁执行以免影响到其他业务正常使用。<br>
	 * 
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值， 允许长度 [1 ~ 255]
	 * @param bool asc 排序方式
	 * @param bool orderByScore 是否按照score排序，true表示按照score+colKey排序，false表示按照colKey排序
	 * @param int num 查询数量，建议小于1000，越小越好，值太大可能影响服务器响应速度。
	 * @return ScanReply 参见WTable\Args
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function zScan($tableId, $rowKey, $asc=true, $orderByScore, $num){
		if(!is_int($tableId) || !is_int($num) || !is_bool($asc) || !is_bool($orderByScore)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcZScanFail);
		}
		$reply = $this->rep->doScan($this->rep->net, true, $tableId, $rowKey, '',0, true, $asc, $orderByScore, $num);
		return PkgMultiOp::formatRespScan($reply, $tableId, $rowKey, $num, true, $asc, $orderByScore);
	}
	/**
	 * 扫描Z空间某个rowKey的数据，从指定的colKey或者score+colKey开始。<br>
	 * 关于Z空间的详细信息请参考WtableClient类说明。<br>
	 * 返回的记录条数由下列四个值的最小值决定：真实数据记录数，num参数，最大10000条记录限制，返回包达到1MB时的记录数，这四个值任何一个达到即返回
	 * 由于scan是一个相对耗时的操作，请不要太频繁执行以免影响到其他业务正常使用。<br>
	 * 
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值， 允许长度 [1 ~ 255]
	 * @param str colKey 列键值， 允许长度 [0 ~ 8KB]
	 * @param longlong score 制定的score值
	 * @param bool asc 排序方式
	 * @param bool orderByScore 是否按照score排序，true表示按照score+colKey排序，false表示按照colKey排序
	 * @param int num 查询数量，建议小于1000，越小越好，值太大可能影响服务器响应速度。
	 * @return ScanReply 参见WTable\Args
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function zScanPivot($tableId, $rowKey, $colKey, $score, $asc, $orderByScore, $num){
		if(!is_int($tableId) || !is_int($num) || !is_int($score) || !is_bool($asc) || !is_bool($orderByScore)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcZScanPivotFail);
		}
		$reply = $this->rep->doScan($this->rep->net, true, $tableId, $rowKey, $colKey,$score, false, $asc, $orderByScore, $num);
		return PkgMultiOp::formatRespScan($reply, $tableId, $rowKey, $num, true, $asc, $orderByScore);
	}
	/**
	 * 扫描默认空间某个rowKey的数据，从指定的colKey开始扫描。<br>
	 * 关于默认空间的详细信息请参考WtableClient类说明。<br>
	 * 返回的记录条数由下列四个值的最小值决定：真实数据记录数，num参数，最大10000条记录限制，返回包达到1MB时的记录数，这四个值任何一个达到即返回
	 * 由于scan是一个相对耗时的操作，请不要太频繁执行以免影响到其他业务正常使用。<br>
	 * 
	 * 单次扫描 不要大于1000
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @param str rowKey 行键值， 允许长度 [1 ~ 255]
	 * @param str colKey 列键值， 允许长度 [0 ~ 8KB]
	 * @param bool asc 排序方式
	 * @param int num 查询数量，建议小于1000，越小越好，值太大可能影响服务器响应速度
	 * @return ScanReply 参见WTable\Args
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function scanPivot($tableId, $rowKey, $colKey, $asc=true, $num=100){
		if(!is_int($tableId) || !is_int($num) || !is_bool($asc)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcScanPivotFail);
		}
		$reply = $this->rep->doScan($this->rep->net, false, $tableId, $rowKey, $colKey,0, false, $asc, false, $num);
		return PkgMultiOp::formatRespScan($reply, $tableId, $rowKey, $num, false, $asc, false);
	}
	/**
	 * 扫描默认空间或者Z空间某个rowKey的数据，从上次位置继续扫描，上次的位置来自参数last。<br>
	 * 若last参数来自Scan/scanPivot函数返回则扫描默认空间，若来自zScan/zScanPivot函数返回则扫描Z空间。<br>
	 * 关于默认空间/Z空间的详细信息请参考WtableClient类说明。<br>
	 * 返回的记录条数由下列四个值的最小值决定：真实数据记录数，num参数，最大10000条记录限制，返回包达到1MB时的记录数，这四个值任何一个达到即返回
	 * 由于scan是一个相对耗时的操作，请不要太频繁执行以免影响到其他业务正常使用。<br>
	 * 
	 * @param ScanReply last 上次扫描的返回结果，该函数将在该结果之后继续扫描
	 * @return ScanReply 参见WTable\Args
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function scanMore($last){
		if(Null == $last || true === $last->end){
			throw new WTableException("Scan already finished", -1);
		}
		$ctx = $last->getCtx();
		$lastKv = $ctx->lastKv;
		if($ctx->zop)
			return $this->zScanPivot($last->tableId,$last->rowKey,$lastKv->colKey,$lastKv->score,$ctx->asc,$ctx->orderByScore,$ctx->num);
		else
			return $this->scanPivot($last->tableId,$last->rowKey,$lastKv->colKey,$ctx->asc,$ctx->num);

	}
	private function dumpPivot($oneTable, $tableId, $colSpace, $rowKey, $colKey, $score, $startUnitId, $endUnitId) {
		$dumpReply = new DumpReply();
		for ($i = 0 ; $i < 3; $i++) {
			try {
				$reply = $this->rep->doDump($this->rep->net, $oneTable, $tableId, $colSpace, $rowKey, $colKey, $score, $startUnitId, $endUnitId);
				return PkgDumpResp::formatRspDump($reply, $oneTable, $tableId);
			} catch(Exception $e) {
				//echo "dumpPivot failed and retry : ".$e->getMessage()."\n";
				if($i < 2) {
					usleep(100000*($i + 1));
				} else {
					throw $e;
				}	
			}
			
		}
		return Null;
	}
	/**
	 * Dump全量数据库，Dump权限需要进行授权管理，如果有需要请在管理平台申请。<br>
	 * 每次dump返回的数据最大为20000条记录或者数据量达到1MB,后面的数据可以不断使用dumpMore函数获取。<br>
	 * 服务器只有一个线程执行dump操作，因此若客户端并发执行dump操作可能会等待超时。<br>
	 * 
	 * <br>
	 * Dump接口会同时下载默认空间和Z空间的数据（如果同时使用了这两种数据空间的话），可以通过dump接口返回的DumpKV对象的getColSpace()返回值来区分这两个空间，
	 * 为0则表示这条数据属于默认空间，数据是通过set/mSet这类接口设置的，可以通过del接口来删除；为1则表示这条数据属于Z空间，
	 * 数据是通过zSet/zmSet这类接口设置的，可以通过zDel接口来删除。<br>

	 * @return DumpReply 参见WTable\Args
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function dumpDB() {
		$dumpReply = $this->dumpPivot(false, 0, 0, Null, Null, 0, 0, 10000);
		if (Null == $dumpReply) {
			return Null;
		}
		if ($dumpReply->end || count($dumpReply->kvs) > 0) {
			return $dumpReply;
		} else {
			return $this->dumpMore($dumpReply);
		}
	}
	/**
	 * Dump 指定表，Dump权限需要进行授权管理，如果有需要请在管理平台申请。<br>
	 * 每次dump返回的数据最大为20000条记录或者数据量达到1MB,后面的数据可以不断使用dumpMore函数获取。<br>
	 * 服务器只有一个线程执行dump操作，因此若客户端并发执行dump操作可能会等待超时。<br>
	 * 
	 * <br>
	 * Dump接口会同时下载默认空间和Z空间的数据（如果同时使用了这两种数据空间的话），可以通过dump接口返回的DumpKV对象的getColSpace()返回值来区分这两个空间，
	 * 为0则表示这条数据属于默认空间，数据是通过set/mSet这类接口设置的，可以通过del接口来删除；为1则表示这条数据属于Z空间，
	 * 数据是通过zSet/zmSet这类接口设置的，可以通过zDel接口来删除。<br>
	 * 
	 * @param int tableId 表ID，允许值范围 [0 ~ 9]
	 * @return DumpReply 参见WTable\Args
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function dumpTable($tableId) {
		if(!is_int($tableId)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcDumpTableFail);
		}
		$dumpReply = $this->dumpPivot(true, $tableId, 0, Null, Null, 0, 0, 10000);
		if ($dumpReply->end || count($dumpReply->kvs) > 0) {
			return $dumpReply;
		} else {
			return $this->dumpMore($dumpReply);
		}
	}
	/**
	 * 按照上次dump 的结果继续执行dump操作。<br>
	 * Dump权限需要进行授权管理，如果有需要请在管理平台申请。<br>
	 * 每次dump返回的数据最大为20000条记录或者数据量达到1MB，后面的数据可以不断使用dumpMore函数获取。<br>
	 * 服务器只有一个线程执行dump操作，因此若客户端并发执行dump操作可能会等待超时。<br>
	 * 
	 * @param DumpReply last 最近一次执行dump操作的返回
	 * @return DumpReply 参见WTable\Args
	 * @throws WTableException 错误码的定义请参考WTable\exception\WTableError
	 */
	public function dumpMore($last) {
		if(Null == $last || $last->end) {
			throw new WTableException("Dump already finished", WTableInnerError::IEcDumpMoreFail);
		}
		while(true) {
			$tmp = new DumpKv;
			$ctx = $last->getCtx();
			$rec;
			$lastUnitId = $ctx->lastSlotId;
			if($ctx->slotStart) {
				$lastUnitId += 1;
				if($ctx->oneTable) {
					$tmp->tableId = $ctx->tableId;
				}
				$rec = $tmp;
			} else {
				$rec = $ctx->lastKv;
			}
			$dumpReply = $this->dumpPivot($ctx->oneTable, $rec->tableId, $rec->colSpace, $rec->rowKey, $rec->colKey, $rec->score, $lastUnitId, $ctx->endSlotId);
			if(Null == $dumpReply) {
				return Null;
			}
			if($dumpReply->end || count($dumpReply->kvs) > 0) {
				return $dumpReply;
			}
			$last = $dumpReply;
		}
		return Null;
	}
	
}
