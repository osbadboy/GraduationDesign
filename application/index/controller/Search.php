<?php
namespace app\index\controller;

use app\index\model\Search as SearchModel;
use app\index\controller\Common;
use think\Request;

class Search extends Common {
    //禁止未登录访问
    public function __construct() {
        parent::__construct();
    }
    //搜索信息
    public function save_words(Request $request) {
        $key = $request->param("key");
        $res = SearchModel::save_words($key);
        if($res) {
            return json_encode(array('code'=>1,'msg'=>'已加入关键字'));
        }
        return 0;
    }

    //历史搜索
    public function history_words(){
        $res = SearchModel::history();
        return $res;
    }


}