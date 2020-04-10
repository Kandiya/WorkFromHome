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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'Petugascontroller@register');
Route::post('login', 'Petugascontroller@login');
    Route::get('/', function(){
        return Auth::user()->level;
    })->middleware('jwt.verify');

    Route::get('user', 'Petugascontroller@getAuthenticatedUser');
