<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'please visit /api for api access'
    ]);
});

Route::group(['prefix' => 'api'], function () { //TODO Add auth middleware later
    Route::get('/', function ()    {
        return response()->json([
            'success' => true,
            'message' => 'welcome to the greatest api on earth made by boss JP'
        ]);
    });

});