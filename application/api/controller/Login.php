<?php
namespace app\api\controller;
use think\Db;
use Think\Model;

class Login extends Pubuliccon
{
    //添加分类结构
    public function index()
    {
        $data = input();
        if (empty($data)) {
            return json([]);
        }

         $map['username']=$data['username'] ? $data['username'] : "";
         $map['password']=nymd5($data['pwd']? $data['pwd'] : "");
        $res=Db::name("user")->where($map)->find();
        if($res){
            session("user",$res);
            return json(['status'=>'success','msg'=>'登录成功']);
        }
        else{
            return json(['status'=>'error','msg'=>'用户名或密码错误']);
        }



    }
     public function islogin(){
        if(session("user")){
            return json(['status'=>'success','msg'=>'登录成功']);
        }else{
            return json(['status'=>'error','msg'=>'用户名或密码错误']);
        }
     }



}
