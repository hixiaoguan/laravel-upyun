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
Route::any('/upimgAction','UpyunController@upimgAction');

Route::any('/upueditor','UpyunController@upueditor');
Route::any('/upueditorAction','UpyunController@upueditorAction');

Route::get('/upfilelist','UpyunController@upfilelist');

Route::get('/upfiledel','UpyunController@upfiledel');
Route::get('/upfiledelAction','UpyunController@upfiledelAction');

Route::any('/test','UpyunController@test');
Route::any('/testAction','UpyunController@testAction');

Route::get('/upi','UpyunController@index');

