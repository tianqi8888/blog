<?php
//不需要登录就可以访问路由组
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    //登录页
    Route::get('login','LoginController@login');
    //处理登录
    Route::post('dologin','LoginController@doLogin');
    //加密算法
    Route::get('jiami','LoginController@jiami');
    //验证码路由
    Route::get('code','LoginController@code');
});

//验证码组件写法
Route::get('code/captcha/{tmp}','Admin\LoginController@captcha');
//无权限
Route::get('noaccess','Admin\LoginController@noaccess');

//需要权限并且已登录才可访问的路由组
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['isLogin','hasRole']],function(){
    //首页
    Route::get('index','LoginController@index');
    //欢迎页
    Route::get('welcome','LoginController@welcome');
    //退出登录
    Route::get('logout','LoginController@logout');
    //用户批量删除
    Route::get('user/del','UserController@delAll');
    //用户分配角色
    Route::get('user/role/{id}','UserController@role');
    //处理用户角色
    Route::post('user/dorole','UserController@dorole');
    //用户模块
    Route::resource('user','UserController');
    //角色批量删除
    Route::get('role/del','RoleController@delAll');
    //角色授权路由
    Route::get('role/auth/{id}','RoleController@auth');
    //处理角色授权
    Route::post('role/doauth','RoleController@doauth');
    //角色模块
    Route::resource('role','RoleController');
    //权限模块
    Route::resource('permission','PermissionController');
    //权限批量删除
    Route::get('permission/del','PermissionController@delAll');
    //分类模块
    Route::resource('cate','CateController');
    //修改分类排序
    Route::post('cate/changeorder','CateController@changeOrder');
    //文章模块
    Route::resource('article','ArticleController');
    //缩略图上传
    Route::post('article/upload','ArticleController@upload');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
