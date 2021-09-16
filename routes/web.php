<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//登录页
Route::get('admin/login','Admin\LoginController@login');
//处理登录
Route::post('admin/dologin','Admin\LoginController@dologin');
//验证码路由
Route::get('admin/code','Admin\LoginController@code');
Route::get('code/captcha/{tmp}','Admin\LoginController@captcha');
//加密算法
Route::get('admin/jiami','Admin\LoginController@jiami');
//首页
Route::get('admin/index','Admin\LoginController@index');
//欢迎页
Route::get('admin/welcome','Admin\LoginController@welcome');