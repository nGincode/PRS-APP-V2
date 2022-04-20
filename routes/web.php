<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\FoodcostController;




use App\Models\Olahan;
use App\Models\Bahan_Olahan;


use App\Models\User;

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


//Master
Route::controller(MasterController::class)->group(
    function () {
        Route::get('Master/Supplier', 'Supplier')->middleware('auth');
        Route::post('Master/Supplier', 'SupplierTambah')->middleware('auth');

        Route::post('Master/Supplier/Hapus', 'SupplierHapus')->middleware('auth');

        Route::post('Master/Supplier/Edit', 'SupplierEdit')->middleware('auth');
        Route::post('Master/Supplier/SupplierEdit', 'SupplierEditTambah')->middleware('auth');

        Route::post('Master/Manage/Supplier', 'SupplierManage')->middleware('auth');



        Route::get('Master/Bahan', 'Bahan')->middleware('auth');
        Route::post('Master/Bahan', 'BahanTambah')->middleware('auth');

        Route::post('Master/Bahan/Hapus', 'BahanHapus')->middleware('auth');

        Route::post('Master/Bahan/Edit', 'BahanEdit')->middleware('auth');
        Route::post('Master/Bahan/BahanEdit', 'BahanEditTambah')->middleware('auth');

        Route::post('Master/Manage/Bahan', 'BahanManage')->middleware('auth');


        Route::get('Master/Peralatan', 'Peralatan')->middleware('auth');
        Route::post('Master/Peralatan', 'PeralatanTambah')->middleware('auth');

        Route::post('Master/Peralatan/Hapus', 'PeralatanHapus')->middleware('auth');

        Route::post('Master/Peralatan/Edit', 'PeralatanEdit')->middleware('auth');
        Route::post('Master/Peralatan/PeralatanEdit', 'PeralatanEditTambah')->middleware('auth');

        Route::post('Master/Manage/Peralatan', 'PeralatanManage')->middleware('auth');


        Route::get('Master/Pegawai', 'Pegawai')->middleware('auth');
        Route::post('Master/Pegawai', 'PegawaiTambah')->middleware('auth');

        Route::post('Master/Pegawai/Hapus', 'PegawaiHapus')->middleware('auth');

        Route::post('Master/Pegawai/Edit', 'PegawaiEdit')->middleware('auth');
        Route::post('Master/Pegawai/PegawaiEdit', 'PegawaiEditTambah')->middleware('auth');

        Route::post('Master/Manage/Pegawai', 'PegawaiManage')->middleware('auth');
    }
);


//Foodcost
Route::controller(FoodcostController::class)->group(
    function () {
        Route::get('Foodcost/Olahan', 'Olahan')->middleware('auth');
        Route::post('Foodcost/Olahan', 'OlahanTambah')->middleware('auth');
        Route::post('Foodcost/Olahan/Edit', 'OlahanEdit')->middleware('auth');

        Route::post('Foodcost/Manage/Olahan', 'OlahanManage')->middleware('auth');
        Route::post('Foodcost/Olahan/ItemTambahEdit', 'ItemTambahEdit')->middleware('auth');

        Route::post('Foodcost/Olahan/OlahanItemManage', 'OlahanItemManage')->middleware('auth');
        Route::post('Foodcost/Olahan/OlahanItemHapus', 'ItemOlahanHapus')->middleware('auth');
    }
);
Route::get('Foodcost/Olahan/Session',  function () {
    session()->forget('IdOlahan');
    return redirect('Foodcost/Olahan')->withToastError('Berhasil Clear Autosave');
})->middleware('auth');

Route::get(
    '/test',
    function () {
        //Pengkondisian DB
        // $User = User::whereRaw('id != 1')->get();
        // $User = User::havingRaw('sum(store_id) > 1', [2])->get();
        // dd($User);

        //many to many db
        // $data = Olahan::find(1)->bahan;
        // $data = Olahan::with('bahan')->get();

        //db input ditentukan
        // $table->enum('delete', ['pria', 'wanita']);

        // $data = Bahan_Olahan::where('olahan_id', 1)->with('Bahan')->get();

        $data = Olahan::where('delete', false)->with('Bahan')->latest()->get();
        dd($data->toArray());
    }
);
