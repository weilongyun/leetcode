<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class CommunityDetail{
	 static $_TSPEC;
	 static $_SCFNAME = 'CommunityDetail';

	private $infoid;
	private $community;
	private $developer;
	private $volumeratio;
	private $greenratio;
	private $propertycompany;
	private $completiontime;
	private $zipcode;
	private $propertyright;
	private $propertytype;
	private $buildtype;
	private $buildarea;
	private $currenthousehold;
	private $household;
	private $propertyphone;
	private $propertycost;
	private $additionalinfo;
	private $propertyaddress;
	private $characteristics;
	private $loopline;
	private $watersupply;
	private $heating;
	private $powersupply;
	private $gassupply;
	private $communication;
	private $elevator;
	private $safety;
	private $health;
	private $entrance;
	private $parking;
	private $kindergarten;
	private $school;
	private $store;
	private $hospital;
	private $postoffice;
	private $bank;
	private $other;
	private $detail;
	private $university;
	private $writelog;
	private $expanse;
	private $paramap;

	 public function __construct($infoid = '', $community = '', $developer = '', $volumeratio = '', $greenratio = '', $propertycompany = '', $completiontime = '', $zipcode = '', $propertyright = '', $propertytype = '', $buildtype = '', $buildarea = '', $currenthousehold = '', $household = '', $propertyphone = '', $propertycost = '', $additionalinfo = '', $propertyaddress = '', $characteristics = '', $loopline = '', $watersupply = '', $heating = '', $powersupply = '', $gassupply = '', $communication = '', $elevator = '', $safety = '', $health = '', $entrance = '', $parking = '', $kindergarten = '', $school = '', $store = '', $hospital = '', $postoffice = '', $bank = '', $other = '', $detail = '', $university = '', $writelog = '', $expanse = '', $paramap = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'infoid',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'community',
					'sortId' => 2,
					'type' => SCFType::OBJECT,
					'class' => new Community(),
				),

				3=>array(
					'var' => 'developer',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'volumeratio',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'greenratio',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'propertycompany',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'completiontime',
					'sortId' => 7,
					'type' => SCFType::STRING,
				),

				8=>array(
					'var' => 'zipcode',
					'sortId' => 8,
					'type' => SCFType::STRING,
				),

				9=>array(
					'var' => 'propertyright',
					'sortId' => 9,
					'type' => SCFType::STRING,
				),

				10=>array(
					'var' => 'propertytype',
					'sortId' => 10,
					'type' => SCFType::STRING,
				),

				11=>array(
					'var' => 'buildtype',
					'sortId' => 11,
					'type' => SCFType::STRING,
				),

				12=>array(
					'var' => 'buildarea',
					'sortId' => 12,
					'type' => SCFType::STRING,
				),

				13=>array(
					'var' => 'currenthousehold',
					'sortId' => 13,
					'type' => SCFType::I32,
				),

				14=>array(
					'var' => 'household',
					'sortId' => 14,
					'type' => SCFType::I32,
				),

				15=>array(
					'var' => 'propertyphone',
					'sortId' => 15,
					'type' => SCFType::STRING,
				),

				16=>array(
					'var' => 'propertycost',
					'sortId' => 16,
					'type' => SCFType::STRING,
				),

				17=>array(
					'var' => 'additionalinfo',
					'sortId' => 17,
					'type' => SCFType::STRING,
				),

				18=>array(
					'var' => 'propertyaddress',
					'sortId' => 18,
					'type' => SCFType::STRING,
				),

				19=>array(
					'var' => 'characteristics',
					'sortId' => 19,
					'type' => SCFType::STRING,
				),

				20=>array(
					'var' => 'loopline',
					'sortId' => 20,
					'type' => SCFType::I32,
				),

				21=>array(
					'var' => 'watersupply',
					'sortId' => 21,
					'type' => SCFType::STRING,
				),

				22=>array(
					'var' => 'heating',
					'sortId' => 22,
					'type' => SCFType::STRING,
				),

				23=>array(
					'var' => 'powersupply',
					'sortId' => 23,
					'type' => SCFType::STRING,
				),

				24=>array(
					'var' => 'gassupply',
					'sortId' => 24,
					'type' => SCFType::STRING,
				),

				25=>array(
					'var' => 'communication',
					'sortId' => 25,
					'type' => SCFType::STRING,
				),

				26=>array(
					'var' => 'elevator',
					'sortId' => 26,
					'type' => SCFType::STRING,
				),

				27=>array(
					'var' => 'safety',
					'sortId' => 27,
					'type' => SCFType::STRING,
				),

				28=>array(
					'var' => 'health',
					'sortId' => 28,
					'type' => SCFType::STRING,
				),

				29=>array(
					'var' => 'entrance',
					'sortId' => 29,
					'type' => SCFType::STRING,
				),

				30=>array(
					'var' => 'parking',
					'sortId' => 30,
					'type' => SCFType::STRING,
				),

				31=>array(
					'var' => 'kindergarten',
					'sortId' => 31,
					'type' => SCFType::STRING,
				),

				32=>array(
					'var' => 'school',
					'sortId' => 32,
					'type' => SCFType::STRING,
				),

				33=>array(
					'var' => 'store',
					'sortId' => 33,
					'type' => SCFType::STRING,
				),

				34=>array(
					'var' => 'hospital',
					'sortId' => 34,
					'type' => SCFType::STRING,
				),

				35=>array(
					'var' => 'postoffice',
					'sortId' => 35,
					'type' => SCFType::STRING,
				),

				36=>array(
					'var' => 'bank',
					'sortId' => 36,
					'type' => SCFType::STRING,
				),

				37=>array(
					'var' => 'other',
					'sortId' => 37,
					'type' => SCFType::STRING,
				),

				38=>array(
					'var' => 'detail',
					'sortId' => 38,
					'type' => SCFType::STRING,
				),

				39=>array(
					'var' => 'university',
					'sortId' => 39,
					'type' => SCFType::STRING,
				),

				40=>array(
					'var' => 'writelog',
					'sortId' => 40,
					'type' => SCFType::BOOL,
				),

				41=>array(
					'var' => 'expanse',
					'sortId' => 41,
					'type' => SCFType::STRING,
				),

				42=>array(
					'var' => 'paramap',
					'sortId' => 42,
					'type' => SCFType::MAP,
					'key' => array(
						'type' => SCFType::I32,
					),
					'value' => array(
						'type' => SCFType::STRING,
					),
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return CommunityDetail::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		CommunityDetail::$_TSPEC = $_TSPEC;
	}

	public function getInfoid()
	{
		return $this->infoid;
	}

	public function setInfoid($infoid)
	{
		$this->infoid = $infoid;
	}

	public function getCommunity()
	{
		return $this->community;
	}

	public function setCommunity($community)
	{
		$this->community = $community;
	}

	public function getDeveloper()
	{
		return $this->developer;
	}

	public function setDeveloper($developer)
	{
		$this->developer = $developer;
	}

	public function getVolumeratio()
	{
		return $this->volumeratio;
	}

	public function setVolumeratio($volumeratio)
	{
		$this->volumeratio = $volumeratio;
	}

	public function getGreenratio()
	{
		return $this->greenratio;
	}

	public function setGreenratio($greenratio)
	{
		$this->greenratio = $greenratio;
	}

	public function getPropertycompany()
	{
		return $this->propertycompany;
	}

	public function setPropertycompany($propertycompany)
	{
		$this->propertycompany = $propertycompany;
	}

	public function getCompletiontime()
	{
		return $this->completiontime;
	}

	public function setCompletiontime($completiontime)
	{
		$this->completiontime = $completiontime;
	}

	public function getZipcode()
	{
		return $this->zipcode;
	}

	public function setZipcode($zipcode)
	{
		$this->zipcode = $zipcode;
	}

	public function getPropertyright()
	{
		return $this->propertyright;
	}

	public function setPropertyright($propertyright)
	{
		$this->propertyright = $propertyright;
	}

	public function getPropertytype()
	{
		return $this->propertytype;
	}

	public function setPropertytype($propertytype)
	{
		$this->propertytype = $propertytype;
	}

	public function getBuildtype()
	{
		return $this->buildtype;
	}

	public function setBuildtype($buildtype)
	{
		$this->buildtype = $buildtype;
	}

	public function getBuildarea()
	{
		return $this->buildarea;
	}

	public function setBuildarea($buildarea)
	{
		$this->buildarea = $buildarea;
	}

	public function getCurrenthousehold()
	{
		return $this->currenthousehold;
	}

	public function setCurrenthousehold($currenthousehold)
	{
		$this->currenthousehold = $currenthousehold;
	}

	public function getHousehold()
	{
		return $this->household;
	}

	public function setHousehold($household)
	{
		$this->household = $household;
	}

	public function getPropertyphone()
	{
		return $this->propertyphone;
	}

	public function setPropertyphone($propertyphone)
	{
		$this->propertyphone = $propertyphone;
	}

	public function getPropertycost()
	{
		return $this->propertycost;
	}

	public function setPropertycost($propertycost)
	{
		$this->propertycost = $propertycost;
	}

	public function getAdditionalinfo()
	{
		return $this->additionalinfo;
	}

	public function setAdditionalinfo($additionalinfo)
	{
		$this->additionalinfo = $additionalinfo;
	}

	public function getPropertyaddress()
	{
		return $this->propertyaddress;
	}

	public function setPropertyaddress($propertyaddress)
	{
		$this->propertyaddress = $propertyaddress;
	}

	public function getCharacteristics()
	{
		return $this->characteristics;
	}

	public function setCharacteristics($characteristics)
	{
		$this->characteristics = $characteristics;
	}

	public function getLoopline()
	{
		return $this->loopline;
	}

	public function setLoopline($loopline)
	{
		$this->loopline = $loopline;
	}

	public function getWatersupply()
	{
		return $this->watersupply;
	}

	public function setWatersupply($watersupply)
	{
		$this->watersupply = $watersupply;
	}

	public function getHeating()
	{
		return $this->heating;
	}

	public function setHeating($heating)
	{
		$this->heating = $heating;
	}

	public function getPowersupply()
	{
		return $this->powersupply;
	}

	public function setPowersupply($powersupply)
	{
		$this->powersupply = $powersupply;
	}

	public function getGassupply()
	{
		return $this->gassupply;
	}

	public function setGassupply($gassupply)
	{
		$this->gassupply = $gassupply;
	}

	public function getCommunication()
	{
		return $this->communication;
	}

	public function setCommunication($communication)
	{
		$this->communication = $communication;
	}

	public function getElevator()
	{
		return $this->elevator;
	}

	public function setElevator($elevator)
	{
		$this->elevator = $elevator;
	}

	public function getSafety()
	{
		return $this->safety;
	}

	public function setSafety($safety)
	{
		$this->safety = $safety;
	}

	public function getHealth()
	{
		return $this->health;
	}

	public function setHealth($health)
	{
		$this->health = $health;
	}

	public function getEntrance()
	{
		return $this->entrance;
	}

	public function setEntrance($entrance)
	{
		$this->entrance = $entrance;
	}

	public function getParking()
	{
		return $this->parking;
	}

	public function setParking($parking)
	{
		$this->parking = $parking;
	}

	public function getKindergarten()
	{
		return $this->kindergarten;
	}

	public function setKindergarten($kindergarten)
	{
		$this->kindergarten = $kindergarten;
	}

	public function getSchool()
	{
		return $this->school;
	}

	public function setSchool($school)
	{
		$this->school = $school;
	}

	public function getStore()
	{
		return $this->store;
	}

	public function setStore($store)
	{
		$this->store = $store;
	}

	public function getHospital()
	{
		return $this->hospital;
	}

	public function setHospital($hospital)
	{
		$this->hospital = $hospital;
	}

	public function getPostoffice()
	{
		return $this->postoffice;
	}

	public function setPostoffice($postoffice)
	{
		$this->postoffice = $postoffice;
	}

	public function getBank()
	{
		return $this->bank;
	}

	public function setBank($bank)
	{
		$this->bank = $bank;
	}

	public function getOther()
	{
		return $this->other;
	}

	public function setOther($other)
	{
		$this->other = $other;
	}

	public function getDetail()
	{
		return $this->detail;
	}

	public function setDetail($detail)
	{
		$this->detail = $detail;
	}

	public function getUniversity()
	{
		return $this->university;
	}

	public function setUniversity($university)
	{
		$this->university = $university;
	}

	public function getWritelog()
	{
		return $this->writelog;
	}

	public function setWritelog($writelog)
	{
		$this->writelog = $writelog;
	}

	public function getExpanse()
	{
		return $this->expanse;
	}

	public function setExpanse($expanse)
	{
		$this->expanse = $expanse;
	}

	public function getParamap()
	{
		return $this->paramap;
	}

	public function setParamap($paramap)
	{
		$this->paramap = $paramap;
	}


}