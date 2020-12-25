<?php
namespace WTable\protocal;

class Protocal{
	// Front CTRL
	const CmdAuth	= 0x9;

	// Front Read
	const CmdPing	= 0x10;
	const CmdGet	= 0x11;
	const CmdMGet	= 0x12;
	const CmdScan	= 0x13;
	const CmdDump	= 0x14;

	// Front Write
	const CmdSet	= 0x60;
	const CmdMSet	= 0x61;
	const CmdDel	= 0x62;
	const CmdMDel	= 0x63;
	const CmdIncr	= 0x64;
	const CmdMIncr	= 0x65;
	const CmdExpire	= 0x66;

	// Name Center
	const CmdGetPrx		= 0xE0; // Get proxy list from Name Center
	const CmdGetMgr		= 0xE1; // Get manager list from Name Center
	const AdminDbId		= 255;
	const HeadSize		= 20;
	const MaxUint8		= 255;
	const MaxUint16		= 65535;
	const MaxValueLen	= 0x40000;      // 256KB
	const MaxPkgLen		= 0x200000; // 2MB
}
