<?php
namespace com\bj58\spat\scf\unittest\entityV2;

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
// 	private $date;
// 	private $extend1;
// 	private $extend2;
// 	private $extend3;

	
 public function __construct($id = '', $name = '', $content = '', $lst = '', $set = '', $map = '' ,$date= '') {
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
			     
// 			     7=>array(
// 			         'var' => 'date',
// 			         'sortId' => 7,
// 			         'type' => SCFType::DATE,
// 			     ),
			     
// 			     8=>array(
// 			         'var' => 'extend1',
// 			         'sortId' => 8,
// 			         'type' => SCFType::STRING,
// 			     ),
// 			     9=>array(
// 			         'var' => 'extend2',
// 			         'sortId' => 9,
// 			         'type' => SCFType::I32,
// 			     ),
// 			     10=>array(
// 			         'var' => 'extend3',
// 			         'sortId' => 10,
// 			         'type' => SCFType::DOUBLE,
// 			     ),

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
	

	 public static function getTSPEC()
	{
		 return Entity::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Entity::$_TSPEC = $_TSPEC;
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
 /**
     * @return the $extend1
     */
    public function getExtend1()
    {
        return $this->extend1;
    }

 /**
     * @return the $extend2
     */
    public function getExtend2()
    {
        return $this->extend2;
    }

 /**
     * @return the $extend3
     */
    public function getExtend3()
    {
        return $this->extend3;
    }

 /**
     * @param field_type $extend1
     */
    public function setExtend1($extend1)
    {
        $this->extend1 = $extend1;
    }

 /**
     * @param field_type $extend2
     */
    public function setExtend2($extend2)
    {
        $this->extend2 = $extend2;
    }

 /**
     * @param field_type $extend3
     */
    public function setExtend3($extend3)
    {
        $this->extend3 = $extend3;
    }

    

}