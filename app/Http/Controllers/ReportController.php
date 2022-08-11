<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Supplier;
use App\Models\Bahan;
use App\Models\Peralatan;
use App\Models\Pegawai;
use App\Models\Satuan;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Report';
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }


    /////////////////////////////////// Penjualan //////////////////////////
    public function Penjualan(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewReportPenjualan', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['Store'] = Store::where('tipe', 'Outlet')->orWhere('tipe', 'Logistik')->get();
        $this->data['subtitle'] = 'Penjualan';
        return view('ReportPenjualan', $this->data);
    }
    /////////////////////////////////// Penjualan //////////////////////////


}
