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

Route::get('/financefunctions/createevent','FinanceFunctions@createEvent');


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

Route::get('/Import','Import@showImport');
Route::post('/Import/uploadFile' , 'Import@uploadFile');
Route::get('/Import/getVolunteers','Import@getVolunteers');



Route::get('login', array('as' => 'login', 'uses' => 'AuthController@showLogin'));
Route::post('login', 'AuthController@postLogin');

Route::get('logout', 'AuthController@getLogout');
Route::get('destroySession','WarRoom@destroySession');

Route::filter('coach_check', function()
{
    $data = DB::connection('WarRoom')->select('SELECT id FROM bro_team_coach WHERE coach_id = ?',array(Auth::user()->id));
    if (!isset($data[0]->id))
    {
        return Redirect::to('/AccessDenied');
    }
});

Route::filter('bro_check',function()
{
    $data = DB::connection('cfrapp')->select('SELECT users.id FROM users
                                        INNER JOIN cities
                                        ON users.city_id = cities.id
                                        WHERE  cities.name = ? AND users.id = ?',array('National',Auth::user()->id));
    if (!isset($data[0]->id))
    {
        return Redirect::to('/AccessDenied');
    }

});



Route::group(array('before' => 'auth'), function()
{


    Route::post('/BrosDashboard/saveBroTeams','BrosDashboard@saveBroTeams');
    Route::get('/BrosDashboard',array('before' => 'bro_check', 'uses' => 'BrosDashboard@showBrosDashboard'));
    Route::get('/DeleteDonation',array('before' => 'bro_check', 'uses' => 'DeleteDonation@showDeleteDonation'));

    Route::post('/DeleteDonation/submitID',array('before' => 'bro_check', 'uses' => 'DeleteDonation@submitID'));
    Route::get('/AccessDenied',function(){return View::make('AccessDenied');});
    Route::post('/CoachDashboard/saveVolunteers','CoachDashboard@saveVolunteers');
    Route::post('/Volunteer/submitCalendar' , 'Volunteer@submitCalendar');
    Route::post('/Volunteer/submitPledged','Volunteer@submitPledged');
    Route::get('/Volunteer/{id}','Volunteer@showVolunteer');
    Route::get('/CoachDashboard',array('before' => 'coach_check', 'uses' => 'CoachDashboard@showCoachDashboard'));
    Route::get('/WarRoom', 'WarRoom@showWarRoom');
    Route::get('/', 'Home@showHome');
});