<?php
namespace app\fapi\controller;

use think\Db;

class Seller extends Pubuliccon
{

    //获得分类列表信息
    public function index()
    {
        $data=input();
        if(empty($data)){
            return json([]);
        }
        $id=$data['id'];
        $res= Db::name('user')->find($id);
        //这个地方因为数据库尽量不存0 所以要转换一下
        $supports=Db::name('supports')->field('`type`-1 as type,`description`')->where('sellerid',$id)->where('type!=-1')->select();

        $res['avatar']= substr( $res['avatar'],0,strlen( $res['avatar'])-1);
        $res['avatar']='http://'.$_SERVER['HTTP_HOST'].$res['avatar'];
        $res['score']=$res['sumscore']/$res['sumpople'];
        $res['serviceScore']=$res['servicescore']/$res['servicepople'];
        $res['foodScore']=$res['foodscore']/$res['foodpople'];
        $res['ratingCount']=$res['servicepople'];

        //sellCount 月售 还没写
        $res['supports']=$supports;
        $res['pics']=array_filter(explode(",",$res['pics']));
        foreach ($res['pics'] as &$v){
            $v='http://'.$_SERVER['HTTP_HOST'].$v;
        }

        $res['infos']=array_filter(explode("-",$res['infos']));
        return json(['data'=>$res,'errno'=>0]);
    }

}


