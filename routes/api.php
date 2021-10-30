<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return response()->json([
        'status' => "OK",
        'version' => app()->version(),
    ], 200);
});

Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::post('logout', [AuthController::class,'logout']);
    Route::post('logoutall', [AuthController::class,'logoutall']);
    Route::get('me',[AuthController::class,'me']);

    Route::get('check_available', [ApplicationController::class,'checkAvailable']);
    Route::post('book', [ApplicationController::class,'book']);
    Route::get('calculate_price', [ApplicationController::class,'calculatePrice']);
    Route::post('payment', [ApplicationController::class,'payment']);


});
