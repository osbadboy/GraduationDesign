<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

//注册登录路由
Route::get('hello/:name', 'index/hello');
Route::get('login','login/index');
Route::get('register','register/index');

//商品路由
//商品详情页路由，接受参数  商品编号
Route::get('goods', 'goods/index');
Route::get('searchgoods', 'goods/searchgoods');
Route::get('addgoods', 'goods/addgoods');//商品上传页面
Route::post('goods/upload', 'goods/upload'); //上传图片
Route::post('goods/add', 'goods/add'); //发布商品
Route::post('goods/put_comment', 'comment/put_comment');
Route::get('goods/show_comment', 'comment/show_comment');


//收藏路由
Route::get('collection', 'collection/index');

//用户路由
Route::get('user', 'user/index');
Route::get('my_info', 'user/my_info');

//推荐路由
Route::get('recommend', 'recommend/index');

//退出登录
Route::get('logout', 'user/logout');












return [

];
