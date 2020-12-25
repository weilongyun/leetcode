<?php
namespace com\bj58\spat\scf\unittest\entity;;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\unittest\entity\Content;

class ContentChild extends Content{
	 static $_TSPEC;
	 static $_SCFNAME = 'ContentChild';

	public $a;
	public $c;
	public $b;
	private $lst;
	



 public function __construct($titlec = '', $contentc = '' ) {
		 parent::__construct();
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				
			     1=>array(
			         'var' => 'a',
			         'sortId' => 3,
			         'type' => SCFType::STRING,
			     ),
			     

				2=>array(
					'var' => 'b',
					'sortId' => 4,
					'type' => SCFType::FLOAT,
				),
			     
			     3=>array(
			         'var' => 'c',
			         'sortId' => 5,
			         'type' => SCFType::I32,
			     ),
			     
			     4=>array(
			         'var' => 'lst',
			         'sortId' => 6,
			         'type' => SCFType::LST,
			         'elem'=> array(
			             'type' => SCFType::STRING,
			         ),
			     ),

			);
		}
	}

 

 /**
     * @return the $c
     */
    public function getC()
    {
        return $this->c;
    }

 /**
     * @return the $b
     */
    public function getB()
    {
        return $this->b;
    }

 /**
     * @return the $a
     */
    public function getA()
    {
        return $this->a;
    }

 /**
     * @param field_type $c
     */
    public function setC($c)
    {
        $this->c = $c;
    }

 /**
     * @param field_type $b
     */
    public function setB($b)
    {
        $this->b = $b;
    }

 /**
     * @param field_type $a
     */
    public function setA($a)
    {
        $this->a = $a;
    }

    public static function getTSPEC()
	{
		 return ContentChild::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		ContentChild::$_TSPEC = $_TSPEC;
	}

	/**
	 * @return the $lst
	 */
	public function getLst()
	{
	    return $this->lst;
	}
	
	/**
	 * @param field_type $lst
	 */
	public function setLst($lst)
	{
	    $this->lst = $lst;
	}
	


}