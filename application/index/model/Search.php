<?php
namespace app\index\model;

use think\Model;
use think\Db;

class Search extends Model {

    private function __clone(){} //禁止被克隆

    public static function save_words($key) {
        $res = db('s_search')->data(['s_acount'=>session('acount'),'s_keyword'=>$key,'s_time'=>date('Y-m-d H:i:s')])->insert();
        return $res;
    }

    public static function history() {
        $res = db('s_search')->field('s_keyword')->where('s_acount',session('acount'))->limit(5)->order("s_time desc")->select();
        return json_encode($res);
    }
   
}

