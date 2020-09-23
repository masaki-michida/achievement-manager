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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('mypage','MypageController@index')->name('mypage');
});

Route::put('mypage/compTarget/{mypage}','MypageController@ajaxCompTarget')->name('mypage.ajaxCompTarget');
Route::post('mypage','MypageController@ajaxRequestPost')->name('mypage.ajaxPost');
Route::delete('mypage','MypageController@ajaxRequestDelete')->name('mypage.ajaxDelete');
Route::put('mypage/checkBox','MypageController@ajaxCheckBox')->name('mypage.ajaxCheckBox');