<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Supplier;
use App\Models\Bahan;
use App\Models\Peralatan;
use App\Models\Pegawai;
use App\Models\Satuan;

use App\Exports\PenjualanExport;
use App\Exports\BelanjaExport;
use Maatwebsite\Excel\Facades\Excel;


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

    public function PenjualanExport(Request $request)
    {
        $store = $request->input('store');
        $export = $request->input('export');

        if ($date = $request->input('range_date')) {
            $tgl_awal = date('Y-m-d', strtotime(explode(" - ", $date)[0]));
            $tgl_akhir = date('Y-m-d', strtotime("+1 day", strtotime(explode(" - ", $date)[1])));
        } else {
            $tgl_awal = null;
            $tgl_akhir = null;
        }

        if ($store && $export && $tgl_awal && $tgl_akhir) {
            if ($export == 1) {
                return Excel::download(new PenjualanExport($store, $tgl_awal, $tgl_akhir), 'Penjualan ' . $tgl_awal . ' - ' . $tgl_akhir . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            } else if ($export == 2) {
                return Excel::download(new PenjualanExport($store, $tgl_awal, $tgl_akhir), 'Penjualan ' . $tgl_awal . ' - ' . $tgl_akhir . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            } else if ($export == 3) {
                return Excel::download(new PenjualanExport($store, $tgl_awal, $tgl_akhir), 'Penjualan ' . $tgl_awal . ' - ' . $tgl_akhir . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
        } else {
            return back()->with('toast_error', 'Input Belum Lengkap');
        }
    }
    /////////////////////////////////// Penjualan //////////////////////////


    /////////////////////////////////// Belanja //////////////////////////
    public function Belanja(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewReportBelanja', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['Store'] = Store::where('tipe', 'Outlet')->orWhere('tipe', 'Logistik')->get();
        $this->data['subtitle'] = 'Belanja';
        return view('ReportBelanja', $this->data);
    }

    public function BelanjaExport(Request $request)
    {
        $store = $request->input('store');
        $export = $request->input('export');

        if ($date = $request->input('range_date')) {
            $tgl_awal = date('Y-m-d', strtotime(explode(" - ", $date)[0]));
            $tgl_akhir = date('Y-m-d', strtotime("+1 day", strtotime(explode(" - ", $date)[1])));
        } else {
            $tgl_awal = null;
            $tgl_akhir = null;
        }

        if ($store && $export && $tgl_awal && $tgl_akhir) {
            if ($export == 1) {
                return Excel::download(new BelanjaExport($store, $tgl_awal, $tgl_akhir), 'Belanja ' . $tgl_awal . ' - ' . $tgl_akhir . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            } else if ($export == 2) {
                return Excel::download(new BelanjaExport($store, $tgl_awal, $tgl_akhir), 'Belanja ' . $tgl_awal . ' - ' . $tgl_akhir . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            } else if ($export == 3) {
                return Excel::download(new BelanjaExport($store, $tgl_awal, $tgl_akhir), 'Belanja ' . $tgl_awal . ' - ' . $tgl_akhir . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
        } else {
            return back()->with('toast_error', 'Input Belum Lengkap');
        }
    }
    /////////////////////////////////// Belanja //////////////////////////



}
