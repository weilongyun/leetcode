<?php
// namespace com\bj58\spat\scf\unittest;

use com\bj58\spat\scf\serialize\component\SCFType;
class Info {
	 static $_TSPEC;
	 static $_SCFNAME = 'Info';

	private $id;
	private $name;
	private $content;
	private $lst;
	private $set;
	private $map;
	private $date;

	
 public function __construct($id = '', $name = '', $content = '', $lst = '', $set = '', $map = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'id',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'name',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'content',
					'sortId' => 3,
					'type' => SCFType::STRING,
// 					'class' => new Content(),
				),

				4=>array(
					'var' => 'lst',
					'sortId' => 4,
					'type' => SCFType::LST,
					'elem' => array(
						'type' => SCFType::STRING,
					),
				),

				5=>array(
					'var' => 'set',
					'sortId' => 5,
					'type' => SCFType::SET,
					'elem' => array(
						'type' => SCFType::STRING,
					),
				),

				6=>array(
					'var' => 'map',
					'sortId' => 6,
					'type' => SCFType::MAP,
					'key' => array(
						'type' => SCFType::STRING,
					),
					'value' => array(
						'type' => SCFType::STRING,
					),
				),
			     
			     7=>array(
			         'var' => 'date',
			         'sortId' => 7,
			         'type' => SCFType::DATE,
			     ),

			);
		}
	}
	
	
	/**
	 * @return the $date
	 */
	public function getDate()
	{
	    return $this->date;
	}
	
	/**
	 * @param field_type $date
	 */
	public function setDate($date)
	{
	    $this->date = $date;
	}
	

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getLst()
	{
		return $this->lst;
	}

	public function setLst($lst)
	{
		$this->lst = $lst;
	}

	public function getSet()
	{
		return $this->set;
	}

	public function setSet($set)
	{
		$this->set = $set;
	}

	public function getMap()
	{
		return $this->map;
	}

	public function setMap($map)
	{
		$this->map = $map;
	}


}