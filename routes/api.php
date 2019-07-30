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

#Route::middleware('auth:api')->get('/user', function (Request $request) {
#   return $request->user();
#});

# Show Events
//Route::get('events/', 'EventsController@show_all');
Route::get('events/{fromdate?}/{todate?}', 'EventsController@show');

# add events
Route::post('events', 'EventsController@store');
