<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/reg', "Ajax\AjaxAuthRegController@reg");
Route::post('/auth', "Ajax\AjaxAuthRegController@auth");
Route::post('/genCode', "Ajax\AjaxAuthRegController@genCode");

Route::post('/addfile', "Ajax\AjaxFilesController@addfile");
Route::post('/addfolder', "Ajax\AjaxFilesController@addfolder");

Route::post('/getData', "Ajax\AjaxFilesController@getData");
Route::post('/getFiles', "Ajax\AjaxFilesController@getFiles");
Route::post('/getFilesFilter', "Ajax\AjaxFilesController@getFilesFilter");
Route::post('/getFolders', "Ajax\AjaxFilesController@getFolders");
Route::post('/getUrl', "Ajax\AjaxFilesController@getUrl");

Route::post('/deleteFile', "Ajax\AjaxFilesController@deleteFile");
Route::post('/deleteFolder', "Ajax\AjaxFilesController@deleteFolder");

