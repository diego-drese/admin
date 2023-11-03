<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolesController;
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
        Route::get('roles', [RolesController::class, 'index'])->name('auth.roles.index')->where(['name'=>'Roles', 'isMenu'=>1, 'default'=>1, 'parent'=>0]);
        Route::post('roles', [RolesController::class, 'store'])->name('auth.roles.store')->where(['name'=>'Roles Store', 'isMenu'=>0, 'default'=>0, 'parent'=>'auth.roles.index']);
        Route::get('roles/{id}', [RolesController::class, 'show'])->name('auth.roles.show')->where(['name'=>'Roles Show', 'isMenu'=>0, 'default'=>0, 'parent'=>'auth.roles.index']);
        Route::put('roles/{id}', [RolesController::class, 'update'])->name('auth.roles.update')->where(['name'=>'Roles Update', 'isMenu'=>0, 'default'=>0, 'parent'=>'auth.roles.index']);
        Route::delete('roles/{id}', [RolesController::class, 'destroy'])->name('auth.roles.destroy')->where(['name'=>'Roles Destroy', 'isMenu'=>0, 'default'=>0, 'parent'=>'auth.roles.index']);

        /** Roles */
        Route::get('resources', [ResourcesController::class, 'index'])->name('auth.resources.index')->where(['name'=>'Resources', 'isMenu'=>1, 'default'=>1, 'parent'=>0]);
        Route::post('resources', [ResourcesController::class, 'store'])->name('auth.resources.store')->where(['name'=>'Resources Store', 'isMenu'=>0, 'default'=>0, 'parent'=>'auth.resources.index']);
        Route::get('resources/{id}', [ResourcesController::class, 'show'])->name('auth.resources.show')->where(['name'=>'Resources Show', 'isMenu'=>0, 'default'=>0, 'parent'=>'auth.resources.index']);
        Route::put('resources/{id}', [ResourcesController::class, 'update'])->name('auth.resources.update')->where(['name'=>'Resources Update', 'isMenu'=>0, 'default'=>0, 'parent'=>'auth.resources.index']);
        Route::delete('resources/{id}', [ResourcesController::class, 'destroy'])->name('auth.resources.destroy')->where(['name'=>'Resources Destroy', 'isMenu'=>0, 'default'=>0, 'parent'=>'auth.resources.index']);
    });
});
