<?php

use Illuminate\Support\Facades\Route;

// site
use App\Http\Controllers\HomeController;

// admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\ProfileController;

// auth
Auth::routes([
    'login'      => true,
    'reset'      => false,
    'confirm'    => false,
    'verify'     => false,
    'register'   => false
]);

// admin
Route::group([
    'middleware' => 'auth',
    'as'         => 'admin.'
], function () {

    // home
    Route::group(['middleware' => 'permission:home'], function () {
        Route::get('/', [HomeController::class, 'admin'])
            ->name('home');
    });

    // profile
    Route::group(['middleware' => 'permission:profile'], function () {
        Route::get('profile', [ProfileController::class, 'index'])
            ->name('profile.index');
        Route::match(['put', 'patch'], 'profile/{user}', [ProfileController::class, 'update'])
            ->name('profile.update');
    });

    // users
    Route::group(['middleware' => 'permission:user_full'], function () {
        Route::resource('users', UserController::class);
    });

    Route::group(['middleware' => 'permission:user_read'], function () {
        Route::get('users', [UserController::class, 'index'])
            ->name('users.index');
    });

    // customers
    Route::group(['middleware' => 'permission:member_full'], function () {
        Route::resource('customers', CustomerController::class)
            ->parameters(['customers' => 'user']);
    });

    Route::group(['middleware' => 'permission:member_read'], function () {
        Route::get('customers', [CustomerController::class, 'index'])
            ->name('customers.index');
        Route::get('customers/{user}', [CustomerController::class, 'show'])
            ->name('customers.show');
    });

    // profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::match(['put', 'patch'], 'profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
});
