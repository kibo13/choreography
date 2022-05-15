<?php

use Illuminate\Support\Facades\Route;

// site
use App\Http\Controllers\HomeController;

// admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\TitleController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\PassController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\DiplomController;

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

    Route::get('/', [HomeController::class, 'admin'])->name('home');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::match(['put', 'patch'], 'profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

    // users
    Route::group(['middleware' => 'permission:user_full'], function () {
        Route::resource('users', UserController::class);
    });

    Route::group(['middleware' => 'permission:user_read'], function () {
        Route::get('users', [UserController::class, 'index'])
            ->name('users.index');
    });

    // members
    Route::group(['middleware' => 'permission:member_full'], function () {
        Route::resource('members', MemberController::class);
    });

    Route::group(['middleware' => 'permission:member_read'], function () {
        Route::get('members', [MemberController::class, 'index'])
            ->name('members.index');
        Route::get('members/{member}', [MemberController::class, 'show'])
            ->name('members.show');
    });

    // workers
    Route::group(['middleware' => 'permission:worker_full'], function () {
        Route::resource('workers', WorkerController::class);
    });

    Route::group(['middleware' => 'permission:worker_read'], function () {
        Route::get('workers', [WorkerController::class, 'index'])
            ->name('workers.index');
    });

    // rooms
    Route::group(['middleware' => 'permission:room_full'], function () {
        Route::resource('rooms', RoomController::class);
    });

    Route::group(['middleware' => 'permission:room_read'], function () {
        Route::get('rooms', [RoomController::class, 'index'])
            ->name('rooms.index');
    });

    // specialties
    Route::group(['middleware' => 'permission:specialty_full'], function () {
        Route::resource('specialties', SpecialtyController::class);
    });

    Route::group(['middleware' => 'permission:specialty_read'], function () {
        Route::get('specialties', [SpecialtyController::class, 'index'])
            ->name('specialties.index');
    });

    // discounts
    Route::group(['middleware' => 'permission:discount_full'], function () {
        Route::resource('discounts', DiscountController::class);
    });

    Route::group(['middleware' => 'permission:discount_read'], function () {
        Route::get('discounts', [DiscountController::class, 'index'])
            ->name('discounts.index');
    });

    // group titles
    Route::group(['middleware' => 'permission:title_full'], function () {
        Route::resource('titles', TitleController::class);
    });

    Route::group(['middleware' => 'permission:title_read'], function () {
        Route::get('titles', [TitleController::class, 'index'])
            ->name('titles.index');
    });

    // groups
    Route::group(['middleware' => 'permission:group_full'], function () {
        Route::resource('groups', GroupController::class);
    });

    Route::group(['middleware' => 'permission:group_read'], function () {
        Route::get('groups', [GroupController::class, 'index'])
            ->name('groups.index');
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

    // passes
    Route::group(['middleware' => 'permission:pass_full'], function () {
        Route::resource('passes', PassController::class);
    });

    Route::group(['middleware' => 'permission:pass_read'], function () {
        Route::get('passes', [PassController::class, 'index'])
            ->name('passes.index');
    });

    // events
    Route::group(['middleware' => 'permission:event_full'], function () {
        Route::resource('events', EventController::class);
    });

    Route::group(['middleware' => 'permission:event_read'], function () {
        Route::get('events', [EventController::class, 'index'])
            ->name('events.index');
    });

    // achievements
    Route::group(['middleware' => 'permission:achievement_full'], function () {
        Route::get('achievements/{event}/create', [AchievementController::class, 'create'])
            ->name('achievements.create');
        Route::post('achievements', [AchievementController::class, 'store'])
            ->name('achievements.store');
        Route::get('achievements/{event}/edit', [AchievementController::class, 'edit'])
            ->name('achievements.edit');
        Route::match(['put', 'patch'], 'achievements/{achievement}', [AchievementController::class, 'update'])
            ->name('achievements.update');
        Route::delete('achievements/{achievement}', [AchievementController::class, 'destroy'])
            ->name('achievements.destroy');

        Route::post('diploms', [DiplomController::class, 'store'])
            ->name('diploms.store');
        Route::delete('diploms/{diplom}', [DiplomController::class, 'destroy'])
            ->name('diploms.destroy');
    });

    Route::group(['middleware' => 'permission:achievement_read'], function () {
        Route::get('achievements', [AchievementController::class, 'index'])
            ->name('achievements.index');
        Route::get('achievements/{event}', [AchievementController::class, 'show'])
            ->name('achievements.show');
        Route::get('achievements/report/{year}', [AchievementController::class, 'report'])
            ->name('achievements.report');
    });
});
