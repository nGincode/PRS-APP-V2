<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\Inventory;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Dashboard';
        $this->data['subtitle'] = '';
    }

    public function index(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        //SessionData
        $Tipe = request()->session()->get('tipe');
        $StoreId = request()->session()->get('store_id');

        if ($Tipe == 'Office') {
            $this->data['JumlahIvn'] = Inventory::count();
        } else if ($Tipe == 'Outlet') {
            $this->data['JumlahIvn'] = Inventory::count();
            //     $this->data['JumlahOrder'] = LogistikOrder::where('store_id', $StoreId)->count();
            //     $this->data['JumlahPengadaan'] = Pengadaan::where('store_id', $StoreId)->count();
            // } else if ($Tipe == 'Logistik') {
            //     $this->data['JumlahOrder'] = LogistikOrder::count();
            //     $this->data['JumlahBelanja'] = LogistikBelanja::count();
            //     $this->data['JumlahProductLogistik'] = LogistikProduk::count();
            // } else if ($Tipe == 'Khusus') {
            //     $this->data['JumlahOrder'] = LogistikOrder::count();
            //     $this->data['JumlahBelanja'] = LogistikBelanja::count();
            //     $this->data['JumlahProductLogistik'] = LogistikProduk::count();
        } else {
            $this->data['JumlahUsers'] = User::count();
        }


        return view('Dashboard', $this->data);
    }
}
