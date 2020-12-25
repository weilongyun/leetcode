<?php
namespace Libs\Http;

use \Libs\Util\View;

/*
 * @desc basic render 
 */

class BasicRender extends AbstractRender {

    protected $data = array();

    public function massign($data) {
        if (!is_array($data)) {
            return false;
        }

        $this->data = self::Array_merge($this->data, $data);
    }

    public function assign($key, $val) {
        $this->data[$key] = $val;
    }

    public function render($controllerName, $actionName, $isDisplay = FALSE) {
        if ($isDisplay == FALSE) {  
            $data = $this->fetch($controllerName, $actionName);
            return $data;
        } else {
            $file = $this->_getTplPath($controllerName, $actionName);
            $this->_outputTpl($file, $this->data);            
        }  
    }

    public function fetch($controllerName, $actionName) {
        $file = self::_getTplPath($controllerName, $actionName);
        $data = self::_fetchTpl($file, $this->data);
        return $data;
    }
    
    public function includeTpl($controllerName, $actionName) {
        $filePath = self::_getTplPath($controllerName, $actionName);
        include $filePath;        
    } 

    /**
     * @desc 
     * @param type $name
     * @param type $data 
     * @example TView::slot
     */
    public function slot($name, $isDisplay = true, $userData = array()) {
        $file = self::_getSlotPath($name);
        $data = $this->_fetchTpl($file, $this->data, $userData);
        if (!$isDisplay) { 
            return $data;
        }
        echo $data;
    }
    
    public function getdata() {
        return json_encode($this->data);
    } 

    private function _fetchTpl($filePath, $data, $userData = array()) {
        if (!ob_get_level()) {
            ob_start();
        }
        extract($data);
        extract($userData);
        include $filePath;
        $str = ob_get_clean();
        return $str;
    }
    
    private function _outputTpl($filePath, $data) {
        extract($data);
        include $filePath;
    }    

    private static function _getSlotPath($name) {  
        $file = VENDOR_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'slot' . DIRECTORY_SEPARATOR . $name . '.view.php';

        if (!file_exists($file)) {
            throw new \Exception('slot not exist: ' . $file);
        }
        return $file;
    }

    private static function _getTplPath($controllerName, $actionName) {
        $file = VENDOR_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR .
                $controllerName . DIRECTORY_SEPARATOR . $actionName . '.view.php';
        if (!file_exists($file)) {
            throw new \Exception('template not exist: ' . $file);
        }
        return $file;
    }
    
    private static function Array_merge($ar1, $ar2) {
        if (is_array($ar1) && is_array($ar2)) {
            return array_merge($ar1, $ar2);
        } elseif (is_array($ar1) && !is_array($ar2)) {
            return $ar1;
        } elseif (!is_array($ar1) && is_array($ar2)) {
            return $ar2;
        }
        return null;
    }
}
