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
        'description'=>'require|min:2|max:25',
        'fullprice'=>'require|number',
        'subtraction'=>'require|number',
        'discount'=>'require|number',
        'special'=>'require|number'
    ];
    protected $message = [
        'phone./^1\d{10}$/' => '请输入正确的手机号'

    ];
    protected $scene = [
        'addnormal' => ['type','description'],
        'addfullsubtraction' => ['type','description','fullprice','subtraction'],
        'addiscount'=>['type','description','discount'],
        'addspecial'=>['type','description','special']
    ];

}