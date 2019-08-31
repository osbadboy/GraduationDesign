<?php
namespace app\index\controller;
//use app\index\model

class Index extends Common
{   
    public function index()
    {   
       return $this->fetch();
    }

    //推荐算法
    public function recommend() {
        
    }

}
