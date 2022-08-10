<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@homecompIndex');


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
    Route::post('/shared/fetchSearch', 'UsersController@fetchSearch');

    //profile
    Route::get('/profile', 'UsersController@profileIndex');
    Route::get('/profile/upload', 'UsersController@profileUpload');
    Route::post('/profile/avatar', 'UsersController@avatarUpload');
    //count view and download
    Route::post('/count', 'UsersController@countViewAndDownload');
});

Route::group(['middleware' => 'admincheck', 'prefix' => '/admin'], function(){
    Route::get('/user', 'AdminsController@userIndex');
    Route::post('/user', 'AdminsController@userEdit');
    Route::get('/user/fetch', 'AdminsController@userFetch1');
    Route::post('/user/fetch', 'AdminsController@userFetch');
    

    //uploads
    Route::get('/uploads', 'AdminsController@uploadIndex');
    Route::post('/uploads/fetch', 'AdminsController@uploadFetch');
    Route::post('/uploads/modify', 'AdminsController@uploadModify');
    
    Route::get('/tags', 'AdminsController@tagsIndex');
    Route::get('/tags/fetch', 'AdminsController@tagsFetch');
    Route::post('/tags', 'AdminsController@tagsPost');

    Route::get('/logs', 'AdminsController@logsIndex');
    Route::post('/logs/fetch', 'AdminsController@logsFetch');
});
Route::get('/blog/{id}', 'NewHomeController@blogFetch');

Route::group([ 'prefix' => '/home'], function(){
    // Route::get('/', 'HomeController@homecompIndex');
    Route::get('/', 'NewHomeController@index');
    Route::get('/fetch', 'NewHomeController@fetch');
    //new above
    Route::get('/getupload', 'HomeController@uploadData');
    Route::get('/blog', 'HomeController@blogcompIndex');
    Route::get('/blog/fetch', 'HomeController@blogFetch');
    Route::get('/poster', 'HomeController@postercompIndex');
    Route::get('/poster/fetch', 'HomeController@posterFetch');
    Route::get('/video', 'HomeController@videocompIndex');
    Route::get('/video/fetch', 'HomeController@videoFetch');
    Route::get('/file', 'HomeController@filecompIndex');
    Route::get('/file/fetch', 'HomeController@fileFetch');
    //search
    Route::post('/poster/fetchSearch', 'HomeController@posterSearch');
    Route::post('/blog/fetchSearch', 'HomeController@blogSearch');
    Route::post('/file/fetchSearch', 'HomeController@fileSearch');
    Route::post('/video/fetchSearch', 'HomeController@videoSearch');
    Route::post('/count', 'UsersController@countViewAndDownload');

   
});

    
Route::post('/ckeditor/upload', 'CkeditorController@upload')->name('ckeditor.upload');
Route::post('/vue2/upload', 'CkeditorController@upload2');

Route::get('/counter/view/{id}', 'NewHomeController@addCountView');
Route::get('/counter/download/{id}', 'NewHomeController@addCountDownload');