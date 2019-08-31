<?php
namespace app\index\controller;
use app\index\model\User as UserModel;
use think\Controller;
use think\Request;
use think\Db;
 
class Common extends Controller
{   
//检查是否登录
/*
	public function _initialize()
	{	
		
		 if(!session('username')){
			 $this->error('请先登录！',url('/index/login/index'));
		 }
	}
	*/
	/*
	//检查是否登录
	public function __construct(){
		$this->_user = session('username');
		// 未登录的用户不允许访问
		if(!$this->_user){
			//header('Location: /tp51/public/index.php/index/user/login');
			$this->redirect('login/index');
			exit;
		}
		$this->assign('user',$this->_user);
	}	
 */
	public function __construct() {
		parent::__construct();
		$this->_user = session("acount");
		if(!$this->_user) {
			$this->error('请先登录！','/index/login');
		}
		$this->assign('userAcount',$this->_user);
		//将主键id转化为用户名
		$this->uname = UserModel::user_name($this->_user);
		$this->assign('username',$this->uname);
	}
}