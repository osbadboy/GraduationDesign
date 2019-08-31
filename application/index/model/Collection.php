<?php
namespace app\index\model;

use think\Model;
use think\Db;

class Collection extends Model {

    private function __clone(){} //禁止被克隆
    
    public static function my_collection($name) {
        $re = Db::table('s_collection')->where(['c_name'=>$name,'g_state'=>0])->alias('a')->join('s_goods b ','b.g_num= a.c_gnum')->select();
        if($re) {
            return $re;
        }
        return 0;//数据库查询失败
    }   

    //初始化
    public static function before_add($arr) {
        $res = db('s_collection')->where($arr)->find();
        if($res) {
            return 1;
        }
        return 0;//为已经收藏
    }    
    //添加收藏
    public static function add_store($arr) {
        $res = db('s_collection')->where($arr)->find();
        if(!$res) {
            $re = db('s_collection')->insert($arr);
            return $re;
        }
        return 0;//为已经收藏
    }

    //取消收藏
    public static function delete_store($num) {
        $res = db('s_collection')->where('c_gnum',$num)->find();
        if($res) {
            $re = db('s_collection')->where('c_gnum',$num)->delete();
            return $re;
        }
        return 0;//没有记录
    }



}

