<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Event\StatisticController;
use App\Http\Controllers\Settlements\CityController;
use App\Http\Controllers\Settlements\RegionController;
use App\Http\Controllers\User\DepartmentController;
use App\Http\Controllers\User\JobTitleController;
use App\Http\Controllers\User\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:api', 'check-auth-status:api']], function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('user', [UserController::class, 'current']);

    Route::group(['middleware' => 'can:index users'], function () {
        Route::get('users', [UserController::class, 'index']);

        Route::get('users/{id}', [UserController::class, 'show'])
            ->middleware(['can:show users']);
        Route::post('users', [UserController::class, 'store'])
            ->middleware(['can:create users']);

        Route::patch('users/{id}', [UserController::class, 'update'])
            ->middleware(['can:edit users']);
        Route::delete('users/{id}', [UserController::class, 'destroy'])
            ->middleware(['can:delete users']);

        Route::get('users-edit-data', [UserController::class, 'getDataForEditForm'])
            ->middleware(['can:create users', 'can:edit users']);
    });

    Route::group(['middleware' => 'can:index departments'], function () {
        Route::get('departments', [DepartmentController::class, 'index']);

        Route::get('departments/{id}', [DepartmentController::class, 'show'])
            ->middleware(['can:show departments']);
        Route::post('departments', [DepartmentController::class, 'store'])
            ->middleware(['can:create departments']);

        Route::patch('departments/{id}', [DepartmentController::class, 'update'])
            ->middleware(['can:edit departments']);
        Route::delete('departments/{id}', [DepartmentController::class, 'destroy'])
            ->middleware(['can:delete departments']);
    });

    Route::group(['middleware' => 'can:index job_titles'], function () {
        Route::get('job-titles', [JobTitleController::class, 'index']);

        Route::get('job-titles/{id}', [JobTitleController::class, 'show'])
            ->middleware(['can:show job_titles']);
        Route::post('job-titles', [JobTitleController::class, 'store'])
            ->middleware(['can:create job_titles']);

        Route::patch('job-titles/{id}', [JobTitleController::class, 'update'])
            ->middleware(['can:edit job_titles']);
        Route::delete('job-titles/{id}', [JobTitleController::class, 'destroy'])
            ->middleware(['can:delete job_titles']);
    });

    Route::group(['middleware' => 'can:index roles'], function () {
        Route::get('roles', [RoleController::class, 'index']);

        Route::get('roles/permissions', [RoleController::class, 'getPermissions'])
            ->middleware(['can:create roles', 'can:edit roles']);
        Route::get('roles/{id}', [RoleController::class, 'show'])
            ->middleware(['can:show roles']);
        Route::post('roles', [RoleController::class, 'store'])
            ->middleware(['can:create roles']);

        Route::patch('roles/{id}', [RoleController::class, 'update'])
            ->middleware(['can:edit roles']);
        Route::delete('roles/{id}', [RoleController::class, 'destroy'])
            ->middleware(['can:delete roles']);
    });

    Route::group(['middleware' => 'can:index events'], function () {
        Route::get('events', [EventController::class, 'index']);
        Route::post('events', [EventController::class, 'store'])
            ->middleware(['can:create events']);
        Route::patch('events/{id}', [EventController::class, 'update'])
            ->middleware(['can:edit events']);
        Route::patch('events-status/{id}', [EventController::class, 'updateStatus'])
            ->middleware(['can:edit events']);
        Route::delete('events/{id}', [EventController::class, 'destroy'])
            ->middleware(['can:delete events']);
        Route::get('statistics', [StatisticController::class, 'index'])
            ->middleware(['can:index statistics']);
    });

    Route::group(['middleware' => 'can:index settlements'], function () {
        Route::get('regions', [RegionController::class, 'index']);
        Route::get('export/cities-by-regions', [RegionController::class, 'export']);
        Route::post('import/cities', [CityController::class, 'import']);
        Route::post('import/regions', [RegionController::class, 'import']);
        Route::get('cities', [CityController::class, 'index']);
    });

    Route::group(['middleware' => 'can:delete settlements'], function () {
        Route::delete('regions/{id}', [RegionController::class, 'destroy']);
        Route::delete('cities/{id}', [CityController::class, 'destroy']);
    });
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend']);

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');
});
