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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reg', "MainController@reg");
Route::get('/auth', "MainController@auth");

Route::get('/downloadFile', "MainController@downloadFile");

Route::get('/filter', "MainController@filter");
