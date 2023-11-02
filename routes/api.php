<?php

use App\Http\Controllers\AuthController;
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
        Route::get('root', [AuthController::class, 'root'])->name('auth.root')->where(['name'=>'Root', 'isMenu'=>0, 'default'=>0, 'parent'=>0]);
        Route::get('user', [AuthController::class, 'user'])->name('auth.user')->where(['name'=>'user', 'isMenu'=>1, 'default'=>1, 'parent'=>0]);
    });
});
