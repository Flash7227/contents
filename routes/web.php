<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@welcome');


//Tseverhen ajiltsgaay
// TVROOM 
Route::group(['middleware' => 'auth', 'prefix' => '/user'], function(){
    Route::get('/upload', 'UsersController@uploadIndex');
    Route::post('/upload', 'UsersController@uploadPost');
    Route::post('/upload/modify', 'UsersController@uploadModify');
    Route::post('/upload/modify/cover', 'UsersController@uploadModifyCover');
    Route::post('/upload/fetch', 'UsersController@uploadFetch');
    //shared
    Route::get('/shared', 'UsersController@sharedIndex');
    Route::post('/shared/fetch', 'UsersController@sharedFetch');
    Route::post('/shared/fetchByTag', 'UsersController@fetchByTag');
});

Route::group(['middleware' => 'auth', 'prefix' => '/admin'], function(){
    Route::get('/user', 'AdminsController@userIndex');
    Route::post('/user', 'AdminsController@userEdit');
    Route::get('/user/fetch', 'AdminsController@userFetch1');
    Route::post('/user/fetch', 'AdminsController@userFetch');
    
    
    
});

Route::group(['middleware' => 'auth', 'prefix' => '/home'], function(){
    Route::get('/', 'HomeController@homecompIndex');
    Route::get('/getupload', 'HomeController@uploadData');
    Route::get('/niitlel', 'HomeController@niitlelcompIndex');
    Route::get('/niitlel/fetch', 'HomeController@niitlelFetch');
    Route::get('/poster', 'HomeController@postercompIndex');
    Route::get('/poster/fetch', 'HomeController@posterFetch');
    Route::get('/video', 'HomeController@videocompIndex');
    Route::get('/video/fetch', 'HomeController@videoFetch');
    Route::get('/file', 'HomeController@filecompIndex');
    Route::get('/file/fetch', 'HomeController@fileFetch');
    
});

    
Route::post('/ckeditor/upload', 'CkeditorController@upload')->name('ckeditor.upload');
