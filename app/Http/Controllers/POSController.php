<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Bahan_Olahan;
use App\Models\User;
use App\Models\Store;
use App\Models\Ivn;
use App\Models\Pengadaan;
use App\Models\LogistikProduk;
use App\Models\LogistikBelanja;
use App\Models\LogistikOrder;
use App\Models\Groups;
use App\Models\Inventory;
use App\Models\Olahan;
use App\Models\Satuan;
use App\Models\OpnameStock;
use App\Models\POS;
use App\Models\POSBill;
use App\Models\POSBillItem;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class POSController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'POS';
        $this->data['subtitle'] = '';
        $this->title = $this->data['title'];
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }
    public function index()
    {
        $this->data['item'] = Inventory::with('Bahan')->where('delete', false)->get();
        return view('POS', $this->data);
    }

    public function pilih(Request $request)
    {
        $bahan_id = $request->input('bahan');
        $inventory_id = $request->input('id');

        $inventory = Inventory::where('id', $inventory_id)->first();

        POS::insert([
            'inventory_id' => $inventory_id,
            'bahan_id' => $bahan_id,
            'qty' => 1,
            'satuan' => $inventory['satuan'],
            'harga' => $inventory['auto_harga'],
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }


    public function layar()
    {

        $pos = POS::with('Bahan')->latest()->get();

        foreach ($pos as $key => $value) {
            echo  $data = ' <div><div class="float-right">
            <button class="btn btn-danger" onclick="positemhapus(' . $value['id'] . ')"><i class="fa fa-trash"></i></button>
            </div>
                 <h5 class="card-title">' . $value['bahan']->nama . ' x' . $value['harga'] . '</h5>
                <p class="card-text">' . $this->rupiah($value['harga']) . '</p><hr></div>';
        }
    }

    public function positemhapus(Request $request)
    {
        $id = $request->input('id');
        if (POS::where('id', $id)->delete()) {
            $data = [
                'toast' => true,
                'status' => 'success',
                'pesan' =>  'Berhasil Menghapus'
            ];
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Gagal Menghapus Data' . $id
            ];
        };
        echo json_encode($data);
    }
}
