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
 *      l - library
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

// main dashboard route
Route::get('u/maintenance/masterfile/{primekey?}', 'Maintenance\MasterFileController@index')->middleware('auth:api')->name('u.maintenance.masterfile');

// library
Route::get('l/helper/positions/{primekey?}', 'Helper\Helper@positions')->middleware('auth:api')->name('l.helper.positions');
Route::get('l/helper/emplstat', 'Helper\Helper@employmentStatus')->middleware('auth:api')->name('l.helper.emplstat');
Route::get('l/helper/workstat/{primekey?}', 'Helper\Helper@workStat')->middleware('auth:api')->name('l.helper.workstat');
Route::get('l/helper/workarea/{primekey?}', 'Helper\Helper@workArea')->middleware('auth:api')->name('l.helper.workarea');
Route::get('l/helper/division/{primekey?}', 'Helper\Helper@division')->middleware('auth:api')->name('l.helper.division'); // group 1
Route::get('l/helper/department/{primekey?}', 'Helper\Helper@department')->middleware('auth:api')->name('l.helper.workarea'); // group 2
Route::get('l/helper/section/{primekey?}', 'Helper\Helper@section')->middleware('auth:api')->name('l.helper.workarea'); // group 3
Route::get('l/helper/government/tin/{primekey?}/{empl_cde?}', 'Helper\Helper@tin')->middleware('auth:api')->name('l.helper.government.tin'); // tin number
Route::get('l/helper/government/sss/{primekey?}', 'Helper\Helper@sss')->middleware('auth:api')->name('l.helper.government.sss'); // sss number
Route::get('l/helper/government/pagibig/{primekey?}', 'Helper\Helper@pagibig')->middleware('auth:api')->name('l.helper.government.pagibig'); // pagibig number
Route::get('l/helper/government/philhealth/{primekey?}', 'Helper\Helper@philhealth')->middleware('auth:api')->name('l.helper.government.pagibig'); // philhealth number