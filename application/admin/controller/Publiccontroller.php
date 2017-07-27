<?php
/**
 * Created by PhpStorm.
 * User: buzha
 * Date: 2017-02-24
 * Time: 17:47
 */
namespace app\admin\Controller;

class Publiccontroller{
    public function _initialize(){
        $request = \think\Request::instance();
        define('MODULE_NAME', $request->module());
        define('CONTROLLER_NAME', $request->controller());
        define('ACTION_NAME', $request->action());

        $uid=$_SESSION['user']['id'];
        //验证登陆状态

        if(empty(!$_SESSION['user']['id'])){
            $status=M("user")->field("c_status")->where("id={$_SESSION['user']['id']}")->find();
        }


        if(empty($uid)||$status['c_status']==2){


            if(debugmoshi){
                $this->redirect("Login/index");
            }
            else{
                $this->error("请先登录",U("Login/index"));
            }



            exit();
        }

//状态 0正常 1关闭 2锁定





        if($uid==1){  //超级管理员
            return true;
        }

        $auth= new \Think\Auth();




        $rule=CONTROLLER_NAME.'/'.ACTION_NAME; //获取当前的控制器名和方法名

        if(!$auth->check($rule,$uid)){
            $this->error("你没有权限");
        }

    }
}