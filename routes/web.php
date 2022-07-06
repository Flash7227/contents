<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@welcome');
Route::get('/home', 'HomeController@index')->name('home');

//Tseverhen ajiltsgaay