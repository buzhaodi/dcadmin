<?php
namespace app\api\controller;

use think\Db;

class Menu extends Pubuliccon
{

    //获得分类列表信息
    public function gettype()
    {
        $res=Db::name('supports')->field("description as name,id as value,type as parent")->where("sellerid",session("user")['id'])->select();
  //      $res=Db::name('supports')->field("description as name,id as value,type as parent")->select();
        $end=array(['name'=>'常规','value'=>'normal','parent'=>'0'],['name'=>'满减','value'=>'full','parent'=>'0'],['name'=>'折扣','value'=>'dis','parent'=>'0'],['name'=>'特价','value'=>'sp','parent'=>'0']);
        foreach ($res as $k=>$v){
            switch ($v['parent']){
                case '-1':
                $v['parent']='normal';
                break;
                case '1':
                    $v['parent']='full';
                    break;
                case '2':
                    $v['parent']='dis';
                    break;
                case '3':
                    $v['parent']='sp';
                    break;
            }

            $v['value'] = "{$v['value']}";



            $end[]=$v;
        }
        return json($end);
    }
    //添加菜品
    public function addfood(){
        $data=input();
        if(empty($data)){
            return json([]);
        }

        $data['sellerid']=session('user')['id'];
        $validate = validate('Food');
       if(!$validate->check($data)){
           return json(['status'=>'error','msg'=>$validate->getError()]);
       }
       else{
           $name=$data['name'];
           $reres=Db::name('foods')->where("name",$name)->where("sellerid",session('user')['id'])->find();
           if(!empty($reres)){
               return json(['status'=>'error','msg'=>'商品名称不能重复']);
           }
           $res=Db::name('foods')->insert($data);
           if($res){
               return json(['status'=>'success','msg'=>'添加成功']);
           }else{
               return json(['status'=>'error','msg'=>'添加数据出错']);
           }

       }

    }
    //获得菜品
    public function getfoods(){

        $type=empty(input()['typeid']) ? '%' :input()['typeid'];

        if($type=='%'){
            $res= Db::name('foods')->where("sellerid",session('user')['id'])->select();

        }else{
            $res= Db::name('foods')->where("sellerid",session('user')['id'])->where('type',$type)->select();

        }


       foreach ($res as $k=>$v){
           $res[$k]['src']=$v['icon'];
           $res[$k]['title']=$v['name'];
           $res[$k]['desc']=$v['description'];
           $res[$k]['url']='/menu/mod/'.$v['id'];
       }
       return json($res);
    }
    public function addimg(){
        //获得上传的图片
        $image = \think\Image::open(request()->file('img'));
        $name=time().rand(100,99999);
        //处理图片
        $image->thumb(750, 750,\think\Image::THUMB_SCALING )->save('./public/uploads/menu/'.$name.'.png');
        $image->thumb(150, 150,\think\Image::THUMB_SCALING )->save('./public/uploads/menu/'.$name.'small.png');
       //返回数据
        $data['url']="http://".$_SERVER['HTTP_HOST'].'/public/uploads/menu/'.$name.'.png';
        $data['urlsmall']="http://".$_SERVER['HTTP_HOST'].'/public/uploads/menu/'.$name.'small.png';
        $res['data']=$data;
        return json($res);
    }
}
