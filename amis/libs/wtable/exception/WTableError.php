<?php 
namespace WTable\exception;

/**
 * WtableClient可能出现的异常错误码定义。<br>
 * @author spat
 * @package WTable\exception
 */
class WTableError{    
	const EcNotExist          = 1;   /** Key NOT exist */
	const EcOk                = 0;   /** Success */
	const EcCasNotMatch       = -16; /** CAS not match, get new CAS and try again */
	const EcTempFail          = -17; /** Temporary failed, retry may fix this */
	const EcTimeout           = -18; /** Request timeout, retry may fix this */
	const EcAbandon           = -19; /** Abandon request */
	const EcUnknownCmd        = -20; /** Unknown CMD */
	const EcAuthFailed        = -21; /** Authorize failed */
	const EcNoPrivilege       = -22; /** No access privilege */
	const EcReadOnly          = -23; /** Read only, cannot write (only master can be written) */
	const EcSlaveCas          = -24; /** Invalid CAS on slave for GET/MGET */
	const EcReadFail          = -25; /** Read failed */
	const EcWriteFail         = -26; /** Write failed */
	const EcDecodeFail        = -27; /** Decode request PKG failed */
	const EcInvHeadCrc        = -28; /** Invalid Head CRC */
	const EcInvDbId           = -29; /** Invalid DB ID (cannot be 255) */
	const EcInvTableId        = -30; /** Invalid Table ID, only allow [0 ~ 9] */
	const EcInvRowKey         = -31; /** RowKey length should be [1 ~ 255] */
	const EcInvColKey         = -32; /** ColKey length should be [0 ~ 8KB] */
	const EcInvValue          = -33; /** Value length should be [0 ~ 256KB] */
	const EcInvPkgLen         = -34; /** Pkg length should be less than 2MB */
	const EcInvKvNum          = -35; /** key/value array length out of range */
	const EcInvScanNum        = -36; /** Scan request number out of range */
	const EcScanEnded         = -37; /** Already scan/dump to end */
	const EcShutdown          = -38; /** Client or Proxy connection is shutdown */
	const EcCallNotReady      = -39; /** Call is not ready to reply */
	const EcClosedPool        = -40; /** Connection pool is closed */
	const EcCliNoValidAddr    = -41; /** No valid server address */
	const EcPrxNoValidAddr    = -42; /** No valid server address */
	const EcMigNeedClear      = -43; /** Migration need to clear old data first */
	const EcInvMigStatus      = -44; /** Invalid or unexpected migration status */
	const EcDeleteSlot        = -45; /** Failed to delete slot */
	const EcSaveConfFail      = -46; /** Failed to save config */
	const EcSelfSlave         = -47; /** Master and slave cannot be the same server */
	const EcMergeMopFail      = -48; /** Failed to merge multiple op response together */
	const EcInvClusterID      = -49; /** Invalid Cluster ID (proxy checks cid) */
	const EcInvBatchNum       = -50; /** MultiOp batch request number out of range [1 ~ 100] */
	const EcInvTTL	          = -58; /** TTL is invalid */


	const EcProxyConnNumError = -93; /** One proxy's conn request number out of range [1 ~ 3] */
	const EcRecvDecodeFail    = -94; /** Recv package and decode fail */
	const EcRecvInvPkgLen     = -95; /** Recv package and length > 2M */
	const EcAllocPkgFail      = -96; /** Allocate package space fail */
	const EcPkgQueueFull      = -97; /** The request is too much to handle */
	const EcOperWriteFail     = -98; /** Operation write all proxy fail */
	const EcOperTimeOut       = -99; /** Operation wait time out */
	
	/** 获得错误码对应的WTableException
	 *  @param int res 错误码
	 */
	public static function getException($res) {
		if ($res >= 0)
			return;

		switch ($res) {
			
		case self::EcCasNotMatch:
			throw new WTableException("CAS not match, get new CAS and try again",$res);

		case self::EcTempFail:
			throw new WTableException("Temporary failed, retry may fix this",$res);

		case self::EcTimeout:
			throw new WTableException("Request timeout, retry may fix this",$res);

		case self::EcAbandon:
			throw new WTableException("Abandon request, retry may fix this",$res);

		case self::EcUnknownCmd:
			throw new WTableException("Unknown CMD",$res);

		case self::EcAuthFailed:
			throw new WTableException("authorize failed, check your bid&password",$res);

		case self::EcNoPrivilege:
			throw new WTableException("No access privilege",$res);

		case self::EcReadOnly:
			throw new WTableException("Read only, cannot write",$res);

		case self::EcSlaveCas:
			throw new WTableException("Invalid CAS on slave for GET/MGET",$res);

		case self::EcReadFail:
			throw new WTableException("Read failed",$res);

		case self::EcWriteFail:
			throw new WTableException("Write failed",$res);

		case self::EcDecodeFail:
			throw new WTableException("Decode request PKG failed",$res);

		case self::EcInvHeadCrc:
			throw new WTableException("Invalid Head CRC",$res);

		case self::EcInvDbId:
			throw new WTableException("Invalid DB ID",$res);

		case self::EcInvTableId:
			throw new WTableException("Invalid Table ID, only allow [0 ~ 9]",$res);

		case self::EcInvRowKey:
			throw new WTableException("RowKey length should be [1 ~ 255]",$res);

		case self::EcInvColKey:
			throw new WTableException("ColKey length should be [0 ~ 8KB]",$res);

		case self::EcInvValue:
			throw new WTableException("Value length should be [0 ~ 256KB]",$res);

		case self::EcInvPkgLen:
			throw new WTableException("Pkg length should be less than 2MB",$res);

		case self::EcInvKvNum:
			throw new WTableException("key/value array length out of range",$res);

		case self::EcInvScanNum:
			throw new WTableException("Scan request number out of range 1~30000",$res);

		case self::EcScanEnded:
			throw new WTableException("Already scan/dump to end",$res);

		case self::EcShutdown:
			throw new WTableException("Client or Proxy connection is shutdown",$res);

		case self::EcCallNotReady:
			throw new WTableException("Call is not ready to reply",$res);

		case self::EcClosedPool:
			throw new WTableException("Connection pool is closed",$res);

		case self::EcCliNoValidAddr:
			throw new WTableException("Client cannot get valid server address",$res);

		case self::EcPrxNoValidAddr:
			throw new WTableException("Proxy cannot get valid server address",$res);

		case self::EcMigNeedClear:
			throw new WTableException("Migration need to clear old data first",$res);

		case self::EcInvMigStatus:
			throw new WTableException("Invalid or unexpected migration status",$res);

		case self::EcDeleteSlot:
			throw new WTableException("Failed to delete slot data",$res);

		case self::EcSaveConfFail:
			throw new WTableException("Server failed to save config",$res);

		case self::EcSelfSlave:
			throw new WTableException("Master and slave cannot be the same server",$res);

		case self::EcMergeMopFail:
			throw new WTableException("Failed to merge multiple opresponse together",$res);

		case self::EcInvClusterID:
			throw new WTableException("Invalid cluster id",$res);

		case self::EcInvBatchNum:
			throw new WTableException("MultiOp batch request number out of range [1 ~ 100]",$res);
			
		case self::EcProxyConnNumError:
			throw new WTableException("One proxy's conn request number out of range [1 ~ 3]",$res);
			
		case self::EcRecvDecodeFail:
			throw new WTableException("Recv package and decode fail",$res);
			
		case self::EcRecvInvPkgLen:      
			throw new WTableException("Recv package and length > 2M",$res);
			
		case self::EcAllocPkgFail:
			throw new WTableException("Allocate package space fail",$res);

		case self::EcPkgQueueFull:
			throw new WTableException("The request is too much to handle",$res);
		
		case self::EcOperWriteFail:
			throw new WTableException("Operation write all proxy fail",$res);
			
		case self::EcOperTimeOut:
			throw new WTableException("Operation wait time out",$res);

		case self::EcInvTTL:
			throw new WTableException("TTL is invalid", $res);
			
		default:
			throw new WTableException("Unknown exception",$res);
		}
	}
}


