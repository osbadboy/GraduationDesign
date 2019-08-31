<?php
namespace app\index\controller;

use app\index\model\Goods as GoodsModel;
use app\index\controller\Common;
use think\Request;

class Goods extends Common {
    
    //禁止未登录访问
    public function __construct() {
        parent::__construct();
    }

    //模板渲染，该商品详情页
    public function index(Request $request)
    {   
        $item = $request->param('g_num');
        $query = GoodsModel::gdetails($item);
        $this->assign('item',$query);
        return $this->fetch();
    }

    //商品添加页面
    
    public function addgoods() {
        return $this->fetch(); 
    }
    //商城页面
    public function mall() {
        return $this->fetch();
    }
    //商城获取所有未下架的商品信息
    public function all_info() {
        $res = GoodsModel::all_info();
        if($res) {
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode($res));
        }

        return json_encode(array('code'=>1,'msg'=>'数据路查询错误'));
    }

    //上传商品图片
    public function upload()
    {
        $img = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $img->rule("uniqid")->move('uploads/'.date('Ymd'));
        
       if($info) {
            $arr = array('status'=> 1, 'name' =>$info->getFilename());
            return $info->getFilename();
       }
       return 1; //上传

    }
    //发布商品
    public function add(Request $request) {
        $g_num =  date('YmdHisu');
        $g_price = $request->param('g_price');
        $g_name = $request->param('title');
        $g_category = intval($request->param('category'));
        $g_text_description = $request->param('describe');
        $img_name = $request->param('img_name');
        $g_picpath = '/uploads/'.date('Ymd').'/'.$img_name;
        $arr =[
            'g_num' => $g_num,
            'g_name' => $g_name,
            'g_category' => $g_category,
            'g_text_description' => $g_text_description,
            'g_price' => $g_price,
            'g_publisher' => session('acount'),
            'g_picpath' => $g_picpath,
            'g_pubtime' => date("Y-m-d H:i:s")
        ];
        //模型数据查询
        $res = GoodsModel::publish_goods($arr);
        if($res == 1) {
            return json_encode(array('code'=>1,'msg'=>'成功发布商品'));
        } else {
            unlink('/uploads/'.date('Ymd').'/'.$img_name);
            return json_encode(array('code'=>0,'msg'=>'系统错误'));
        }

        

    }
    
    //模糊查找商品
    public function searchgoods(Request $request) {
        $name = input('get.g_name');
        $query = GoodsModel::fuzzyquery($name);
        if(!$query) {
            return 0; //未查找到该类商品
        }
       return json_encode($query);  //返回数组对象
    }

    //我的发布
    public function publish() {
        return $this->fetch();
    }
    //我的发布数据接口
    public function my_publish() {
        $name = session('acount');
        $res = GoodsModel::my_publish($name);
        if(!$res) {
            return 0;
        }
        $count = count($res);
        return json(array('code'=>0,'msg'=>'ms','count'=>$count,'data'=>$res));
    }

    //删除商品信息
    public function del_goods() {
        $g_num = request()->param("g_num");
        $res = GoodsModel::del_goods($g_num);
        if(!$res) {
            return 0;
        } 
        return json_encode(array('code'=>1,'msg'=>'删除成功！'));
    }
    //更新商品信息
    public function update_goods() {
        $g_num = request()->param("num");
        $g_name = request()->param("title");
        $g_category = intval(request()->param('category'));
        $g_text_description = request()->param("describe");
        $g_price = request()->param("price");
        $g_state = request()->param("state");
        $arr = [];
        $arr['g_num'] = $g_num;
        $arr['arr'] = ['g_name'=>$g_name,'g_category'=>$g_category,'g_text_description'=>$g_text_description,'g_price'=>$g_price,'g_state'=>$g_state];
        $res = GoodsModel::change_goods($arr);
        if($res!==false) {
            return json_encode(array('code'=>1,'msg'=>'修改成功'));
        }
        return json_encode(array('code'=>0,'msg'=>'请做出修改后在提交'));
    }


}

