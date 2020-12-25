<?php
namespace com\bj58\ipserver\domain;

use com\bj58\spat\scf\serialize\component\SCFType;

class IpLocal{
	 static $_TSPEC;
	 static $_SCFNAME = 'IpLocal';

	private $listName;
	private $localName;

	 public function __construct($listName = '', $localName = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'listName',
					'sortId' => 1,
					'type' => SCFType::STRING,
				),

				2=>array(
					'var' => 'localName',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return IpLocal::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		IpLocal::$_TSPEC = $_TSPEC;
	}

	public function getListName()
	{
		return $this->listName;
	}

	public function setListName($listName)
	{
		$this->listName = $listName;
	}

	public function getLocalName()
	{
		return $this->localName;
	}

	public function setLocalName($localName)
	{
		$this->localName = $localName;
	}


}