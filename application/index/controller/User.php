<?php
namespace app\index\controller;

use app\index\model\User as UserModel;
use app\index\controller\Common;
use think\Request;

class User extends Common {
    //禁止未登录访问
    public function __construct() {
        parent::__construct();
    }
    //用户详情信息
    public function index(Request $request) {
        $key = $request->param("g_publisher");
        $res = UserModel::user_info($key);
        $res['star'] = 0;
        $query_res = UserModel::query_focus($res['p_acount']);
        $count = db('s_focus')->where('f_state',1)->where('f_b_user',$key)->count();
        if($query_res){
            $res['star'] = $query_res['f_state'];
        }
        $this->assign('user',$res);
        $this->assign('count',$count);
        return $this->fetch();
    }

    //商品详情页获取用户信息
    public function usr_info(Request $request) {
        $key = $request->param("real");
        $res = UserModel::user_in($key);
        return json_encode($res);
    }
    //退出登录
    public function logout(){
        session('acount',null);
        $this->redirect("/index/login");
        
    }
    //我的资料
    public function my_info() {
        $acount = session("acount");
        $res = UserModel::user_info($acount);
        $this->assign('user',$res);
        return $this->fetch();
    }
    //modify 我的资料
    public function modify_my_info(){
        $p_username = request()->param('username');
        $p_password = request()->param('password');
        $p_phone = request()->param('phone');
        $p_address = request()->param('address');
        $p_describe = request()->param('describe');
        $arr['acount'] = session('acount');
        $arr['data'] = ['p_username'=>$p_username,'p_password'=>$p_password,'p_phone'=>$p_phone,'p_address'=>$p_address,'p_describe'=>$p_describe];
        
        $res = UserModel::modify($arr);
        if($res !== false) {
            return json_encode(array('code'=>0,'msg'=>'修改成功'));
        }
        return json_encode(array('code'=>1,'msg'=>'修改失败'));
    }
    //上传头像
    public function upload(){
        $acount = session('acount');
        $img = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $query_pic = UserModel::query_pic_path($acount);
        if($query_pic['p_photo']){
            $path = str_replace("\\","/",UPLOAD_PATH . '/userphoto/'. $query_pic['p_photo']);
            unlink($path);
        } 
        $info = $img->rule("uniqid")->move('uploads/userphoto');
        if($info) {

            $filename =  $info->getFilename();
            $str = $filename;
            $arr = ['acount'=>$acount,'photo'=>$str];
            $res = UserModel::upload($arr);
            if($res !== false) {
                return json_encode(array('code'=>1,'msg'=>'图像上传成功'));
            }
            return json_encode(array('code'=>0,'msg'=>'图像上传失败'));
       }
       return json_encode(array('code'=>0,'msg'=>'文件移动失败'));
    }

    //关注用户
    public function focus() {
        $f_b_user = request()->param('b');
        $star = request()->param('val');
        $arr = ['f_a_user'=>session('acount'),'f_b_user'=>$f_b_user,'f_state'=>$star];
        $res = UserModel::change_focus($arr);
        if($res) {
            $state = UserModel::query_focus($f_b_user);
            return json_encode(array('code'=>$state['f_state'],'msg'=>'success'));
        }
        return json_encode(array('code'=>2,'msg'=>'false'));
    }
}