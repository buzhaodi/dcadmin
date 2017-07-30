<?php
namespace app\api\controller;

class pubuliccon extends \think\Controller
{
    public function _initialize(){
        $origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';

        if(in_array($origin, config('allowdomin'))) {
            header('Access-Control-Allow-Credentials: true');
            header('content-type:application:json;charset=utf8');
            header('Access-Control-Allow-Origin:'.$origin);
            header('Access-Control-Allow-Methods:GET, HEAD, POST, PUT, DELETE, TRACE, OPTIONS, PATCH');
            header('Access-Control-Allow-Headers:X-Requested-With, accept, content-type, xxxx');
        }

    }

}


