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



Route::get('/home', array('uses' => 'FilesController@makeHome'));
Route::get('logout', array('uses' => 'HomeController@doLogout'));

Route::get('/DAuthStart','dropboxServiceInfo@AuthStart');
Route::get('/DAuthFinish', 'dropboxServiceInfo@AuthFinish');	
Route::get('DClient','dropboxServiceInfo@getDropboxClient');
Route::post('/DUpload','dropboxServiceInfo@uploadFile');
Route::get('DDownload','dropboxServiceInfo@downloadFile');

Route::get('/DAuthStart','dropboxServiceInfo@AuthStart');
Route::get('/DAuthFinish', 'dropboxServiceInfo@AuthFinish');

Route::get('/GAuthStart','googleDriveServiceInfo@AuthStart');
Route::get('/GAuthFinish','googleDriveServiceInfo@AuthFinish');
Route::get('/GClient','googleDriveServiceInfo@getGoogleService');
Route::get('/GListFiles','googleDriveServiceInfo@showAllFile');

Route::get('signup', array('uses' => 'HomeController@doSignup'));
Route::post('signup', array('uses' => 'UsersController@userCreate'));
Route::get('login', array('uses' => 'HomeController@showLogin'));
Route::post('login', array('uses' => 'HomeController@doLogin'));

Route::get('/', array('uses' => 'HomeController@showHome'));
Route::post('/GUpload', array('uses'=>'FilesController@googleUploadFileContent'));
/*Route::post('/Test','FilesController@MoveDroptoGDrive');*/
Route::post('/MovetoDrop','FilesController@MoveGDrivetoDrop');

Route::post('/test','FilesController@test');




