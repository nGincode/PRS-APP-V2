<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\GroupController;


use App\Models\Groups;
use App\Models\GroupsUsers;

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
        Route::get('Users', 'Index')->middleware('auth');
        Route::post('Users', 'Tambah')->middleware('auth');

        Route::post('Users/Edit', 'Edit')->middleware('auth');
        Route::post('Users/TambahEdit', 'TambahEdit')->middleware('auth');

        Route::post('Users/Hapus', 'Hapus')->middleware('auth');

        Route::post('Users/Manage', 'Manage')->middleware('auth');
    }
);

//STore
Route::controller(StoreController::class)->group(
    function () {
        Route::get('Store', 'Index')->middleware('auth');
        Route::post('Store', 'Tambah')->middleware('auth');

        Route::post('Store/Edit', 'Edit')->middleware('auth');
        Route::post('Store/TambahEdit', 'TambahEdit')->middleware('auth');

        Route::post('Store/Hapus', 'Hapus')->middleware('auth');

        Route::post('Store/Manage', 'Manage')->middleware('auth');
    }
);

//Groups
Route::controller(GroupController::class)->group(
    function () {
        Route::get('Group', 'Index')->middleware('auth');
        Route::post('Group', 'Tambah')->middleware('auth');

        Route::post('Group/Edit', 'Edit')->middleware('auth');
        Route::post('Group/TambahEdit', 'TambahEdit')->middleware('auth');

        Route::post('Group/Hapus', 'Hapus')->middleware('auth');

        Route::post('Group/Manage', 'Manage')->middleware('auth');
    }
);

Route::get('/test', function () {

    $g = GroupsUsers::with(['Users', 'Groups'])->latest()->get();

    $id = array();
    $usr = array();
    $nama = array();
    $permission = array();
    foreach ($g as $v) {
        if ($v->groups->id != 1) {
            $usr[] = array(
                str_replace(" ", "_", $v->groups->nama)  => $v->users->username
            );
            $nama[] = $v->groups->nama;
            $permission[] = $v->groups->permission;
            $id[] = $v->groups->id;
        }
    }
    $nama = array_unique($nama);


    $array = [];
    foreach ($nama as $key => $v1) {

        $username = '';
        foreach ($usr as $v2) {
            if (isset($v2[str_replace(" ", "_", $v1)])) {
                $username .= $v2[str_replace(" ", "_", $v1)] . '<br>';
            }
        }


        $judul = array_unique(str_replace(['create', 'update', 'view', 'delete'], '', unserialize($permission[$key])));
        $user_permission = unserialize($permission[$key]);
        $izin = '';
        foreach ($judul as $v) {
            $izin .= ' ' . $v . ' ( ';
            if (in_array('view' . $v, $user_permission)) {
                $izin .= '<i class="fa fa-eye"></i> ';
            }
            if (in_array('create' . $v, $user_permission)) {
                $izin .= '<i class="fa fa-plus"></i> ';
            }
            if (in_array('update' . $v, $user_permission)) {
                $izin .= '<i class="fa fa-pen"></i> ';
            }
            if (in_array('delete' . $v, $user_permission)) {
                $izin .= '<i class="fa fa-trash"></i>';
            }
            $izin .= ' )<br>';
        }

        $array[] = array(
            'nama' => $v1,
            'permission' => $izin,
            'username' => $username,
            'username' => $id[$key],
        );
    }

    print_r($array);

    // dd($g->toArray());
});
