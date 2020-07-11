<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:api', 'namespace' => 'Admin\Request'], function(){
	Route::apiResource('users', 'UserController');
});