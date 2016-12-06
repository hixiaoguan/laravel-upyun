<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::any('/upimg','UpyunController@upimg');
Route::any('/upimgs','UpyunController@upimgs');
Route::any('/upimgAction','UpyunController@upimgAction');
Route::any('/upimgsAction','UpyunController@upimgsAction');