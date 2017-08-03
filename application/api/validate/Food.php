<?php
/**
 * Created by PhpStorm.
 * User: buzha
 * Date: 2017/7/27
 * Time: 13:48
 */
namespace app\api\validate;

use think\Validate;

class Food extends Validate
{
    protected $rule = [
        'sellerid'  =>  'require',
        //菜名
        'name'  =>  'require',
        //菜的价格
        'price'=>'require|number',
        'description'=>'require|max:30',
        'info'=>'require|min:5',
        'image'=>'require|min:5',
        'icon'=>'require|min:5',
        //菜名类型
        'type'=>'require|number'
    ];
    protected $message = [
        'sellerid.require' =>'请登录',
        'name.require' => '菜名必须填写',
        'price.require'=>'价格必须填写',
        'price.number'=>'价格必须是数字',
        'description.require'=>'一句话描述必填',
        'description.max:30'=>'一句话描述最多30个字',
        'info.require'=>'详细介绍必填 最少5个字',
        'info.min:5'=>'详细介绍必填 最少5个字',
        'image.require'=>'请上传图片',
        'icon.require'=>'请上传图片',
        'type.require'=>'请选择分类',
    ];

}