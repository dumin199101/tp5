<?php
/**
 * ============================================================================
 * Created by PhpStorm.
 * User: dd
 * Date: 2018/8/3
 * Time: 15:04
 * ============================================================================
 * $Author:lieyan123091
 */


namespace app\index\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'name'=>'require|max:25|checkName:think',
        'age'=>'integer'
    ];

    protected $message = [
        'name.require'=>'姓名必填',
        'name.max'=>'x姓名最大长度为25',
        'name.age'=>'年龄必须为整数',
        'name.checkName'=>'名称必须为'
    ];

    //自定义验证规则：
    protected function checkName($value,$rule,$data){
        if($value==$rule){
            return True;
        }else{
            return false;
        }
    }

    //自定义验证场景
    protected $scene = [
        'edit'=>['name']
    ];
}