<?php
/**
 * Created by PhpStorm.
 * User: buzha
 * Date: 2017/7/27
 * Time: 13:48
 */
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        //用户名 必填 只能是字母和汉字的组合 25位以内
        'username'  =>  'require|alphaNum|max:25',
        //商家名 必填 只能是汉字和字母
        'name'=>'require|chsAlpha',
        //密码 必填 能是汉字、字母、数字和下划线_及破折号- 6-25位
        'password'=>'require|chsDash|min:6|max:25',
        'repassword'=>'require|chsDash|min:6|max:25',
        'phone'=>'require|/^1\d{10}$/',
        'avatar'=>'require',
        'pics'=>'require'
    ];
    protected $message = [
        'phone./^1\d{10}$/' => '请输入正确的手机号'

    ];
    protected $scene = [
        'edit'  =>  ['username','name','password'=>'chsDash|min:6|max:25','repassword'=>'chsDash|min:6|max:25','phone','avatar','pics'],
    ];

}