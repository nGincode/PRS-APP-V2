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

        $cek = POS::where('inventory_id', $inventory_id)->first();

        if ($inventory_id && $bahan_id) {
            if ($cek) {
                POS::where('inventory_id', $inventory_id)->update([
                    'inventory_id' => $inventory_id,
                    'bahan_id' => $bahan_id,
                    'qty' => 1 + $cek['qty'],
                    'satuan' => $inventory['satuan'],
                    'harga' => $inventory['harga_last'],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                POS::insert([
                    'inventory_id' => $inventory_id,
                    'bahan_id' => $bahan_id,
                    'qty' => 1,
                    'satuan' => $inventory['satuan'],
                    'harga' => $inventory['harga_last'],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        $dtpos = POS::all();
        $jumlah = 0;
        foreach ($dtpos as $key => $value) {
            $jumlah += $value['qty'] * $value['harga'];
        }

        echo json_encode($this->rupiah($jumlah));
    }


    public function Totalbill(Request $request)
    {
        $dtpos = POS::all();
        $jumlah = 0;
        foreach ($dtpos as $key => $value) {
            $jumlah += $value['qty'] * $value['harga'];
        }

        echo json_encode(['rp' => $this->rupiah($jumlah), 'no' => $jumlah]);
    }

    public function layar()
    {

        $pos = POS::with('Bahan')->latest()->get();

        foreach ($pos as $key => $value) {
            echo  $data = ' <div>
                <div class="float-right">

                    <button class="btn btn-danger btn-sm"  onclick="positemhapus(' . $value['id'] . ')">
                    <i class="fa fa-trash"></i>
                    </button>
                </div>
                <p style="float:right"><b>' . $this->rupiah($value['qty'] * $value['harga']) . ' &nbsp</b></p>
                 <h5 class="card-title">' . $value['bahan']->nama . ' x' . $value['qty'] . '</h5>
                <p class="card-text" style="margin-bottom:2px">' . $this->rupiah($value['harga']) . '</p>
                    <div style="float: right;margin-top: -1.5rem;">
                    <button class="btn btn-warning btn-sm" id="TblMinus_' . $value['id'] . '"  onclick="positemminus(' . $value['id'] . ')">
                    <i class="fa fa-minus"></i>
                    </button>
                    
                    <button class="btn btn-success btn-sm" id="TblPlus_' . $value['id'] . '"  onclick="positemplus(' . $value['id'] . ')">
                    <i class="fa fa-plus"></i>
                    </button>
                    </div>
                <hr>
                
                </div>';
        }
    }


    public function Search(Request $request)
    {

        $id = $request->input('id');
        if ($id) {
            // $pos = Inventory::search($id)->get()->toArray();

            // // $data = '';
            // foreach ($pos as $key => $v) {
            //     $data .= '<div class="animate__animated animate__backInDown animate__faster item" id="pilihan_' . $v['id'] . '"
            //                                 onclick="pilih(' . $v['id'] . ',' . $v['bahan_id'] . ')">
            //                                 <div class="float-right"><b>';

            //     if ($v['qty'] < 5) {
            //         $data .= '<i class="fa fa-exclamation-triangle"></i>';
            //     }
            //     $data .= $v['qty'] . ' ' . $v['satuan'];
            //     $data .= '</b> </div> <h5 class="card-title"><b>' . $v['bahan']->nama . '</b></h5>
            //                                 <p class="card-text">' . 'Rp ' . number_format($v['harga_last'], 0, ',', '.') . '</p>
            //                                 <hr>
            //                             </div>';
            // }
            // echo $data;
        } else {
            $data = '';
            foreach (Inventory::with('Bahan')->where('delete', false)->get() as $key => $v) {
                $data .= '<div class="animate__animated animate__backInDown animate__faster item" id="pilihan_' . $v['id'] . '"
                                            onclick="pilih(' . $v['id'] . ',' . $v['bahan_id'] . ')">
                                            <div class="float-right"><b>';

                if ($v['qty'] < 5) {
                    $data .= '<i class="fa fa-exclamation-triangle"></i>';
                }
                $data .= $v['qty'] . ' ' . $v['satuan'];
                $data .= '</b> </div> <h5 class="card-title"><b>' . $v['bahan']->nama . '</b></h5>
                                            <p class="card-text">' . 'Rp ' . number_format($v['harga_last'], 0, ',', '.') . '</p>
                                            <hr>
                                        </div>';
            }

            echo $data;
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


    public function positemplus(Request $request)
    {
        $id = $request->input('id');

        $data = POS::where('id', $id)->first();

        if (POS::where('id', $id)->update(['qty' => $data['qty'] + 1])) {
            echo json_encode([]);
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Gagal Menambah Data ' . $id
            ];
            echo json_encode($data);
        };
    }


    public function positemminus(Request $request)
    {
        $id = $request->input('id');

        $data = POS::where('id', $id)->first();

        if ($data) {
            if ($data['qty'] <= 1) {
                echo json_encode([]);
            } else {
                if (POS::where('id', $id)->update(['qty' => $data['qty'] - 1])) {
                    echo json_encode([]);
                } else {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Gagal Mengurangi Data ' . $id
                    ];
                    echo json_encode($data);
                };
            }
        }
    }
}
