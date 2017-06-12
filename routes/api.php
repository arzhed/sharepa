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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::resource('user', 'UserController', ['only' => [
    'store'
]]);

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('user', 'UserController', ['only' => [
        'update', 'show'
    ]]);
    Route::post('user/getByMail', 'UserController@getByMail');


    Route::resource('adventure', 'AdventureController', ['only' => [
        'store'
    ]]);
});
