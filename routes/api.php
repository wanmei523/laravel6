<?php

use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->name('api.v1')->namespace('Api')->group(function(){
    Route::get('test',function(){
        //abort(403,'大侠我错了');
        //throw new ApiException('大侠我真错了',10086,[],500);
        apiErr('大大大大大侠我错了');
    })->name('test');
    //测试路由
    Route::post('login','\App\Http\Controllers\Admin\LoginController@check')->name('login');
    //课程列表
    Route::get('courses','CourseController@index')->name('courses');
    //课程信息
    Route::get('courses/{course}','CourseController@course')->name('course');
});
