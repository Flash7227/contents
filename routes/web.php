<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@welcome');
Route::get('/', 'HomeController@homecompIndex');

//Tseverhen ajiltsgaay
// TVROOM 
Route::group(['middleware' => 'auth', 'prefix' => '/user'], function(){
    Route::get('/upload', 'UsersController@uploadIndex');
    Route::post('/upload', 'UsersController@uploadPost');
    Route::post('/upload/fetch', 'UsersController@uploadFetch');
    Route::get('/shared', 'UsersController@sharedIndex');
});

Route::group(['middleware' => 'auth', 'prefix' => '/admin'], function(){
    Route::get('/users', 'AdminsController@usersIndex');
    
});

    
