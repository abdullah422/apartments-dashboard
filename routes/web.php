<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest']],function(){
    Route::get('/', function () {
        return view('auth.login');
    });
});

Auth::routes(['register' => false]);
