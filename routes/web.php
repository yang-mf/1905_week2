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

Route::get('/pay','AlipayController@pay');


Route::get('/pay/notify','Pay\AlipayController@notify');
Route::get('/pay/return','Pay\AlipayController@return');

Route::post('/test','LoginController@test');        //注册方法
Route::post('/login','LoginController@login');        //登录方法
Route::post('/userList','LoginController@userList')->middleware('fangshua');        //登录方法




Route::get('/set','MimaController@set');
Route::get('/get','MimaController@get');
