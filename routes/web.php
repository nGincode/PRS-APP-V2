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
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\POSController;


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


//Dashbooard
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


        Route::get('Master/Satuan', 'Satuan')->middleware('auth');
        Route::post('Master/Satuan', 'SatuanTambah')->middleware('auth');

        Route::post('Master/Satuan/Hapus', 'SatuanHapus')->middleware('auth');

        Route::post('Master/Satuan/Edit', 'SatuanEdit')->middleware('auth');
        Route::post('Master/Satuan/SatuanEdit', 'SatuanEditTambah')->middleware('auth');

        Route::post('Master/Manage/Satuan', 'SatuanManage')->middleware('auth');



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

        //OLAHAN
        Route::get('Foodcost/Olahan', 'Olahan')->middleware('auth');
        Route::post('Foodcost/Olahan', 'OlahanTambah')->middleware('auth');
        Route::post('Foodcost/Manage/Olahan', 'OlahanManage')->middleware('auth');
        Route::post('Foodcost/Olahan/Hapus', 'OlahanHapus')->middleware('auth');

        //bahan baku
        Route::post('Foodcost/Olahan/OlahanItemBahanBaku', 'OlahanItemBahanBaku')->middleware('auth');
        Route::post('Foodcost/Olahan/PilihBahanBaku', 'PilihBahanBaku')->middleware('auth');
        Route::post('Foodcost/Olahan/TambahItemBahanBaku', 'TambahItemBahanBaku')->middleware('auth');
        //bahan baku

        //bahan olahan
        Route::post('Foodcost/Olahan/PilihBahanOlahan', 'PilihBahanOlahan')->middleware('auth');
        Route::post('Foodcost/Olahan/OlahanItemBahanOlahan', 'OlahanItemBahanOlahan')->middleware('auth');
        Route::post('Foodcost/Olahan/TambahItemBahanOlahan', 'TambahItemBahanOlahan')->middleware('auth');
        //bahan olahan


        Route::post('Foodcost/Olahan/OlahanItemHapus', 'ItemOlahanHapus')->middleware('auth');
    }
);
Route::get('Foodcost/Olahan/Session',  function () {
    session()->forget('IdOlahan');
    return redirect('Foodcost/Olahan')->withToastSuccess('Berhasil Clear Autosave');
})->middleware('auth');
Route::get('Foodcost/Olahan/SessionCreate',  function () {
    $id = request()->input('id');
    if ($id) {
        session()->put('IdOlahan', $id);
        return redirect('Foodcost/Olahan')->withToastSuccess('Berhasil Mengambil ID');
    } else {
        return redirect('Foodcost/Olahan')->withToastError('Terjadi Kegagalan Mengambil ID');
    }
})->middleware('auth');

//Belanja
Route::controller(BelanjaController::class)->group(
    function () {
        Route::get('Belanja', 'Index')->middleware('auth');
        Route::post('Belanja/Namabarang', 'Namabarang')->middleware('auth');
        Route::post('Belanja/Inventorybahanid', 'Inventorybahanid')->middleware('auth');
        Route::post('Belanja', 'Input')->middleware('auth');
        Route::post('Belanja/HapusItem', 'HapusItem')->middleware('auth');
        Route::post('Belanja/Manage', 'Manage')->middleware('auth');


        Route::post('Belanja/ViewItem', 'ViewItem')->middleware('auth');
        Route::post('Belanja/Upload', 'Upload')->middleware('auth');
    }
);

//Pemesanan
Route::controller(PemesananController::class)->group(
    function () {

        //OLAHAN
        Route::get('Pemesanan/PR', 'Olahan')->middleware('auth');
    }
);


//POS
Route::controller(POSController::class)->group(
    function () {
        Route::get('POS/', 'index')->middleware('auth');
        Route::post('POS/Layar', 'layar')->middleware('auth');
        Route::post('POS/Pilih', 'pilih')->middleware('auth');
        Route::post('POS/positemhapus', 'positemhapus')->middleware('auth');
        Route::post('POS/positemminus', 'positemminus')->middleware('auth');
        Route::post('POS/positemplus', 'positemplus')->middleware('auth');
        Route::post('POS/Totalbill', 'Totalbill')->middleware('auth');
        Route::post('POS/Search', 'Search')->middleware('auth');
        Route::post('POS/Input', 'Input')->middleware('auth');
        Route::post('POS/Manage', 'Manage')->middleware('auth');
        Route::post('POS/LihatBill', 'LihatBill')->middleware('auth');
        Route::post('POS/Print', 'Print')->middleware('auth');
    }
);

//Inventory
Route::controller(InventoryController::class)->group(
    function () {
        //Stock
        Route::get('Inventory/Stock', 'Stock')->middleware('auth');
        Route::post('Inventory/Stock', 'Tambah')->middleware('auth');

        Route::post('Inventory/Manage/Stock', 'Manage')->middleware('auth');
        Route::post('Inventory/Stock/Hapus', 'Hapus')->middleware('auth');


        Route::get('Inventory/Opname', 'Opname')->middleware('auth');
        Route::post('Inventory/Opname', 'TambahOpname')->middleware('auth');
        Route::post('Inventory/Manage/Opname', 'ManageOpname')->middleware('auth');
    }
);

Route::get(
    '/test',
    function () {
    }
);
