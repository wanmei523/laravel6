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

    Route::middleware('adminLoginCheck')->group(function(){
        Route::get('index','Admin\IndexController@index')->name('admin.index');
    });
   
});