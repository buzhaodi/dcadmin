<?php
namespace app\api\controller;

class Login extends Pubuliccon
{
    //添加分类结构
    public function index()
    {
        $data = input();
        if (!empty($data)) {
            dump($data);
        }




    }



}
