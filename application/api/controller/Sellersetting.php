<?php
namespace app\api\controller;

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

            if (!$validate->scene($valitype[$temptype])->check($data)) {

                $res=['status'=>'error','msg'=>$validate->getError()] ;

                return json($res);
            }
           $res= db("supports")->insert($data);
            if($res){
                $res=['status'=>'success','msg'=>'添加成功'] ;

                return json($res);
            } else{
                $res=['status'=>'error','msg'=>'数据库添加失败'] ;

                return json($res);
            }
        }

    }

}
