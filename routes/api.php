<?php

use App\Http\Controllers\EndpointController;
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

Route::get('actions', [ EndpointController::class, 'actions' ]);
Route::get('events/{action_id}', [ EndpointController::class, 'events' ]);
Route::get('places/{event_id}', [ EndpointController::class, 'places' ]);
Route::post('reserve/{event_id}', [ EndpointController::class, 'reserve' ]);
