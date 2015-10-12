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
use App\User;
Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'please visit /api for api access'
    ]);
});


use App\Media;
Route::get('/test', function(){
    return Media::all();
});

Route::group(['prefix' => 'api'], function () { //TODO Add auth middleware later
    Route::get('/', function ()    {
        return response()->json([
            'success' => true,
            'message' => 'welcome to the greatest api on earth made by boss JP'
        ]);
    });

    //Register a user.
    Route::resource('user', 'UserController', ['only'=>['store']]);

    //All requests will need token in the following group.
    Route::group(['middleware' => 'loggedInUsersOnly'], function(){
        Route::get('/restricted', function(){
            return "You are in the restricted route";
        });

        //Save a media for promotion.
        Route::resource('media', 'MediaController', ['only'=>['store', 'index']]);

        Route::resource('like', 'LikeController', ['only'=>['store', 'index']]);

        Route::resource('user', 'UserController', ['only'=>['index']]);
    });

});