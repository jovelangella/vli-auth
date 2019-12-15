<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('u/user', function (Request $request) {
    return $request->user()->only(['vli_subs', 'user_num', 'user_id_', 'user_nme']);
});

/**
 * use the following route identifier, after prefix /api/
 *      a - admin
 *      u - user
 *      c - client
 *      s - system
 */

// use in : Authentication, Access Token, User Create (Admin Side), Access Control
Route::post('/a/register', 'Authentication\AuthController@register')->middleware('auth:api')->name('a.register');
Route::post('/u/login', 'Authentication\AuthController@login')->name('u.login');
Route::get('u/login/primekey/{vli_subs}/{user_num}', 'Authentication\AuthController@userAssigned')->middleware('auth:api')->name('u.login.assigned'); // <---- get primekey(s)
Route::get('/u/login/primekey/company/{primekey?}', 'Authentication\AuthController@userAssignedCompany')->middleware('auth:api')->name('u.login.company.assigned'); // get company assigned based on primekey
Route::post('/u/logout', 'Authentication\AuthController@logout')->middleware('auth:api')->name('u.logout');
Route::post('/c/register', 'Client\ClientController@register')->name('c.register');
Route::post('/s/login', 'System\SystemController@login')->name('s.login');
Route::post('/s/register', 'System\SystemController@register')->middleware('auth:api')->name('s.register');


