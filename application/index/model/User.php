<?php
namespace app\index\model;

use think\Model;
use think\Db;

class User extends Model {

    private function __clone(){} //禁止被克隆

    public static function user_name($acount) {
        $res = db('s_people')->field('p_username')->where('p_acount',$acount)->find();
        return $res;
    }
    //用户信息，传入session
    public static function user_info( $acount ) {
        //根据主键查找该商品所有信息
        $res = db('s_people')->where('p_acount',$acount)->find();
        return $res;
    }
    
    //用户模型
    public static function user_in($num) {
        $res = db('s_people')->where('p_acount',$num)->find();
        return $res;
    }

    //修改资料
    public static function modify($arr) {
        $res = db('s_people')->where('p_acount',$arr['acount'])->data($arr['data'])->update();
        return $res;
    }
    //上传头像
    public static function upload($arr) {
        $res = db('s_people')->where('p_acount',$arr['acount'])->data(['p_photo'=>$arr['photo']])->update();
        return $res;
    }
    
    public static function query_pic_path($acount) {
        $res = db('s_people')->field('p_photo')->where('p_acount',$acount)->find();
        return $res;
    }

    public static function query_focus($str) {
        $res = db('s_focus')->where('f_a_user',session("acount"))->where('f_b_user',$str)->find();
        return $res;
    }

    public static function change_focus($arr) {
        if($arr['f_state'] == 1) {
            $res = db('s_focus')->where('f_a_user',$arr['f_a_user'])->where('f_b_user',$arr['f_b_user'])->update(['f_state'=>0]);
        }
        if($arr['f_state'] == 0) {
            $query_res = db('s_focus')->where('f_a_user',$arr['f_a_user'])->where('f_b_user',$arr['f_b_user'])->find();
            if($query_res) {
                $res = db('s_focus')->where('f_a_user',$arr['f_a_user'])->where('f_b_user',$arr['f_b_user'])->update(['f_state'=>1]);
            } else {
                $res = db('s_focus')->where('f_a_user',$arr['f_a_user'])->where('f_b_user',$arr['f_b_user'])->insert($arr);
            }
            
        }
        
        return $res;
    }

}

