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


}
