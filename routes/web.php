<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// admin
use App\Http\Controllers\Admin\UserController;

// auth
Auth::routes([
    'login' => true,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
    'register' => false
]);

// admin
Route::group([
    'middleware' => 'auth',
    'as' => 'admin.'
], function () {
    Route::get('/', [HomeController::class, 'admin'])->name('home');
    Route::resource('users', UserController::class);
});
