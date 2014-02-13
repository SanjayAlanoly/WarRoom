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


Route::get('/WarRoom/add_conv', 'WarRoom@addConv');
Route::get('/WarRoom/add_pledged', 'WarRoom@addPledged');
Route::get('/WarRoom/render_conv_progress', 'WarRoom@render_conv_progress');
Route::get('/WarRoom/render_pledged_progress', 'WarRoom@render_pledged_progress');
Route::get('/WarRoom/renderChildrenSupported', 'WarRoom@renderChildrenSupported');
Route::get('/WarRoom/renderConvList','WarRoom@renderConvList');

Route::post('/WarRoom/addContact', 'WarRoom@addContact');
Route::post('/WarRoom/updateContact', 'WarRoom@updateContact');
Route::post('/WarRoom/updateCallback', 'WarRoom@updateCallback');
Route::post('/WarRoom/updatePledge', 'WarRoom@updatePledge');

Route::post('/Import/uploadFile' , 'Import@uploadFile');

Route::get('login', array('as' => 'login', 'uses' => 'AuthController@showLogin'));
Route::post('login', 'AuthController@postLogin');

Route::get('logout', 'AuthController@getLogout');
Route::get('destroySession','WarRoom@destroySession');

Route::group(array('before' => 'auth'), function()
{
    Route::get('/WarRoom', 'WarRoom@showWarRoom');
    Route::get('/', 'Home@showHome');
    Route::get('/Import','Import@showImport');
});