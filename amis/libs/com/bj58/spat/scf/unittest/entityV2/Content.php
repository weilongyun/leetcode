<?php
namespace com\bj58\spat\scf\unittest\entityV2;

use com\bj58\spat\scf\serialize\component\SCFType;

class Content{
	 static $_TSPEC;
	 static $_SCFNAME = 'javaBean.Content';

	public $title;
	private $content;
	

	 public function __construct($title = '', $content = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'title',
					'sortId' => 1,
					'type' => SCFType::STRING,
				),

				2=>array(
					'var' => 'content',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),
			    

			);
		}
	}

	 public static function getTSPEC()
	{
		 return Content::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Content::$_TSPEC = $_TSPEC;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}
}