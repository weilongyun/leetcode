<?php
namespace Libs\Http;

use \Libs\Util\PerformanceHelper;

class BasicResponse {

    /**
     * @var int HTTP status code
     */
    protected $status;

    /**
     * @var \Slim\Http\Headers
     */
    protected $headers = array();

    /**
     * @var string HTTP response body
     */
    protected $body = '';
    private $app;
    private $render;

    /**
     * @var array HTTP response codes and messages
     */
    protected static $messages = array(
        //Informational 1xx
        100 => '100 Continue',
        101 => '101 Switching Protocols',
        //Successful 2xx
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted',
        203 => '203 Non-Authoritative Information',
        204 => '204 No Content',
        205 => '205 Reset Content',
        206 => '206 Partial Content',
        //Redirection 3xx
        300 => '300 Multiple Choices',
        301 => '301 Moved Permanently',
        302 => '302 Found',
        303 => '303 See Other',
        304 => '304 Not Modified',
        305 => '305 Use Proxy',
        306 => '306 (Unused)',
        307 => '307 Temporary Redirect',
        //Client Error 4xx
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable',
        407 => '407 Proxy Authentication Required',
        408 => '408 Request Timeout',
        409 => '409 Conflict',
        410 => '410 Gone',
        411 => '411 Length Required',
        412 => '412 Precondition Failed',
        413 => '413 Request Entity Too Large',
        414 => '414 Request-URI Too Long',
        415 => '415 Unsupported Media Type',
        416 => '416 Requested Range Not Satisfiable',
        417 => '417 Expectation Failed',
        418 => '418 I\'m a teapot',
        422 => '422 Unprocessable Entity',
        423 => '423 Locked',
        //Server Error 5xx
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable',
        504 => '504 Gateway Timeout',
        505 => '505 HTTP Version Not Supported'
    );

    /**
     * Constructor
     */
    public function __construct() {
        $this->render = new BasicRender();
    }

    public function setStatus($status) {
        $this->status = (int) $status;
    }
    
    public function setHeader($name, $value) {
        $this->headers[$name] = $value;
    }

    public function setBody($content) {
        $this->write($content, true);
    }

    /**
     * Append HTTP response body
     * @param  string   $body       Content to append to the current HTTP response body
     * @param  bool     $replace    Overwrite existing response body?
     * @return string               The updated HTTP response body
     */
    private function write($body, $replace = false) {
        if ($replace) {
            $this->body = $body;
        } else {
            $this->body .= (string) $body;
        }

        return $this->body;
    }

    public function redirect($url, $status = 302) {
        $this->setStatus($status);
        $this->headers['Location'] = $url;
    }

    public static function getMessageForCode($status) {
        if (isset(self::$messages[$status])) {
            return self::$messages[$status];
        } else {
            return null;
        }
    }

    public function result() {
        // Prepare response
        in_array($this->status, array(204, 304)) && $this->setBody('');
        return array($this->status, $this->headers, $this->body);
    }

    public function massign($data) {
        $this->render->massign($data);
    }

    public function assign($key, $val) {
        $this->render->assign($key, $val);
    }

    public function renderHtml($moduleName, $actionName) {
        $date = date('md');
        if (isset($_GET['__pr']) && $_GET['__pr'] == $date) {  //开发模式，查看所有的data
            $this->write($this->render->getdata());   
        } else {   
            PerformanceHelper::RecordStart('renderHtml',"$moduleName:{$actionName}");
            $data = $this->render->render($moduleName, $actionName);
            PerformanceHelper::RecordEnd('renderHtml');          
            $this->write($data);            
            
            if (PerformanceHelper::IsOpen()) {
                $this->assign('_performance', PerformanceHelper::GetLogArray());
                $performancedata = $this->render->render('performance', 'print'); 
                $this->write($performancedata);            
            }            
        }
    }

    public function renderJson($code, $msg, $data=array()) {
        $output = array(
            'code' => $code,
            'message' => $msg,
            'data' => $data,
        );
        $str = json_encode($output);
        if (isset($_GET['jsoncallback']) && \Libs\Util\Utilities::ValidateCallBK($_GET['jsoncallback'])) { //jsonp的方式
            $str = "{$_GET['jsoncallback']}({$str})";
        }  
        $this->setBody($str);
    }

    public function slot($name, $isDisplay = true) {
        return $this->render->slot($name, $isDisplay);
    }
}
