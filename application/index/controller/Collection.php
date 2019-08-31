<?php
namespace app\index\controller;

use app\index\model\Collection as CollectionModel;
use app\index\controller\Common;
use think\Request;

class Collection extends Common {
    //禁止未登录访问
    public function __construct() {
        parent::__construct();
    }

    public function index() {


        return $this->fetch();
    }

    //查询我的所有收藏
    public function my_collection(){
        $name = session('acount');
        $res= CollectionModel::my_collection($name);
        $res = json_encode($res);
        if($res) {
            return $res;
        }
        return 0;//控制器错误
    }

    //先查询是否已经被收藏
    public function before_add(Request $request) {
        $num = $request->param("num");
        $name = $request->param("name");
        $arr = ['c_gnum'=>$num,'c_name'=>$name,'c_gstate'=>0];
        $res = CollectionModel::before_add($arr);
        if($res) {
            return 1;
        }
        return 0;
    }

    //添加收藏
    public function add_store(Request $request) {
        $num = $request->param("num");
        $name = $request->param("name");
        $arr = ['c_gnum'=>$num,'c_name'=>$name,'c_time'=>date("Y-m-d  H:i")];
        $res = CollectionModel::add_store($arr);
        if($res) {//收藏成功
            return json_encode(array('code'=>1,'msg'=>'已添加到我的心愿单'));
        }
        return 0;//系统错误
    }
    //取消收藏
    public function  delete_store(Request $request) {
        $num = $request->param("num");
        $res = CollectionModel::delete_store($num);
        if($res) { //删除成功
            return json_encode(array('code'=>1,'msg'=>'已取消收藏'));
        }
        return 0;//系统错误
    }
}