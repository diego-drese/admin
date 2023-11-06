<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResourcesController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::post('new-password', [AuthController::class, 'newPassword'])->name('new.password');

Route::group(['prefix' => 'auth'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('me', [AuthController::class, 'me'])->name('auth.me');
        Route::put('me', [AuthController::class, 'updateMe'])->name('auth.me.update');
    });

    Route::group(['middleware' => ['auth:sanctum', 'admin.acl']], function () {
        /** Roles */
        Route::get('roles', [RolesController::class, 'index'])->name('auth.roles.index')->where(['description'=>'Roles Index', 'parent'=>0]);
        Route::post('roles', [RolesController::class, 'store'])->name('auth.roles.store')->where(['description'=>'Roles Store', 'parent'=>'auth.roles.index']);
        Route::get('roles/{id}', [RolesController::class, 'show'])->name('auth.roles.show')->where(['description'=>'Roles Show', 'parent'=>'auth.roles.index']);
        Route::put('roles/{id}', [RolesController::class, 'update'])->name('auth.roles.update')->where(['description'=>'Roles Update', 'parent'=>'auth.roles.index']);
        Route::delete('roles/{id}', [RolesController::class, 'destroy'])->name('auth.roles.destroy')->where(['description'=>'Roles Destroy', 'parent'=>'auth.roles.index']);

        /** Roles */
        Route::get('resources', [ResourcesController::class, 'index'])->name('auth.resources.index')->where(['description'=>'ResourcesCommand Index', 'isMenu'=>1, 'default'=>1, 'parent'=>0]);
        Route::post('resources', [ResourcesController::class, 'store'])->name('auth.resources.store')->where(['description'=>'ResourcesCommand Store', 'parent'=>'auth.resources.index']);
        Route::get('resources/{id}', [ResourcesController::class, 'show'])->name('auth.resources.show')->where(['description'=>'ResourcesCommand Show', 'parent'=>'auth.resources.index']);
        Route::put('resources/{id}', [ResourcesController::class, 'update'])->name('auth.resources.update')->where(['description'=>'ResourcesCommand Update', 'parent'=>'auth.resources.index']);
        Route::delete('resources/{id}', [ResourcesController::class, 'destroy'])->name('auth.resources.destroy')->where(['description'=>'ResourcesCommand Destroy', 'parent'=>'auth.resources.index']);

        /** Roles */
        Route::get('users', [UserController::class, 'index'])->name('auth.users.index')->where(['description'=>'Users Index', 'isMenu'=>1, 'default'=>1, 'parent'=>0]);
        Route::post('users', [UserController::class, 'store'])->name('auth.users.store')->where(['description'=>'Users Store', 'parent'=>'auth.users.index']);
        Route::get('users/{id}', [UserController::class, 'show'])->name('auth.users.show')->where(['description'=>'Users Show', 'parent'=>'auth.users.index']);
        Route::put('users/{id}', [UserController::class, 'update'])->name('auth.users.update')->where(['description'=>'Users Update', 'parent'=>'auth.users.index']);
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('auth.users.destroy')->where(['description'=>'Users Destroy', 'parent'=>'auth.users.index']);
    });
});
