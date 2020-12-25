<?php
namespace com\bj58\spat\scf\unittest\entityV2;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\unittest\entity\Content;
class Entity extends Content{
	 static $_TSPEC;
	 static $_SCFNAME = 'Entity';

	private $id;
	private $name;
	private $content;
	private $lst;
	private $set;
	private $map;
	private $date;

	 public function __construct($id = '', $name = '', $content = '', $lst = '', $set = '', $map = '' ) {
	     parent::__construct();
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
			         'sortId' => 6,
			         'type' => SCFType::DATE,
			     ),
			     
			);
		}
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
     * @return the $_SCFNAME
     */
    public static function getSCFNAME()
    {
        return Entity::$_SCFNAME;
    }

 /**
     * @return the $date
     */
    public function getDate()
    {
        return $this->date;
    }

 /**
     * @param string $_SCFNAME
     */
    public static function setSCFNAME($_SCFNAME)
    {
        Entity::$_SCFNAME = $_SCFNAME;
    }

 /**
     * @param field_type $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

	


}