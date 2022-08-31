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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;

use App\Models\Inventory;
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
        Route::get('Master/Bahan/PrintBarcode', 'PrintBarcode')->middleware('auth');
        Route::get('Master/Bahan/BahanExport', 'BahanExport')->middleware('auth');
        Route::post('Master/Bahan/BahanImport', 'BahanImport')->middleware('auth');


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





        //OLAHAN
        Route::get('Foodcost/Resep', 'Resep')->middleware('auth');
        Route::post('Foodcost/Resep', 'ResepTambah')->middleware('auth');
        Route::post('Foodcost/Manage/Resep', 'ResepManage')->middleware('auth');
        Route::post('Foodcost/Resep/Hapus', 'ResepnHapus')->middleware('auth');

        //bahan baku
        Route::post('Foodcost/Resep/ResepItemBahanBaku', 'ResepItemBahanBaku')->middleware('auth');
        Route::post('Foodcost/Resep/PilihBahanBaku', 'PilihResepBahanBaku')->middleware('auth');
        Route::post('Foodcost/Resep/TambahItemBahanBaku', 'TambahResepItemBahanBaku')->middleware('auth');
        //bahan baku

        //bahan olahan
        Route::post('Foodcost/Resep/PilihBahanOlahan', 'PilihResepBahanOlahan')->middleware('auth');
        Route::post('Foodcost/Resep/ResepItemBahanOlahan', 'ResepItemBahanOlahan')->middleware('auth');
        Route::post('Foodcost/Resep/TambahItemBahanOlahan', 'TambahResepItemBahanOlahan')->middleware('auth');
        //bahan olahan

        Route::post('Foodcost/Resep/ResepItemHapus', 'ItemResepHapus')->middleware('auth');
    }
);
Route::get('Foodcost/Olahan/Session',  function () {
    request()->session()->forget('IdOlahan');
    return redirect('Foodcost/Olahan')->withToastSuccess('Berhasil Clear Autosave');
})->middleware('auth');
Route::get('Foodcost/Olahan/SessionCreate',  function () {
    $id = request()->input('id');
    if ($id) {
        request()->session()->put('IdOlahan', $id);
        return redirect('Foodcost/Olahan')->withToastSuccess('Berhasil Mengambil ID');
    } else {
        return redirect('Foodcost/Olahan')->withToastError('Terjadi Kegagalan Mengambil ID');
    }
})->middleware('auth');

Route::get('Foodcost/Resep/Session',  function () {
    request()->session()->forget('IdResep');
    return redirect('Foodcost/Resep')->withToastSuccess('Berhasil Clear Autosave');
})->middleware('auth');
Route::get('Foodcost/Resep/SessionCreate',  function () {
    $id = request()->input('id');
    if ($id) {
        request()->session()->put('IdResep', $id);
        return redirect('Foodcost/Resep')->withToastSuccess('Berhasil Mengambil ID');
    } else {
        return redirect('Foodcost/Resep')->withToastError('Terjadi Kegagalan Mengambil ID');
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


//POS
Route::controller(POSController::class)->group(
    function () {
        Route::get('POS/', 'index')->middleware('auth');
        Route::post('POS/Layar', 'layar')->middleware('auth');
        Route::post('POS/Pilih', 'pilih')->middleware('auth');
        Route::post('POS/positemhapus', 'positemhapus')->middleware('auth');
        Route::post('POS/positemminus', 'positemminus')->middleware('auth');
        Route::post('POS/positemplus', 'positemplus')->middleware('auth');
        Route::post('POS/positemubah', 'positemubah')->middleware('auth');
        Route::post('POS/Barcode', 'Barcode')->middleware('auth');
        Route::post('POS/Totalbill', 'Totalbill')->middleware('auth');
        Route::post('POS/Search', 'Search')->middleware('auth');
        Route::post('POS/Input', 'Input')->middleware('auth');
        Route::post('POS/Manage', 'Manage')->middleware('auth');
        Route::post('POS/LihatBill', 'LihatBill')->middleware('auth');
        Route::get('POS/Print', 'Print')->middleware('auth');
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


        //Opname
        Route::get('Inventory/Opname', 'Opname')->middleware('auth');
        Route::post('Inventory/Opname', 'TambahOpname')->middleware('auth');
        Route::post('Inventory/Manage/Opname', 'ManageOpname')->middleware('auth');
        Route::post('Inventory/Bahan', 'Bahan')->middleware('auth');
        Route::get('Inventory/Bahan/PrintBarcode', 'PrintBarcode')->middleware('auth');
        Route::get('Inventory/Bahan/BarcodeCustom', 'BarcodeCustom')->middleware('auth');
        Route::post('Inventory/Stock/Edit', 'InventoryStockEdit')->middleware('auth');
        Route::post('Inventory/Stock/InventoryStockEditTambah', 'InventoryStockEditTambah')->middleware('auth');
        Route::post('Inventory/Opname/NamaInventory', 'NamaInventory')->middleware('auth');

        //Menu
        Route::get('Inventory/Menu', 'Menu')->middleware('auth');
        Route::post('Inventory/Nama', 'KetersedianMenu')->middleware('auth');
    }
);

//Order
Route::controller(OrderController::class)->group(
    function () {
        //Stock
        Route::get('Order/', 'Index')->middleware('auth');
        Route::post('Order/Items', 'Items')->middleware('auth');
        Route::post('Order/Input', 'Input')->middleware('auth');
        Route::post('Order/Select', 'Select')->middleware('auth');
        Route::post('Order/Hapus', 'Hapus')->middleware('auth');
        Route::post('Order/Manage', 'Manage')->middleware('auth');
        Route::post('Order/RemoveSessionEdit', 'RemoveSessionEdit')->middleware('auth');
        Route::post('Order/SessionEdit', 'SessionEdit')->middleware('auth');
        Route::post('Order/LihatBill', 'LihatBill')->middleware('auth');
        Route::post('Order/Upload', 'Upload')->middleware('auth');
        Route::post('Order/UpRepair', 'UpRepair')->middleware('auth');
    }
);

//Report
Route::controller(ReportController::class)->group(
    function () {
        Route::get('Report/Penjualan', 'Penjualan')->middleware('auth');
        Route::get('Report/PenjualanExport', 'PenjualanExport')->middleware('auth');

        Route::get('Report/Belanja', 'Belanja')->middleware('auth');
        Route::get('Report/BelanjaExport', 'BelanjaExport')->middleware('auth');
    }
);


//Ticekt
Route::controller(TicketController::class)->group(
    function () {
        Route::get('Ticket/Scan', 'Scan')->middleware('auth');
        Route::post('Ticket/Manage/Scan', 'ManageScan')->middleware('auth');
        Route::post('Ticket/TambahScan', 'TambahScan')->middleware('auth');
        Route::post('Ticket/EmailSend', 'EmailSend')->middleware('auth');
        Route::post('Ticket/CekScan', 'CekScan')->middleware('auth');
        Route::get('Ticket/Masuk', 'Masuk');
        Route::post('Ticket/Harga', 'Harga')->middleware('auth');
        Route::post('Ticket/Gunakan', 'Gunakan')->middleware('auth');
        Route::post('Ticket/Scan/Edit', 'EditScan')->middleware('auth');

        Route::get('Ticket/Nama', 'Nama')->middleware('auth');
        Route::post('Ticket/Manage/Nama', 'ManageNama')->middleware('auth');
        Route::post('Ticket/TambahNama', 'TambahNama')->middleware('auth');
        Route::post('Ticket/Ticket/Hapus', 'Hapus')->middleware('auth');
        Route::post('Ticket/Ticket/Edit', 'Edit')->middleware('auth');
        Route::post('Ticket/TambahEdit', 'TambahEdit')->middleware('auth');

        Route::get('Ticket', 'Pelanggan');
        Route::post('Ticket/Daftar', 'Daftar');
        Route::post('Ticket/Login', 'Login');
    }
);


Route::get(
    '/test',
    function () {

        $pos = Inventory::search('n')->where('delete', false)->get();

        dd($pos);
    }
);
