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
        $id_store = request()->session()->get('store_id');

        $inventory = Inventory::where('id', $inventory_id)->first();

        $cek = POS::where('inventory_id', $inventory_id)->first();

        if ($inventory_id && $bahan_id) {
            if ($cek) {
                POS::where('inventory_id', $inventory_id)->update([
                    'store_id' => $id_store,
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
                    'store_id' => $id_store,
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

            $pos = Inventory::search($id)->where('delete', false)->get()->toArray();

            $data = '';
            foreach ($pos as $key => $v) {
                $data .= '<div class="item" id="pilihan_' . $v['id'] . '"
                                            onclick="pilih(' . $v['id'] . ',' . $v['bahan_id'] . ')">
                                            <div class="float-right"><b>';
                if ($v['qty'] < 5) {
                    $data .= '<i class="fa fa-exclamation-triangle"></i>';
                }
                $data .= $v['qty'] . ' ' . $v['satuan'];

                $bahan = Bahan::where('id', $v['bahan_id'])->first();
                $data .= '</b> </div> <h5 class="card-title"><b>' . $bahan['nama'] . '</b></h5>
                                            <p class="card-text">' . 'Rp ' . number_format($v['harga_last'], 0, ',', '.') . '</p>
                                            <hr>
                                        </div>';
            }
            echo $data;
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


    public function Input(Request $request)
    {

        if (!in_array('createPOS', $this->permission())) {
            redirect('dashboard', 'refresh');
        }

        $pengorder = $request->input('pengorder');
        $no = $request->input('no');
        $jumlah = $request->input('jumlah');
        $duit = $request->input('duit');

        $id_store = request()->session()->get('store_id');


        $dtpos = POS::with('Bahan', 'Inventory')->get();
        $jumlahbelanja = 0;
        foreach ($dtpos as $value) {
            $jumlahbelanja += $value['qty'] * $value['harga'];
        }

        if ($jumlah) {
            $jumlahqty = $jumlah;
        } else {
            $jumlahqty = $duit;
        }

        if ($jumlahbelanja <= $jumlahqty) {
            $bill_no = 'BILL-' . $id_store . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
            $data = [
                'store_id' => $id_store,
                'tgl' => date('Y-m-d H:i:s'),
                'no_bill' => $bill_no,
                'no_hp' => $no,
                'nama_bill' => $pengorder,
                'gross_total' => $jumlahbelanja,
                'disc' => null,
                'tax' => null,
                'paid' => 1,
                'total' => $jumlahbelanja,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($id = POSBill::insertGetId($data)) {

                $dataitem = [];
                foreach ($dtpos as $value1) {
                    $dataitem[] = [
                        'store_id' => $id_store,
                        'posbill_id' => $id,
                        'bahan_id' => $value1['bahan_id'],
                        'tgl' => date('Y-m-d'),
                        'nama' => $value1['bahan']->nama,
                        'qty' => $value1['qty'],
                        'satuan' => $value1['satuan'],
                        'harga' => $value1['harga'],
                        'total' => $value1['qty'] * $value1['harga'],
                        'paid' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }

                $kembalian = $this->rupiah($jumlahqty - $jumlahbelanja);

                if (POSBillItem::insert($dataitem)) {
                    POS::where('store_id', $id_store)->delete();
                    $data = [
                        'kembalian' => $kembalian
                    ];
                }
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Pembayaran Tidak Mencukupi'
                ];
            };
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Pembayaran Tidak Mencukupi'
            ];
        }
        echo json_encode($data);
    }
}
