<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class Tag{
	 static $_TSPEC;
	 static $_SCFNAME = 'Tag';

	private $TagID;
	private $Tags;

	 public function __construct($TagID = '', $Tags = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'TagID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'Tags',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return Tag::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Tag::$_TSPEC = $_TSPEC;
	}

	public function getTagID()
	{
		return $this->TagID;
	}

	public function setTagID($TagID)
	{
		$this->TagID = $TagID;
	}

	public function getTags()
	{
		return $this->Tags;
	}

	public function setTags($Tags)
	{
		$this->Tags = $Tags;
	}


}