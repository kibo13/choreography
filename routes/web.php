<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
//    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::get('/', [HomeController::class, 'admin'])->name('home');
});


