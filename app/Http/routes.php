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

Route::get('/redirect/twitter', function(){
// Get code parameter.
    $code = Request::get('code');
// Request the access token.
    $data = Instagram::getOAuthToken($code);

// Set the access token with $data object.
    Instagram::setAccessToken($data);

// We're done here - how easy was that, it just works!
    dd( Instagram::getUserLikes());
// This example is simple, and there are far more methods available.
});

Route::get('/test', function(){
    $loginUrl = Instagram::getLoginUrl();
    return view('instagram')->with('loginUrl', $loginUrl);

});

Route::group(['prefix' => 'api'], function () { //TODO Add auth middleware later
    Route::get('/', function ()    {
        return response()->json([
            'success' => true,
            'message' => 'welcome to the greatest api on earth made by boss JP'
        ]);
    });

});