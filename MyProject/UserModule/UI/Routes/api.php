<?php
use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->namespace("MyProject\UserModule\UI\Controllers")
    ->group(function () {
        Route::get('/test', 'UserController@test');
        Route::post('/register', 'UserController@register'); //change on POST method
        Route::post('/login', 'UserController@login');
        Route::post('/message', 'MessageController@addMessage');
        //Route::post('/message', 'MessageController@addMessage');
    });
