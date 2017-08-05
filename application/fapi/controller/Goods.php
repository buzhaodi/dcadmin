<?php

namespace app\fapi\controller;

use think\Db;

class Goods extends Pubuliccon
{

    //获得商品信息
    public function index()
    {
        $data = input();
        if (empty($data)) {
            return json([]);
        }
        $id = $data['id'];
        $res = Db::name('supports')->field('id,description as name,type')->where('sellerid', $id)->select();
        $foods = Db::name('foods')->where('sellerid', $id)->select();

        foreach ($res as $k => &$v) {
            $v['type'] > -1 ? $v['type'] = $v['type'] - 1 : '';
            foreach ($foods as $index => $item) {
                $v['id'] == $item['type'] ? $v['foods'][] = $item : '';
            }
            if (empty($v['foods'])) {
                unset($res[$k]);
            }
        }
        $res = array_values($res);


        return json(['data' => $res, 'errno' => 0]);
    }

    //计算价格
    public function comput()
    {
        $data = input();
        if (empty($data)) {
            return json([]);
        }
        if (empty($data['id'])) {
            return json(['status' => 'error', 'msg' => '请选择商家']);
        }
        if (empty($data['tableNumber'])) {
            return json(['status' => 'error', 'msg' => '赶紧找个座位坐下来']);
        }

        $foodid = '';
        foreach ($data['check'] as $key => $val) {
            $foodid .= $val['id'] . ',';
        }
        $foodid = substr($foodid, 0, strlen($foodid) - 1);

        $food = Db::name('foods')
            ->field('f.*,s.type,s.fullprice,s.subtraction,s.discount,s.special')
            ->alias('f')
            ->join('supports s', 'f.type=s.id')
            ->where('f.id', 'in', $foodid)
            ->select();
        $type = array_column($food, 'type');


        $count=[];
        foreach ($data['check'] as $item){
            $count[$item['id']]=$item['count'];
        }
        //总价
        $total=0;
        //含有特价商品或打折商品 特价和折扣可以一起结算 但是特价商品只能买一份
        if (in_array(2, $type) || in_array(3, $type)) {

            foreach ($food as $k=>$v){
                //折扣
                if($v['type']==2){
                    $total+=$count[$v['id']]*$v['price']*$v['discount']/100;
                }
                if($v['type']==3){
                    $total+=$v['special'];
                    if($count[$v['id']]>1){
                        $total+=($count[$v['id']]-1)*$v['price'];
                    }
                }else{
                    $total+=$count[$v['id']]*$v['price'];
                }

            }
            echo 1;
        }
        //有满减
        elseif(in_array(1,$type)&&(!in_array(2, $type)||!in_array(3, $type))){

            foreach ($food as $k=>$v){
                    $total+=$count[$v['id']]*$v['price'];
            }
            //找到要减免的金额
          $subtraction=  Db::name('foods')
                ->field('f.*,s.type,s.fullprice,s.subtraction,s.discount,s.special')
                ->alias('f')
                ->join('supports s', 'f.type=s.id')
                ->where('f.id', 'in', $foodid)
                ->where('s.fullprice','<',$total)
                ->order('s.fullprice desc')
                ->find();
            $subtraction=$subtraction['$subtraction'];
            echo 2;
        }
        //啥都没
        elseif(in_array(-1,$type)){
            foreach ($food as $k=>$v){
                $total+=$count[$v['id']]*$v['price'];
            }
            echo 3;
        }


    }


}


