<?php

use Illuminate\Support\Facades\Route;

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
Route::get('mypage','MypageController@index');
Route::post('mypage','MypageController@ajaxRequestPost')->name('mypage.ajaxPost');
Route::put('mypage/checkBox',['as'=>'mypage.ajaxCheckBox','uses'=>'MypageController@ajaxCheckBox']);
Route::put('mypage/compTarget',['as'=>'mypage.ajaxCompTarget','uses'=>'MypageController@ajaxCompTarget']);
Route::delete('mypage','MypageController@ajaxRequestDelete')->name('mypage.ajaxDelete');
