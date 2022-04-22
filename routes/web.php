<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProfileController;

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

    // users
    Route::resource('users', UserController::class);

    // customers
    Route::resource('customers', CustomerController::class)->parameters(['customers' => 'user']);

    // profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::match(['put', 'patch'], 'profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
});
