<?php
namespace app\index\controller;

use think\Controller;
use think\Db;


class Login extends Controller {
    //定义子类的构造方法覆盖父类的重定向
    public function __construct() {
        parent::__construct();
    }

    public function index() {
       return $this->fetch(); 
    }
    public function login(){
        //获取post 提交的数据
        $acount = input('post.acount');
        $password = input('post.password');
        $res1 = Db::name('s_people')->where('p_acount', $acount)->find();
        $res2 = Db::name('s_people')->where('p_password', $password)->find();
        if(!$res1){
            exit(json_encode(array('code'=>0,'msg'=>'用户不存在')));
        }
        if(!$res2){
            exit(json_encode(array('code'=>0,'msg'=>'密码输入错误！')));
        }
        session('acount',null);
        session('acount',$acount);
        exit(json_encode(array('code'=>1,'msg'=>'登录成功！')));
    }
}