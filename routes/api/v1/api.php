<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // User routes
    Route::prefix('user')->group(function () {
        Route::post('/login', 'api\v1\LoginController@login');
        Route::post('/register', 'api\v1\RegisterController@register');
        Route::get('/{email}', 'api\v1\UserController@show')->middleware('auth:api');
        Route::put('/{id}/online', 'api\v1\UserOnlineController')->middleware('auth:api');
        Route::put('/{id}/offline', 'api\v1\UserOfflineController')->middleware('auth:api');
    });

    Route::group(["middleware" => 'auth:api'], function () {
        // Chat Routes
        Route::group(["prefix" => "chat"], function () {
            Route::get('/', 'api\v1\ChatController@index');
            Route::get('/{id}', 'api\v1\ChatController@show');
            Route::post('/', 'api\v1\ChatController@store');
            Route::put('/{id}/update', 'api\v1\ChatController@update');
            Route::delete('/{id}/delete', 'api\v1\ChatController@destroy');
        });

        Route::group(['prefix' => "message"], function () {
            Route::post('/', 'api\v1\MessageController@store');
            Route::get('/{id}', 'api\v1\MessageController@show');
            Route::put('/{id}/update', 'api\v1\MessageController@update');
            Route::delete('/{id}/delete', 'api\v1\MessageController@destroy');
        });
    });
});
Route::middleware('auth:api')->post('/broadcast/auth', 'Api\BroadcastAuthController@auth');
