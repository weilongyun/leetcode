<?php
namespace WTable\client;
/**
 * WTable中关于CAS乐观锁支持的常量定义，在WtableClient类get、zGet函数中使用。<br>
 * @author spat
 * @package WTable\client
 */
class CasArgs{
	/**
	 * 请求随机发往Master或Slave，性能好，绝大部分业务使用CasArgs::CAS_DEFAULT即可满足需求。
	 * 通常Master与Slave同步非常快，因此读取到旧数据概率非常低。
	 */
	const CAS_DEFAULT = 0;
	/**
	 * 请求只发送到Master，能够读取到最新的值。
	 * 若非必要请使用Cas.DEFAULT以减少Master服务器压力。
	 */
	const CAS_MASTER = 1;
	/**
	 * 请求只发送到Master，对key加乐观锁，服务器会返回该key的当前CAS版本号。
	 * 可以通过$reply->cas获取版本号，这个值可以传递给写操作函数使用。
	 * 若非必要请使用CasArgs::CAS_DEFAULT以减少Master服务器压力。
	 */
	const CAS_LOCK = 2;
}
