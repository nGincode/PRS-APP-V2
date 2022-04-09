<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StoreController;

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

###################################### Login System ##########################################
Route::controller(AuthController::class)->group(
    function () {
        Route::get('login', 'Login')->middleware('guest')->name('login');
        Route::post('login', 'Authenticate')->middleware('guest');

        Route::get('logout', 'Logout');
    }
);
###################################### Login System ##########################################


//Belanja
Route::get('/', [DashboardController::class, 'Index'])->middleware('auth')->name('dashboard');

//Users
Route::controller(UsersController::class)->group(
    function () {
        Route::get('Users', 'index')->middleware('auth');
        Route::post('Users', 'tambah')->middleware('auth');

        Route::post('Users/Edit', 'Edit')->middleware('auth');
        Route::post('Users/TambahEdit', 'TambahEdit')->middleware('auth');

        Route::post('Users/Hapus', 'Hapus')->middleware('auth');
    }
);


Route::controller(StoreController::class)->group(
    function () {
        Route::get('Store', 'Index')->middleware('auth');
        Route::post('Store', 'Tambah')->middleware('auth');

        Route::post('Store/Edit', 'Edit')->middleware('auth');
        Route::post('Store/TambahEdit', 'TambahEdit')->middleware('auth');

        Route::post('Store/Hapus', 'Hapus')->middleware('auth');
    }
);

Route::get('/test', function () {

    if ($message = session('sukses')) {
        echo $message;
    }
});
