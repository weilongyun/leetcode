<?php
namespace com\bj58\fang\zhuzhan\infodetail\entity\data;

use com\bj58\spat\scf\serialize\component\SCFType;

use com\bj58\fang\zhuzhan\infodetail\entity\data\Object;

class HrefModel{
	 static $_TSPEC;
	 static $_SCFNAME = 'HrefModel';

	private $text;
	private $url;
	private $desc;
	private $value;
	private $index;
	private $toUrl;
	private $isMain;

	 public function __construct($text = '', $url = '', $desc = '', $value = '', $index = '', $toUrl = '', $isMain = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'text',
					'sortId' => 1,
					'type' => SCFType::STRING,
				),

				2=>array(
					'var' => 'url',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'desc',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'value',
					'sortId' => 4,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new Object(),
					),
				),

				5=>array(
					'var' => 'index',
					'sortId' => 5,
					'type' => SCFType::I32,
				),

				6=>array(
					'var' => 'toUrl',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'isMain',
					'sortId' => 7,
					'type' => SCFType::BOOL,
				),

			);
		}

		 $this->text=$text;
		 $this->url=$url;
		 $this->desc=$desc;
		 $this->value=$value;
		 $this->index=$index;
		 $this->toUrl=$toUrl;
		 $this->isMain=$isMain;
	}

	 public static function getTSPEC()
	{
		 return HrefModel::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		HrefModel::$_TSPEC = $_TSPEC;
	}

	public function getText()
	{
		return $this->text;
	}

	public function setText($text)
	{
		$this->text = $text;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setUrl($url)
	{
		$this->url = $url;
	}

	public function getDesc()
	{
		return $this->desc;
	}

	public function setDesc($desc)
	{
		$this->desc = $desc;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function getIndex()
	{
		return $this->index;
	}

	public function setIndex($index)
	{
		$this->index = $index;
	}

	public function getToUrl()
	{
		return $this->toUrl;
	}

	public function setToUrl($toUrl)
	{
		$this->toUrl = $toUrl;
	}

	public function getIsMain()
	{
		return $this->isMain;
	}

	public function setIsMain($isMain)
	{
		$this->isMain = $isMain;
	}


}