<?php
namespace WTable\exception;

class WTableInnerError{
	const EcInnerStart		= -100;
	// init
	const IEcInitAgain		= -10000;
	const IEcInitArgsError	= -10001;

	const IEcLoadProxyFail	= -11000;

	const IEcAllProxyInvalid = -12000;
	const IEcInitSenderFail	= -12010;
	const IEcInitCMFail		= -12020;
	const IEcInitPLFail		= -12030;

	// operation base code
	const IEcPingFail		= -20000;
	const IEcGetFail		= -21000;
	const IEcZGetFail		= -22000;
	const IEcSetFail		= -23000;
	const IEcZSetFail		= -24000;
	const IEcDelFail		= -25000;
	const IEcZDelFail		= -26000;
	const IEcIncrFail		= -27000;
	const IEcZIncrFail		= -28000;

	const IEcMGetFail		= -29000;
	const IEcZMGetFail		= -30000;
	const IEcMSetFail		= -31000;
	const IEcZMSetFail		= -32000;
	const IEcMDelFail		= -33000;
	const IEcZMDelFail		= -34000;
	const IEcMIncrFail		= -35000;
	const IEcZMIncrFail		= -36000;

	const IEcScanFail		= -37000;
	const IEcScanPivotFail	= -38000;
	const IEcZScanFail		= -39000;
	const IEcZScanPivotFail	= -40000;
	const IEcScanMoreFail	= -41000;

	const IEcDumpDBFail		= -42000;
	const IEcDumpTableFail	= -43000;
	const IEcDumpMoreFail	= -44000;
	const IEcDumpPivotFail	= -45000;

	const IEcExpireFail		= -46000;
	const IEcZExpireFail	= -47000;
	
}
