<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Register extends Controller {
    //定义子类的构造方法覆盖父类的重定向
    public function __construct() {
        parent::__construct();
    }

    public function index() {
       return $this->fetch(); 
    }
    public function login(){
        $res = request();
        dump($res->param('name'));
    }
    //检查注册时账号是否已经存在于数据库
    public function checkname() {
       $name = trim(input('post.name'));
       //向数据库查询用户名是否存在
       $res = Db::table('s_people')
            ->where(function ($query) use($name){
                $query->where('p_acount','=',$name);

            })
            ->value('p_acount');
        if($res == $name) {
            return 1;
        }else{
            return 0;
        }
       
    }
    //注册功能
    public function register() {
        //获取post提交的数据
        $params = input('post.');
        $res = [];
        $res['p_acount'] = $params['acount'];
        $res['p_password'] = $params['password'];
        $res['p_username'] = $params['username'];
        $res['p_realname'] = $params['realname'];
        $res['p_phone'] = $params['phone'];

        //像表中插入数据
        $state = Db::name('s_people')
        ->data($res)
        ->insert();
        if($state) {
            session('acount',null);
            session('acount',$res['p_acount']);
            return 1; //1  标识插入成功
        }
        return 0;   //插入失败
    }
}