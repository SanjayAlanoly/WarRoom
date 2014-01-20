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

Route::get('login', array('as' => 'login', 'uses' => 'AuthController@showLogin'));
Route::post('login', 'AuthController@postLogin');

Route::group(array('before' => 'auth'), function()
{
    Route::get('/', 'WarRoom@showWarRoom');
});