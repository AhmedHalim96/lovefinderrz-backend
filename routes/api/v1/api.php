<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Users Routes
Route::prefix('v1/user')->group(function () {
  Route::post('/login', 'api\v1\LoginController@login');

  Route::get('/all', function () {
    return User::all();
  })->middleware('auth:api');
});