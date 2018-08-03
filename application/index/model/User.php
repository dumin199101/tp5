<?php
/**
 * ============================================================================
 * Created by PhpStorm.
 * User: dd
 * Date: 2018/7/26
 * Time: 16:54
 * ============================================================================
 * $Author:lieyan123091
 */


namespace app\index\model;


use think\Model;
use traits\model\SoftDelete;

class User extends Model
{
   //自定义主键
   protected $pk = 'id';
   //自定义表名
   protected $table = 'think_user';
   //自定义数据库连接
   protected $connection = [
       // 数据库类型
       'type'        => 'mysql',
       // 服务器地址
       'hostname'    => '127.0.0.1',
       // 数据库名
       'database'    => 'test',
       // 数据库用户名
       'username'    => 'root',
       // 数据库密码
       'password'    => 'lieyan123091@2017',
       // 数据库编码默认采用utf8
       'charset'     => 'utf8',
       // 数据库表前缀
       'prefix'      => 'think_',
       // 数据库调试模式
       'debug'       => true,
   ];

//   protected $resultSetType = 'collection';

   //模型初始化
    public function initialize()
    {
        parent::initialize();
//        dump("init");
        //模型事件
        User::event('before_insert',function($user){
            if($user->age<=20){
                return false;
            }
        });
    }

    //获取器:根据获取的字段数值进行自动处理
    public function getStatusAttr($value){
//        halt($value);
        $status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
        return $status[$value];
    }

    public function getStatusTextAttr($value,$data)
    {
//        dump($data);该实例的数据
        $status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
        return $status[$data['status']];
    }

    //修改器
    public function setNameAttr($value)
    {
        return "Hello: " . strtolower($value);
    }

    //自动写入时间戳：
    protected $autoWriteTimestamp = 'datetime';
    // 定义时间戳字段名
//    protected $createTime = 'create_at';
//    protected $updateTime = 'update_at';
    //设置只读字段,不可修改
    protected $readonly = [];
    //软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    //时间戳类型读取时的格式
//    protected $dateFormat = 'Y-m-d H:i:s';
    //类型转换
    protected $type = [
       'age'=>'integer',
       'status'=>'integer',
       'create_time'=>'datetime',
       'update_time'=>'datetime',
       'delete_time'=>'datetime',
    ];

    //自动完成：
    protected $auto = [];
    protected $insert = ['desc','status'=>1];
    protected $update = ['status'=>0];

    protected function setDescAttr(){
        return request()->ip() . 'Hello World';
    }

    //查询范围定义：

    //全局范围查询：
    protected function base($query)
    {
        $query->where('status',1);
    }

    //自定义范围查询
    protected function scopeHello($query){
        $query->where('name','like','%Hello%')->field('id,name');
    }


    //关联模型---一对一(正推反推都是一对一的关系，主键跟外键不在同一张表)
    public function car(){
        return User::hasOne("Car","user_id","id");
    }

    //关联模型：多对多
    public function roles(){
        return User::belongsToMany("Role","user_role","role_id","user_id");
    }

}