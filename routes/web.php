<?php

use Illuminate\Support\Facades\Route;

// site
use App\Http\Controllers\HomeController;

// admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\TitleController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\RoomController;

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

    // applications
    Route::group(['middleware' => 'permission:app_full'], function () {
        Route::resource('applications', ApplicationController::class);
    });

    Route::group(['middleware' => 'permission:app_read'], function () {
        Route::get('applications', [ApplicationController::class, 'index'])
            ->name('applications.index');
    });

    // support
    Route::group(['middleware' => 'permission:help_full'], function () {
        Route::resource('support', SupportController::class)
            ->parameters(['support' => 'application']);
    });

    Route::group(['middleware' => 'permission:help_read'], function () {
        Route::get('support', [SupportController::class, 'index'])
            ->name('support.index');
        Route::get('support/{application}', [SupportController::class, 'show'])
            ->name('support.show');
    });

    // groups
    Route::group(['middleware' => 'permission:group_full'], function () {
        Route::resource('groups', GroupController::class);
    });

    Route::group(['middleware' => 'permission:group_read'], function () {
        Route::get('groups', [GroupController::class, 'index'])
            ->name('groups.index');
    });

    // group titles
    Route::group(['middleware' => 'permission:name_full'], function () {
        Route::resource('titles', TitleController::class);
    });

    Route::group(['middleware' => 'permission:name_read'], function () {
        Route::get('titles', [TitleController::class, 'index'])
            ->name('titles.index');
    });

    // types of lessons
    Route::group(['middleware' => 'permission:lesson_full'], function () {
        Route::resource('lessons', LessonController::class);
    });

    Route::group(['middleware' => 'permission:lesson_read'], function () {
        Route::get('lessons', [LessonController::class, 'index'])
            ->name('lessons.index');
    });

    // specialties
    Route::group(['middleware' => 'permission:sp_full'], function () {
        Route::resource('specialties', SpecialtyController::class);
    });

    Route::group(['middleware' => 'permission:sp_read'], function () {
        Route::get('specialties', [SpecialtyController::class, 'index'])
            ->name('specialties.index');
    });

    // rooms
    Route::group(['middleware' => 'permission:room_full'], function () {
        Route::resource('rooms', RoomController::class);
    });

    Route::group(['middleware' => 'permission:room_read'], function () {
        Route::get('rooms', [RoomController::class, 'index'])
            ->name('rooms.index');
    });
});
