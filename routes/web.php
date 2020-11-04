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
//这个是原来GBOOK的
Route::get('/gbook/index','MsgController@index')->name('index');
Route::post('/gbook/save','MsgController@save')->name('save');

//这下面是课程管理的

//后台路由分组
Route::prefix('admin')->group(function(){
    //管理员登陆
    Route::get('login','Admin\LoginController@login')->name('admin.login');
    Route::post('login','Admin\LoginController@check')->name('admin.login');
    Route::get('logout','Admin\LoginController@logout')->name('admin.logout');
    //需要保护的后台路由列表
    Route::middleware('adminLoginCheck')->group(function(){
        //后台中心首页
        Route::get('index','Admin\IndexController@index')->name('admin.index');
        //管理员管理
        Route::prefix('adminuser')->group(function(){
            //列表
            Route::get('/','Admin\AdminUserController@index')->name('admin.adminuser');
            //添加编辑
            Route::get('add/{adminuser?}','Admin\AdminUserController@add')->name('admin.adminuser.add');
            Route::post('add/{adminuser?}','Admin\AdminUserController@save')->name('admin.adminuser.save');
            //软删除
            Route::get('remove/{adminuser}','Admin\AdminUserController@remove')->name('admin.adminuser.remove');
            //切换状态
            Route::get('state/{adminuser}','Admin\AdminUserController@state')->name('admin.adminuser.state');
        });
        //系统设置
        Route::prefix('setting')->group(function(){
            Route::get('/','Admin\SettingController@index')->name('admin.setting');
            Route::post('/','Admin\SettingController@save')->name('admin.setting');
        });
        //课程资源
        Route::prefix('resource')->group(function(){
            //列表
            Route::get('/','Admin\ResourceController@index')->name('admin.resource');
            //添加
            Route::get('add/{resource?}','Admin\ResourceController@add')->name('admin.resource.add');
            //保存
            Route::post('add/{resource?}','Admin\ResourceController@save')->name('admin.resource.add');
            //移除
            Route::get('remove/{resource}','Admin\ResourceController@remove')->name('admin.resource.remove');
            //编辑器上传
            Route::get('up','Admin\ResourceController@up')->name('admin.resource.up');
        });
    });
   
});