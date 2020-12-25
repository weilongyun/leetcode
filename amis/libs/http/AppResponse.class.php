<?php
namespace Libs\Http;

class AppResponse extends BasicResponse{

    public function renderJson($code, $msg, $data=array()) {
        $output = array(
            'status' => $code,
            'msg' => $msg,
            'result' => $data,
        );
        $str = json_encode($output);
        $this->setBody($str);
    }

}
