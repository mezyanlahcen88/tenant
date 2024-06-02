<?php

use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    //chaneg the status
Route::post('/user/changestatus', [UserController::class, 'changeStatus'])->name('user.changestatus');
//to permanently delete
Route::delete('/user/{id}/force_delete', [UserController::class, 'forceDelete'])->name('user.forceDelete');
// to restore
Route::put('/user/{id}/restore', [UserController::class, 'restore'])->name('user.restore');
//liste all deleted
Route::get('/user/trashed', [UserController::class, 'trashed'])->name('user.trashed');
    Route::resource('user', UserController::class)->names('user');
});
