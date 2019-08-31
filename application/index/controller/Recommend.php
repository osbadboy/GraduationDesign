<?php
namespace app\index\controller;


use app\index\controller\Common;
use think\Request;
use think\Db;

class Recommend extends Common {
    
    //禁止未登录访问
    public function __construct() {
        parent::__construct();
    }

    //模板渲染
    public function index(Request $request)
    {   
        
        return $this->fetch();
    }

    //热
    public function resou() {
        $res = db('s_goods')->where('g_state',0)->order('g_views desc')->limit(80)->select();
        return json_encode($res);
    }

    //关注的人动态
    public function dynamic() {
        $res = db('s_goods')->where('g_state',0)->alias('a')->where('f_a_user',session('acount'))->join('s_focus b ','b.f_b_user= a.g_publisher')->order('g_pubtime desc')->select();
        return json_encode($res);
    }

    
    public function recommend() { 
       $array =  $this->resou();
        for($i=1;$i<9;$i++){
            if($array[5][$i] != null){//$array[5]代表Leo
                $fm1 += $array[5][$i] * $array[5][$i];
            }
        }
        $fm1 = sqrt($fm1);  
        for($i=0;$i<5;$i++){
            $fz = 0;
            $fm2 = 0;
            echo "Cos(".$array[5][0].",".$array[$i][0].")=";   
            for($j=1;$j<9;$j++){
                //计算分子
                if($array[5][$j] != null && $array[$i][$j] != null){
                    $fz += $array[5][$j] * $array[$i][$j];
                }
                //计算分母2
                if($array[$i][$j] != null){
                    $fm2 += $array[$i][$j] * $array[$i][$j];
                }			
            }
            $fm2 = sqrt($fm2);
            $cos[$i] = $fz/$fm1/$fm2;
            $array.push($cos[$i]);
        }
        return $array;
        
    }



}

