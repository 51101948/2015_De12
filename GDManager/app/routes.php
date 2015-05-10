<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('uses' => 'HomeController@showHome'));

Route::get('login', array('uses' => 'HomeController@showLogin'));

// route to process the form
Route::post('login', array('uses' => 'HomeController@doLogin'));

Route::get('logout', array('uses' => 'HomeController@doLogout'));
Route::get('signup', array('uses' => 'HomeController@doSignup'));
Route::post('signup', array('uses' => 'UsersController@userCreate'));

Route::get('/DAuthStart','dropboxServiceInfo@AuthStart');
Route::get('/DAuthFinish', 'dropboxServiceInfo@AuthFinish');

/*Route::get(function(){
},'dropboxServiceInfo@AuthFinish')*/

Route::get('/DClient','dropboxServiceInfo@getDropboxClient');

Route::get('/GAuthStart','googleDriveServiceInfo@AuthStart');
Route::get('/GAuthFinish','googleDriveServiceInfo@AuthFinish');
Route::get('/GClient','googleDriveServiceInfo@getGoogleClient');
