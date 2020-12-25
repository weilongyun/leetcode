<?php
namespace Libs\Util;

use \Libs\Util\Utilities;
use \Gongyu\Packages\Base\Validator;
use \Libs\Wmonitor\WMonitorRBI;

class View { 

    public static function Output($str) {
        if (empty($str)) {
            return;
        }
        echo htmlspecialchars($str);
    }
    
    public static function ShowHouseDetailUrl($listName, $imcId) {
        if (empty($imcId)) {
            echo '';return;
        }
        if (!Utilities::IsDomainRewrite()) {
            echo "/house/detail/{$listName}/{$imcId}";
        } else {
            echo "/pinpaigongyu/{$imcId}x.shtml";            
        }
    }   
    
    public static function OutPutCdnJs($js) {
        $js = str_replace(array('http:', 'https:'), array('',''), $js);
        if (preg_match("/^\\/\\/(static.58.com|j1.58cdn.com.cn)\\/.*\\.js(\\?.*)?$/", $js)) {
            $oldUrl = $js;
            $oldUrl = str_replace("static.58.com", "j1.58cdn.com.cn", $oldUrl);
            $index = stripos($oldUrl,'?');
            if (!empty($index)) {
                $oldUrl = substr($oldUrl, 0, $index);
            }
            $version = \Gongyu\Packages\Config\UsdtConfig::GetStaticResourceVersion("http:".$oldUrl);
            if (empty($version)) {
                $version = '0';
            }
            $versionStr = "_v{$version}.js";
            $js = str_replace('.js', $versionStr, $oldUrl);
        }

        if ('//a.58cdn.com.cn/app58/static/rms/app/js/app_20264.js' == $js) {
            $js .= "?t=" . date('Ymd');
        }

        echo $js;
    }
    
    public static function OutPutCdnCss($css) {
        $css = str_replace(array('http:', 'https:'), array('',''), $css);
        if (preg_match("/^\\/\\/(static.58.com|c.58cdn.com.cn)\\/.*\\.css(\\?.*)?$/", $css)) {
            $oldUrl = $css;
            $oldUrl = str_replace("static.58.com", "c.58cdn.com.cn", $oldUrl);
            $index = stripos($oldUrl,'?');
            if (!empty($index)) {
                $oldUrl = substr($oldUrl, 0, $index);
            }
            $version = \Gongyu\Packages\Config\UsdtConfig::GetStaticResourceVersion("http:".$oldUrl);
            if (empty($version)) {
                $version = '0';
            }
            $versionStr = "_v{$version}.css";
            $css = str_replace('.css', $versionStr, $oldUrl);
        }

        echo $css;
    }
    
    public static function GetStaticUrlPath($url) {
        if (empty($url)) {
            return '';
        }
        $urlData = parse_url($url);
        if (empty($urlData)) {
            return $url;
        }
        $path = $urlData['path'];
        if (empty($path)) {
            return $url;
        }  
        return ltrim($path,'/');
    }
    
    public static function GetServiceInfo($cityInfo, $pageType = '') {
        $cityListName = $cityInfo['ListName'];

        $from = in_array(
            current(explode('_', $_GET['from'])),
            array('58','sem','seo','tg','other')) ? '58' : '';
        $from = $from ?: $_GET['logofrom'];
        !in_array($from, array('58','ganji','anjuke')) && $from = '';

        if (empty($from)) {
            $from = $_COOKIE['logofrom'];
        } else if ($from && $_COOKIE['logofrom'] != $from) {
            setcookie('logofrom', $from, time() + 86400, '/', '.58.com');
        }

        $result = array(
            'name' => '58',
            'webLogoClass' => 'newaplogo',
            'webLink' => "http://{$cityListName}.58.com/",
        );
        $pageType == 'detail' && $result['webLink'] = "http://{$cityListName}.58.com/pinpaigongyu";
        switch ($from) {
            case 'anjuke':
                $result = array(
                    'name' => '安居客',
                    'webLogoClass' => 'anjukelogo',
                    'webLink' => "http://{$cityListName}.zu.anjuke.com/fangyuan/l3/",
                );
                break;

            case 'ganji':
                $result = array(
                    'name' => '赶集',
                    'webLogoClass' => 'ganjilogo',
                    'webLink' => 'http://www.ganji.com/',
                );
                break;

            case '58':
            default :
                break;
        }

        return $result;
    }

    public static function Output404() {
        $app = \Frame\Application::instance();
        $app->response->setStatus(404);
        $wmonitorId =  WMonitorRBI::Get404Id();                  
        $wmonitorId > 0 && WMonitorRBI::setRBI($wmonitorId,1);  
    }
    
    public static function Redirect($url) {
        $app = \Frame\Application::instance();
        $app->response->redirect($url);
    }     
}
