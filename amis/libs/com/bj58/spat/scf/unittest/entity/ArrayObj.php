<?php
namespace com\bj58\spat\scf\unittest\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class ArrayObj{
	 static $_TSPEC;
	 static $_SCFNAME = 'ArrayObj';

	private $arr;

	 public function __construct($title = '', $content = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'arr',
					'sortId' => 1,
					'type' => SCFType::ARAY,
				    'elem'=> array(
            	        'type' => SCFType::I32,
            	    ),
				),
			);
		}
	}
	 /**
     * @return the $_SCFNAME
     */
    public static function getSCFNAME()
    {
        return ArrayObj::$_SCFNAME;
    }

 /**
     * @param string $_SCFNAME
     */
    public static function setSCFNAME($_SCFNAME)
    {
        ArrayObj::$_SCFNAME = $_SCFNAME;
    }

    public static function getTSPEC()
	{
		 return Content::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Content::$_TSPEC = $_TSPEC;
	}
	
	
    public function getArr()
    {
        return $this->arr;
    }

    public function setArr($arr)
    {
        $this->arr = $arr;
    }

	
}