<?php
use Illuminate\Http\Request;
use App\Http\Controllers\PasswordRecoverController;


Route::post('login', 'AuthController@login');
Route::get('country', 'CountryController@index')->name('country.index');
Route::post('account', 'AccountController@store')->name('account.store');

Route::controller(PasswordRecoverController::class)->group(function (){
    Route::post('/password-recover', 'passwordRecover');
    Route::any('/reset-password/{token}', 'changePasswordByUser')->name('password.reset');;
});

/** Only authenticated */
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', 'UserAuthController@show')->name('user.logged');
    Route::put('user', 'UserAuthController@update')->name('user.logged.edit');
    Route::post('update-account', 'UserAuthController@updateUserAndCompany')->name('user.logged.updateUserAndCompany');
    Route::post('logout', 'AuthController@logout')->name('user.logout');
    Route::get('account-change/{accountId}', 'AccountController@change')->name('account.change');
});

/** Authenticated and with permission */
Route::group(['middleware' => ['auth:sanctum', 'aerd.acl']], function () {
    Route::get('users', 'UserController@index')->name('users');
    Route::get('role', 'RoleController@index')->name('role.index');
    Route::post('role', 'RoleController@store')->name('role.store');
    Route::get('role/{id}', 'RoleController@show')->name('role.show');
    Route::put('role/{id}', 'RoleController@update')->name('role.update');

    Route::get('permission', 'PermissionController@index')->name('permission.index');
    Route::get('permission/{id}', 'PermissionController@show')->name('permission.show');

    Route::post('country', 'CountryController@store')->name('country.store');
    Route::get('country/{id}', 'CountryController@show')->name('country.show');
    Route::put('country/{id}', 'CountryController@update')->name('country.update');

    Route::get('account', 'AccountController@index')->name('account.index');
    Route::get('account/{id}', 'AccountController@show')->name('account.show');
    Route::put('account/{id}', 'AccountController@update')->name('account.update');

    Route::get('language', 'LanguageController@index')->name('language.index');
    Route::post('language', 'LanguageController@store')->name('language.store');
    Route::get('language/{id}', 'LanguageController@show')->name('language.show');
    Route::put('language/{id}', 'LanguageController@update')->name('language.update');

    Route::get('action-log', 'ActionLogController@index')->name('action-log.index');
    Route::get('action-log/{id}', 'ActionLogController@show')->name('action-log.show');

    /** Stubs insert HERE */


});

