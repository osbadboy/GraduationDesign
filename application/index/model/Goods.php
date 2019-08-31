<?php
namespace app\index\model;

use think\Model;
use think\Db;

class Goods extends Model {

    private function __clone(){} //禁止被克隆


    //查找商品
    public static function  fuzzyquery( $name ) {
        //select返回的是数组json对象,find返回单个json对象
        $res = db('s_goods')->where('g_state',0)->where('g_name','like','%'.$name.'%')->select();
        return $res;
    }

    //商品详情页
    public static function gdetails( $num ) {
        //根据主键查找该商品所有信息
        $res = db('s_goods')->where('g_state',0)->where('g_num',$num)->find();
        $inc = db('s_goods')->where('g_state',0)->where('g_num',$num)->setInc('g_views',1);
        if(!$res) {
            return null;
        }
        return $res;
    }


    //发布商品
    public static function publish_goods( $arr ) {
        //根据主键查找该商品所有信息
        $res = db('s_goods')->insert($arr);
        if($res) {
            return 1;
        }
        return 0;
    }

    //我的发布
    public static function my_publish($name) {
        //根据传入的用户名查询该用户名下的所以已发布商品
        $res = db('s_goods')->where('g_publisher',$name)->select();
        return $res;
    }
    
    //删除商品
    public static function del_goods($num) {
        $re = db('s_goods')->field('g_picpath')->where('g_num',$num)->find();
       if($re['g_picpath']) {
        $path = str_replace("\\","/",APP_PATH . $re['g_picpath']);
        if(file_exists($path)) {
            unlink($path);
        }

       }
        $res = db('s_goods')->where('g_num',$num)->delete();
        return $res;
    }
    //修改商品
    public static function change_goods($arr) {
        $res =  db('s_goods')->where('g_num',$arr['g_num'])->data($arr['arr'])->update();
        if($res == 0) {
            return 0;
        }
        return $res;
    }

    //所有未下架的商品信息
    public static function all_info() {
        $res = db('s_goods')->where('g_state',0)->alias('a')->join('s_people b ','b.p_acount= a.g_publisher')->select();
        return $res;
    }

}

