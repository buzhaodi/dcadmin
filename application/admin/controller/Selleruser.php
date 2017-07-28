<?php
namespace app\admin\controller;

class Selleruser extends \think\Controller
{
   public function index(){
       $user=db("user")->select();
       foreach ($user as $k=>$v){
           $temp=explode(",",$v['avatar']);
           $temp=array_filter($temp);
           $user[$k]['avatar']=$temp[0];
       }


        $this->assign("users",$user);
        return $this->fetch();
   }
//   添加用户
   public function useradd(){
       $data=input();
       if($data){
           $validate = validate('User');
           if(!$validate->check($data)){
              return $this->error($validate->getError());
           }
           if($data['repassword']!=$data['password']){
               return $this->error('两次密码输入不一致');
           }
           unset($data['repassword']);
           $data['password']=nymd5($data['password']);
           $res=db("user")->insert($data);

           $res ? $this->success("添加成功"):$this->error("验证成功但添加失败");

           exit();
       }

        return $this->fetch();
    }

    public function usermod(){
        $id=input("id");
        $data=input("post.");
        if($data){
            $validate = validate('User');
            if(!$validate->scene('edit')->check($data)){
                return $this->error($validate->getError());
            }
            if($data['repassword']!=$data['password']){
                return $this->error('两次密码输入不一致');
            }
            unset($data['repassword']);
            $data['password']=nymd5($data['password']);
            $res=db("user")->update($data);

            $res ? $this->success("添加成功"):$this->error("验证成功但添加失败");

            exit();
        }
         $res= db("user")->find($id);

        $this->assign("user",$res);

        return $this->fetch();
    }
}
