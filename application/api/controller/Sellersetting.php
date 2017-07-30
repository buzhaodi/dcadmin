<?php
namespace app\api\controller;

use think\Db;

class Sellersetting extends Pubuliccon
{


    //添加分类结构
    public function addtype()
    {
        $data = input();


        if (!empty($data['type'])) {

            $data['type'] == "-1" ? $temptype = '0' : $temptype = $data['type'];

            $valitype = ['addnormal', 'addfullsubtraction', 'addiscount', 'addspecial'];


            $validate = validate('Type');
            $data['sellerid']=session("user")['id'];

            if (!$validate->scene($valitype[$temptype])->check($data)) {

                $res=['status'=>'error','msg'=>$validate->getError()] ;

                return json($res);
            }
           $res= Db::name("supports")->insertGetId($data);
            if($res){
                $res=['status'=>'success','msg'=>'添加成功','id'=>$res] ;

                return json($res);
            } else{
                $res=['status'=>'error','msg'=>'数据库添加失败'] ;

                return json($res);
            }
        }

    }
    //获取分类
    public function gettype(){
        $id=session("user")['id'] ? session("user")['id'] :false;
        if(!$id){
            return config('tologin');
        }
       $res= Db::name("supports")->where("sellerid",$id)->select();
        return json($res);
    }

}
