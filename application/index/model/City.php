<?php
/**
 * ============================================================================
 * Created by PhpStorm.
 * User: dd
 * Date: 2018/7/31
 * Time: 16:11
 * ============================================================================
 * $Author:lieyan123091
 */


namespace app\index\model;


use think\Model;

class City extends Model
{
   protected $pk = 'id';

    /**
     * 关联模型：一对多
     */
   public function user(){
       return $this->hasMany('User','city_id','id');
   }
}