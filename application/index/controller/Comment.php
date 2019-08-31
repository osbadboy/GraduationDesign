<?php
namespace app\index\controller;

use app\index\model\Comment as CommentModel;
use think\Controller;
use think\Request;


class Comment extends Controller {
    //发表评论
    public function put_comment(Request $request) {
        $comment = $request->param('comment');
        $g_num = $request->param('g_num');
        $date = date("Y-m-d H:i:s");
        $p_name = session("acount");
        $arr = ['c_gnum'=>$g_num,'c_pname'=>$p_name,'c_content'=>$comment,'c_puttime'=>$date];

        $res = CommentModel::putc($arr);
        if($res) {
            return 1;
        }
        return 0;

    }

    //呈现评论
    public function show_comment(Request $request) {
        $comment = input('get.g_num');
        $res = CommentModel::query_comment($comment);
        if(!$res) {
            return 0;
        }
        return json_encode($res);
    }
    
}