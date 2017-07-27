<?php
namespace app\admin\controller;

class upload extends \think\Controller
{
   public function index(){

        return $this->fetch();
   }
   public function uploadimg(){

       // 获取表单上传文件
       $files = request()->file('file');
       foreach($files as $file){
           // 移动到框架应用根目录/public/uploads/ 目录下
           $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
           if($info){
               // 输出 42a79759f284b767dfcb2a0197904287.jpg

               $imagearr['Extension'][] = $info->getExtension();
               $imagearr['Filename'][]= $info->getSavename();
           }else{
               // 上传失败获取错误信息
               return json($file->getError());
           }
       }
       foreach ($imagearr['Filename'] as $k=>$v){
           $temp=str_replace("\\", '/', $v);
           $imagearr['Filename'][$k]="/public/uploads/".$temp;
       }
       $imagearr['status']="0";
       return json($imagearr);

    }
}
