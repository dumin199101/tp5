<?php

namespace app\index\controller;

use app\index\model\City;
use app\index\model\Role;
use app\index\model\User;
use org\Test;
use think\Controller;
use think\db\Query;
use think\Env;
use think\Loader;
use think\Request;
use think\Db;
use think\Validate;

class Index extends Controller
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }

    /**
     * 测试驼峰法控制器路由访问
     */
    public function blogTest()
    {
        return 'Hello World';
    }

    /**
     * extend目录自动注册命名空间测试
     */
    public function sayHelloTest()
    {
        $Test = new \my\Test();
        $Test->sayHello();
    }

    /**
     * 应用公共文件手动注册命名空间测试,以index.php为入口文件
     */
    public function sayHelloTest2()
    {
        $Test = new Test();
        $Test->sayHello();
    }

    /**
     * 扩展配置目录extra，自动加载，所有新添加配置可以放在这个目录下。extra_config_list参数被废弃。
     * 环境变量配置：根目录下.env文件，采用.ini格式。
     */
    public function testEnv()
    {
        return Env::get('app.debug');
    }

    /**
     * 先跳过路由模块
     */


    /**
     * 前置操作
     */
    protected $beforeActionList = [
        'first',
        'second' => ['except' => 'hello'],
        'three' => ['only' => 'hello,data']
    ];


    protected function first()
    {
        echo 'first<br/>';
    }

    protected function second()
    {
        echo 'second<br/>';
    }

    protected function three()
    {
        echo 'three<br/>';
    }

    public function hello()
    {
        return 'hello';
    }

    public function data()
    {
        return 'data';
    }

    /**
     * 跳转重定向测试
     * 无需使用url方法生成
     * 正确/错误模板配置：
     *    dispatch_success_tmpl
     *    dispatch_error_tmpl
     * 记住上次URL,并跳转：remember(),restore()
     */
    public function testRedirect()
    {
//        $this->success('成功了，跳转到百度','https://www.baidu.com');
//        $this->error('出错了，百度一下吧！','https://www.baidu.com');
        $this->redirect('https://www.baidu.com');

    }

    /**
     * Request请求测试：
     * 获取pathinfo参数要使用param方法，不要使用get方法。
     * 或者使用input助手函数
     * 使用变量修饰符进行过滤
     */
    public function testRequest()
    {
        //实例化
        $request = Request::instance();
        // 获取当前域名
        echo 'domain: ' . $request->domain() . '<br/>';
        // 获取当前入口文件
        echo 'file: ' . $request->baseFile() . '<br/>';
// 获取当前URL地址 不含域名
        echo 'url: ' . $request->url() . '<br/>';
// 获取包含域名的完整URL地址
        echo 'url with domain: ' . $request->url(true) . '<br/>';
// 获取当前URL地址 不含QUERY_STRING
        echo 'url without query: ' . $request->baseUrl() . '<br/>';
// 获取URL访问的ROOT地址
        echo 'root:' . $request->root() . '<br/>';
// 获取URL访问的ROOT地址
        echo 'root with domain: ' . $request->root(true) . '<br/>';
// 获取URL地址中的PATH_INFO信息
        echo 'pathinfo: ' . $request->pathinfo() . '<br/>';
// 获取URL地址中的PATH_INFO信息 不含后缀
        echo 'pathinfo: ' . $request->path() . '<br/>';
// 获取URL地址中的后缀信息
        echo 'ext: ' . $request->ext() . '<br/>';

        echo "当前模块名称是" . $request->module();
        echo "当前控制器名称是" . $request->controller();
        echo "当前操作名称是" . $request->action();

        $name = $request->param('name');
        echo $name;
//        $age = $request->get('age');
        $age = $request->param('age');
        echo $age;
    }


    /**
     * 数据库
     * 原生方法：query,execute
     */
    public function testDb(){
        $db = Db::query('select * from think_user where id=?',[1]);
        dump($db); //返回值为数组
        $db2 = Db::query('select * from think_user where id=:id',['id'=>1]);
        dump($db2);
        $res = Db::execute('insert into think_user (id, name) values (?, ?)',[5,'thinkphp']);
        dump($res);
        $res2 = Db::execute('insert into think_user (id, name) values (:id, :name)',['id'=>6,'name'=>'thinkphp2']);
        dump($res2); //返回值为1
    }

    /**
     * 查询构造器：或者使用db助手函数进行查询
     */
    public function testDb2(){
        //表名必须为全称
        $db = Db::table('think_user')->where('id',1)->find();
        dump($db);
        $db2 = Db::table('think_user')->where('age',30)->select();
        dump($db2);
        //设置了表前缀
        $db3 = Db::name('user')->where('id',1)->find();
        dump($db3);
        //使用db助手函数：
        $db4 = db('user',[],false)->where('id',1)->find();
        dump($db4);
        //使用Query对象
        $query = new Query();
        $db5 = $query->table('think_user')->where('id',1)->find();
        dump($db5);
        //使用闭包查询：
        $db6 = Db::select(function($query){
            $query->table('think_user')->where('id',1);
        });
        dump($db6);
        //查询列跟值
        $db7 = Db::table('think_user')->column('name');
        dump($db7);
        //指定索引:键值方式
        $db8 = Db::table('think_user')->where('id',1)->column('name','id');
        dump($db8);
        $db9 = Db::table('think_user')->where('id',1)->column('name,id');
        dump($db9);
        $db10 = Db::table('think_user')->where('id',1)->value('name');
        dump($db10);
        echo '<hr/>';
        //数据集分批处理：适用于大数据量的数据
        $db11 = Db::table('think_user')->chunk(2,function($users){
             foreach($users as $user){
                 dump($user);
             }
        });
    }

    /**
     * 添加数据
     */
    public function testDb3()
    {
        $data = [
            'name'=>'小夏',
            'age'=>44
        ];
        $res = Db::name('user')->insert($data);
        dump($res); //返回值为1
        dump(Db::name('user')->getLastInsID()); //获取自增ID
    }

    public function testDb4(){
        $data = [
            ['name'=>'小夏', 'age'=>44],
            ['name'=>'小催', 'age'=>14],
            ['name'=>'小冯', 'age'=>34],
            ['name'=>'小秦', 'age'=>24],
        ];
        $res = Db::name('user')->insertAll($data);
        dump($res); //返回插入成功的条数
    }

    //更新数据：
    public function testDb5()
    {
        Db::table('think_user')->update(['name' => '晓菲','id'=>8]);
        Db::table('think_user')->where('id',7)->setField(['name' => '小白']);
        // age 字段加 5
        Db::table('think_user')->where('id', 1)->setInc('age', 5);
        Db::table('think_user')->where('id', 2)->setDec('age', 5);

    }

    //删除数据
    public function testDb6()
    {
        Db::table('think_user')->delete([2,3]);
        Db::table('think_user')->where('id',1)->delete();
    }

    //条件查询
    public function testDb7()
    {
          // AND条件查询
          $res  = Db::table('think_user')
            ->where('name','thinkphp')
            ->where('age',30)
            ->select();
          dump($res);

          //多字段相同条件AND查询
          $res = Db::table('think_user')
              ->where('name&desc','like','%thinkphp%')
              ->select();
          dump($res);

          //OR条件查询
          $res = Db::table('think_user')
              ->where('name','like','%thinkphp%')
              ->whereOr('age',44)
              ->select();
          dump($res);

        //多字段相同条件OR查询
        $res = Db::table('think_user')
            ->where('name|desc','like','%thinkphp%')
            ->select();
        dump($res);

        // 混合查询
        $res = Db::table('think_user')
            ->where(function($query){
                 $query->where('id',10)->whereOr('id',11);
            })->whereOr(function($query){
                 $query->where('name','like','thinkphp')->whereOr('name','like','小白');
            })->select();

        dump($res);

        //表信息：
        $res = Db::getTableInfo("think_user");
        dump($res);
        // 获取`think_user`表所有字段
        $res = Db::getTableInfo('think_user', 'fields');
        dump($res);
        // 获取`think_user`表所有字段的类型
        $res = Db::getTableInfo('think_user', 'type');
        dump($res);
        // 获取`think_user`表的主键
        $res = Db::getTableInfo('think_user', 'pk');
        dump($res);
    }

    //查询语法
    public function testDb8()
    {
        $res = Db::table('think_user')
            ->where('age','>',30)
            ->select();
        dump($res);

        $res = Db::table('think_user')
            ->where('age','in','14,34,24')
            ->select();
        dump($res);

        //exp表达式：支持SQL语法
        $res = Db::table('think_user')
            ->where('age','exp','IN (14,34,24)')
            ->select();
        dump($res);
    }

    //链式操作：

    /**
     * 创建数据表think_user_1 - think_user_10 共计10张表
     * 按照id的模数分表，取得的结果做+1操作。
     */
    public function testDb9()
    {
        //partition 方法用于是数据库水平分表
        // $data 分表字段的数据
        // $field 分表字段的名称
       // $rule 分表规则
        $data = [
            'id'=>12,
            'name'=>'诸葛亮',
            'age'=>50,
            'desc'=>'蜀国丞相'
        ];
        $rule = [
            'type' => 'mod', // 分表方式
            'num'  => 10     // 分表数量
        ];
        Db::name('user')
            ->partition(['id'=>12],'id',$rule)
            ->insert($data);

    }

    /**
     * 获取分表数据
     */
    public function testDb10()
    {

        $rule = [
            'type' => 'mod', // 分表方式
            'num'  => 10     // 分表数量
        ];

        $res = Db::name('user')
            ->partition(['id'=>11],'id',$rule)  //计算表
            ->where(['id' => 1])   //取数据
            ->select();

        dump($res);

        //直接返回SQL,不执行查询
        $result = Db::table('think_user')->fetchSql(true)->find(1);
        dump($result);

        //查询结果缓存
        $res = Db::table('think_user')->where('id=5')->cache(true,60)->find();
        dump($res);


    }

    /**
     * 聚合查询
     */
    public function testDb11()
    {
        $count = Db::name("user")->count();
        dump($count);
        $max = Db::name("user")->max("age");
        $min = Db::name("user")->min("age");
        $avg = Db::name("user")->avg("age");
        $sum = Db::name("user")->sum("age");
        dump($max);
        dump($min);
        dump($avg);
        dump($sum);
    }

    /**
     * 时间查询
     */
    public function testDb12()
    {
        // 大于某个时间
        where('create_time','> time','2016-1-1');
// 小于某个时间
        where('create_time','<= time','2016-1-1');
// 时间区间查询
        where('create_time','between time',['2015-1-1','2016-1-1']);

        // 大于某个时间
        Db::table('think_user')->whereTime('birthday', '>=', '1970-10-1')->select();
// 小于某个时间
        Db::table('think_user')->whereTime('birthday', '<', '2000-10-1')->select();
// 时间区间查询
        Db::table('think_user')->whereTime('birthday', 'between', ['1970-10-1', '2000-10-1'])->select();
// 不在某个时间区间
        Db::table('think_user')->whereTime('birthday', 'not between', ['1970-10-1', '2000-10-1'])->select();

        // 获取今天的博客
        Db::table('think_blog') ->whereTime('create_time', 'today')->select();
// 获取昨天的博客
        Db::table('think_blog')->whereTime('create_time', 'yesterday')->select();
// 获取本周的博客
        Db::table('think_blog')->whereTime('create_time', 'week')->select();
// 获取上周的博客
        Db::table('think_blog')->whereTime('create_time', 'last week')->select();
// 获取本月的博客
        Db::table('think_blog')->whereTime('create_time', 'month')->select();
// 获取上月的博客
        Db::table('think_blog')->whereTime('create_time', 'last month')->select();
// 获取今年的博客
        Db::table('think_blog')->whereTime('create_time', 'year')->select();
// 获取去年的博客
        Db::table('think_blog')->whereTime('create_time', 'last year')->select();

        // 获取今天的博客
        Db::table('think_blog')->whereTime('create_time', 'd')->select();
// 获取本周的博客
        Db::table('think_blog')->whereTime('create_time', 'w')->select();
// 获取本月的博客
        Db::table('think_blog')->whereTime('create_time', 'm')->select();
// 获取今年的博客
        Db::table('think_blog')->whereTime('create_time', 'y') ->select();

        // 查询两个小时内的博客
        Db::table('think_blog')->whereTime('create_time','-2 hours')->select();
    }

    /**
     * 事务处理
     */
    public function testDb13()
    {
        //启动事务
        Db::startTrans();
        try{
            $res = Db::table('think_user')->find(1);
            $res = Db::table('think_user')->delete(1);
            dump($res);
            //提交事务
            Db::commit();
        }catch (\Exception $e){
            dump(1);
            //回滚事务
            Db::rollback();
        }
    }
    
    /**
     * 模型测试
     */
    public function testDb14()
    {
        //静态调用(查询修改删除)：
        $user = User::get(4);
        dump($user);   //打印的是一个对象
        dump($user->name);

        //实例化调用（添加）
        $user = new User();
        $user->name = '小高';
        $user->age = 33;
        $user->desc = '辽宁人';
        $user->save();

        //使用助手函数
        $user = model('User');
        $user->name = '小郑';
        $user->age = 22;
        $user->desc = '河南人';
        $user->save();

        //使用Loader实例化：单例
        $user = Loader::model('User');
        $user->name = '小韩';
        $user->age = 34;
        $user->desc = '济南人';
        $user->save();

    }

    //使用模型添加数据
    public function testDb15()
    {
        //实例化时传入数据
        $user = new User([
            'name'=>'小卢',
            'age'=>23,
            'desc'=>'山西人',
            'tel'=>18874731222
        ]);
        //过滤非数据表字段：true,也可以通过数组方式指定添加的字段。
        $user->allowField(true)->save();

        //获取自增ID
        dump($user->id);
    }

    //使用模型添加数据2
    public function testDb16()
    {
        //批量添加
        $user = new User();
        $list = [
            ['name'=>'小刘','age'=>33,'desc'=>'北京人'],
            ['name'=>'小贺','age'=>36,'desc'=>'北京人'],
        ];
        $user->saveAll($list);
        //静态添加
        User::create([
            'name'=>'小篮',
            'age'=>33,
            'desc'=>'北京人'
        ]);
    }

    //模型更新
    public function testDb17()
    {
        //查找更新
        $user = User::get(4);
        $user->name = '小米';
        $user->save();

        //直接更新：
        $user = new User();
        $user->save(['name'=>'小雷'],['id'=>7]);

        //批量更新
        $user = new User();
        $list = [
            ['id'=>8,'name'=>'陈欧'],
            ['id'=>9,'name'=>'雷军']
        ];
        $user->saveAll($list);




    }

    public function testDb18()
    {
        $user = User::get(6);
        $user->name = 'lili';
        $user->age = 33;
        $user->desc = 'haha';
        $user->isUpdate(true)->save();

    }

    //模型删除
    public function testDb19()
    {
        $user = User::get(4);
        $user->delete();

        User::destroy([6,7]);

        //闭包删除
        User::destroy(function($query){
            $query->where('id',8);
        });

    }

    //模型查询

    /**
     * 返回当前模型的对象实例
     */
    public function testDb20()
    {
        //查询单个数据
        $user = User::get(9);
        dump($user->toArray());

        $user = User::get(['desc'=>'北京人']);
        dump($user->toArray());

        $user = User::get(function($query){
            $query->where('desc','北京人');
        });
        dump($user->toArray());

        //通过实例化查询
        $user = new User();
        $data = $user->where('id',9)->find();
        dump($data->toArray());
    }

    public function testDb21()
    {
        //查询多个数据
        $users = User::all([9,10,11]);
        foreach ($users as $user){
            dump($user->toArray());
        }

        //使用闭包
        $users = User::all(function($query){
            $query->where('desc','北京人');
        });
        foreach($users as $user){
            dump($user->toArray());
        }

        //通过实例化
        $user = new User();
        $data = $user->where('desc','北京人')->select();
        foreach($data as $d){
            dump($d->toArray());
        }
    }


    public function testDb22()
    {
        $data = User::where('id', 9)->value('name');
        dump($data);
        $data = User::where('desc','北京人')->column('name');
        dump($data);
        $data = User::where('desc','北京人')->column('id,name');
        dump($data);

        //返回单条数据
        $data = User::getByDesc('北京人');
        dump($data->toArray());

    }

    /**
     * 聚合
     */
    public function testDb23()
    {
        //静态调用
        $data = User::count();
        dump($data);
        //动态调用
        $user = new User();
        $data = $user->count();
        dump($data);
    }

    /**
     * 获取器:在获取数据的字段值后自动进行处理
     */
    public function testDb24()
    {
        $user = User::get(10);
        dump($user->status);
        dump($user->status_text); //获取数据表中不存在的字段
        dump($user->getData('status'));
        dump($user->getData()); //获取所有原始数据
    }

    /**
     * 修改器：在修改数据的时候自动处理
     */
    public function testDb25()
    {
        $user = User::get(10);
        $user->name = "Lili";
        $user->save();
    }

    /**
     * 自动写入时间戳
     */
    public function testDb26()
    {
        $user = new User();
        $user->name = 'Huuui';
        $user->age = 22;
        $user->desc = 'abceefg';
        $user->status = 0;
        $user->save();
    }
    
    /**
     * 软删除
     */
    public function testDb27()
    {
        User::destroy(20);
        $user = User::get(19);
        $user->delete();
    }

    public function testDb28(){
        $users = User::withTrashed()->select();
        $users = User::onlyTrashed()->select();
        $users = User::all();
        foreach($users as $user){
            dump($user->toArray());
        }
    }

    /**
     * 类型自动转换
     */
    public function testDb29()
    {
        $user = new User();
        $user->name = 'hahah0000';
        $user->age = '28';
        $user->desc = 'hhhhhhffds';
        $user->status = '1';
        $user->save();
        dump($user->age);
    }

    /**
     * 自动完成
     */
    public function testDb30()
    {
        $user = new User();
        $user->name = 'fdsf';
        $user->age = '22';
        $user->save();
    }

    /**
     * 范围查询
     */
    public function testDb31(){
//        $users = User::all();
        //动态关闭全局范围
//        $users = User::useGlobalScope(false)->select();
        //自定义范围查询
        $users = User::scope('Hello')->select();
        foreach ($users as $user){
            dump($user->name);
        }
    }

    /**
     * json序列化
     * hidden,visible
     */
    public function testDb32()
    {
        $user = User::get(22);
        dump($user->hidden(['create_time'])->toJson());
    }
    
    /**
     * 模型事件
     */
    public function testDb33()
    {
        $user = new User();
        $user->name = '2222';
        $user->age = 19;
        $user->save();
    }

    /**
     * 模型关联:一对一
     */
    public function testDb34()
    {
        //关联查询
        $user = User::get(11);
        dump($user->car); //返回的是Car模型的实例对象object(app\index\model\Car)，执行两次SQL，先查找这个人，再查找这个人所对应的车。
        dump($user->car->name);
        dump($user->car());//返回的是关联模型对象：object(think\model\relation\HasOne)，执行一次SQL，查找这个人。

        //关联新增：
        $user = new User();
        $user->name = '网管';
        $user->age = 22;
        if($user->save()){
            $car['name'] = '比亚迪';
            $user->car()->save($car);
            return '用户' . $user->name . '新增成功';
        }else{
            return $user->getError();
        }

        //关联更新：
        $user = User::get(24);
        $car['name'] = '荣威';
        $user->car->save($car);
        return "更新成功：" . $user->car->name;

        //关联删除：
        $user = User::get(24);
        if($user->delete()){
            $user->car->delete();
            return $user->name . 'Delete Success';
        }else{
            return $user->getError();
        }

    }

    /**
     * 模型关联：一对多
     */
    public function testDb35()
    {
        //关联查询：
        $city = City::get(1);
        foreach ($city->user as $user) {
            dump($user->name);
        }

        //关联查询加入条件
        $u = $city->user()->where('desc','辽宁人')->select();
        foreach ($u as $uu){
            dump($uu->name);
        }

        //关联添加：
        $city = new City();
        $city->name = '广州市';
        if($city->save()){
            $city->user()->save([
                'name'=>'刘婷',
                'age'=>33
            ]);
            return $city->name . '添加成功';
        }else{
            return $city->getError();
        }


        //批量添加
        $city = new City();
        $city->name = '荆州市';
        if($city->save()){
            $city->user()->saveAll([
                ['name'=>'刘婷', 'age'=>33],
                ['name'=>'刘小双', 'age'=>32]
            ]);
            return $city->name . '添加成功';
        }else{
            return $city->getError();
        }

        //关联修改：
        $city = City::get(6);
        $city->user()->where('status',1)->update(['status'=>0]);
        dump("更新成功");

        //关联删除
        $city = City::get(6);
        $city->user()->where('status',1)->delete();
        dump("删除成功");

    }

    /**
     * 关联模型：多对多
     */
    public function testDb36()
    {
         //关联查询：
         $user = User::get(10);
         foreach ($user->roles as $role){
             dump($role->name);
         }

         //关联新增：自动插入中间表
         $user = User::get(25);
         $user->roles()->save(['name'=>'运营管理']);

        //关联批量新增：
        $user = User::get(25);
        $user->roles()->saveAll(
            [
                ['name'=>'设计师'],
                ['name'=>'行政'],
            ]
        );

        //两个表数据都已经存在，往中间表添加：
        $user = User::get(23);
        $role = Role::get(4);
        $user->roles()->attach($role);

        //关联删除
        $user = User::get(23);
        $role = Role::get(4);
        $user->roles()->detach($role);

        $user = User::get(25);
        $role = Role::get(5);
        $user->roles()->detach($role,true); //只删除role,user_role
        
    }
    
    /**
     * 关联预载入
     */
    public function testDb37()
    {
        //执行了N+1次查询
        $list = User::all([9,10,11,12,13]);
        foreach($list as $user){
            // 获取用户关联的car模型数据
            dump($user->car);
        }

        //执行2次查询，全部为IN查询
        $list = User::with('car')->select([9,10,11,12,13]);
        foreach($list as $user){
            // 获取用户关联的car模型数据
            dump($user->car);
        }
    }
    
    /**
     * input
     * allowField(true)
     * validate(true)
     * 模型验证
     * 控制器验证
     * 自定义验证规则
     * 独立验证：new Validate()
     * 验证器验证：Loader::validate()/validate()助手函数
     */
    public function testDb38()
    {
        //1.独立验证
        $rules = [
            'name'=>'require|max:25',
            'age'=>'integer'
        ];
        $message = [
            'name.require'=>'名称必须',
            'name.max'=>'名称最大长度25',
            'name.age'=>'年龄必须为整数'
        ];
        $data = [
            'name'=>'think',
            'age'=>22
        ];
        $validate = new Validate($rules,$message);
        $validate->scene('edit',['name']);
        if(!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }



        //2.验证器验证
        $validate = Loader::validate('User');
        if(!$validate->check($data)){
            return $validate->getError();
        }

        //指定验证场景
        $validate->scene('edit')->validate('User');

        //3.控制器验证
        $this->validate($data,'User');
        //4.模型验证
        $user = new User();
        $user->allowField(true)->validate(true)->save($data);



    }

    //表单令牌
    public function testDb39()
    {
        dump(Request::instance()->token());
    }












}
