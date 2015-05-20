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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/login', function()
{
	return View::make('login');
});
Route::get('/DAuthStart','dropboxServiceInfo@AuthStart');
Route::get('/DAuthFinish', 'dropboxServiceInfo@AuthFinish');

/*Route::get(function(){
},'dropboxServiceInfo@AuthFinish')*/

Route::get('/DClient','dropboxServiceInfo@getDropboxClient');

Route::get('/GAuthStart','googleDriveServiceInfo@AuthStart');
Route::get('/GAuthFinish','googleDriveServiceInfo@AuthFinish');
Route::get('/GClient','googleDriveServiceInfo@getGoogleService');
Route::get('/GListFiles','googleDriveServiceInfo@getAllFiles');