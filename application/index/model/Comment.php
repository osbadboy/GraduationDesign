<?php
namespace app\index\model;

use think\Model;
use think\Db;

class Comment extends Model {

    private function __clone(){} //禁止被克隆
    
    //插入商品建议
    public static function  putc( $com ) {
        //select返回的是数组json对象,find返回单个json对象
        $res = db('s_comment')->insert($com);
        return $res;
    }


   //查询商品评论
   public static function  query_comment( $num ) {
    //select返回的是数组json对象,find返回单个json对象
    $res = db('s_comment')->where('c_gnum',$num)->select();
    return $res;
}
    


}

