<?php
use Illuminate\Support\Facades\Route;

Route::prefix('api')
    ->middleware(['filter.input.data'])
    ->namespace("MyProject\UserModule\UI\Controllers")
    ->group(function () {
        Route::post('/user/register', 'UserController@register');
        Route::post('/user/login', 'UserController@login');
        Route::post('/user/messages', 'MessageController@addMessage');
        Route::get('/user/all/messages', 'MessageController@getAllUserMessages');
    });
