<?php
namespace com\bj58\spat\scf\unittest;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\spat\scf\test\News;
class Test1 {
    static $_TSPEC;
    static $_SCFNAME = "entity.test1";

    private $news;
    private $lst;
    private $maps;
    private $test;

    public function __construct($news = '', $lst = '', $maps = '') {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(
                1 => array(
                    'var' => 'news',
                    'type' => SCFType::OBJECT,
                   // 'class' => new News(),
                    'sortId' => 1,
                    'elem' => array(
                        'class' => new News(),
                    ),
                ),
                2 => array(
                    'var' => 'lst',
                    'type' => SCFType::LST,
                    'sortId' => 2,
                    'elem' => array(
                        'type' => SCFType::I32,
                    ),
                ),
                3=> array(
                    'var' => 'maps',
                    'type' => SCFType::MAP,
                    'key' => array(
                        'type' => SCFType::I32,
                    ),
                    'value' => array(
                        'type' => SCFType::STRING,
                    ),
                    'sortId' => 3,
                ),
                4 => array(
                    'var' => 'test',
                    'type' => SCFType::OBJECT,
                    //'class' => 'this',
                    'sortId' => 4,
                    'elem' => array(
                        'class' => 'this',
                    ),
                ),
            );
        }
    }

    public function getNews()
    {
        return $this->news;
    }

    public function setNews($news)
    {
        $this->news = $news;
        return $this;
    }

    public function getLst()
    {
        return $this->lst;
    }

    public function setLst($lst)
    {
        $this->lst = $lst;
        return $this;
    }

    public function getMaps()
    {
        return $this->maps;
    }

    public function setMaps($maps)
    {
        $this->maps = $maps;
        return $this;
    }
 /**
     * @return the $test
     */
    public function getTest()
    {
        return $this->test;
    }

 /**
     * @param field_type $test
     */
    public function setTest($test)
    {
        $this->test = $test;
    }


}