<?php
/**
 * Created by PhpStorm.
 * User: buzha
 * Date: 2017/7/27
 * Time: 13:48
 */
namespace app\api\validate;

use think\Validate;

class Type extends Validate
{
    protected $rule = [
        //卖家id
        'sellerid'  =>  'require',
        //活动类型
        'type'=>'require|number',
        //密码 必填 能是汉字、字母、数字和下划线_及破折号- 6-25位
        'description'=>'require|min:2|max:25|unique:supports',
        'fullprice'=>'require|number',
        'subtraction'=>'require|number',
        'discount'=>'require|number',
        'special'=>'require|number'
    ];
    protected $message = [
        'phone./^1\d{10}$/' => '请输入正确的手机号',
        'description.require'=>'分类名称必填',
        'description.min:2'=>'分类名称不能小于2位',
        'description.unique'=>'分类名称已经存在，换个名字吧',
        'fullprice.require'=>'满的金额必填',
        'subtraction.require'=>'减的金额必填',
        'discount.require'=>'请选择折扣',
        'special.number'=>'特价必须是纯数字',
    ];
    protected $scene = [
        'addnormal' => ['sellerid','type','description'],
        'addfullsubtraction' => ['sellerid','type','description','fullprice','subtraction'],
        'addiscount'=>['sellerid','type','description','discount'],
        'addspecial'=>['sellerid','type','description','special']
    ];

}