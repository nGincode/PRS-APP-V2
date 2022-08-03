<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Inventory;
use App\Models\Satuan;
use App\Models\OpnameStock;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Picqer\Barcode\BarcodeGeneratorPNG;


class InventoryController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Inventory';
        $this->data['subtitle'] = '';
        $this->title = $this->data['title'];
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }


    public function Stock(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewInventoryStock', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Stock';

        $bahan = [];
        $inv = [];
        $inventory = Inventory::where('store_id', request()->session()->get('store_id'))->where('delete', false)->get();
        foreach ($inventory as $v) {
            $inv[] = $v['bahan_id'];
        }

        foreach (Bahan::where('delete', false)->get() as $key => $value) {
            if (!in_array($value['id'], $inv)) {
                $pgn = json_decode($value['pengguna']);
                if ($pgn) {
                    $cek = in_array(request()->session()->get('store_id'), $pgn);
                } else {
                    $cek = true;
                }

                if ($cek) {
                    $bahan[] = array(
                        'nama' => $value['nama'],
                        'id' => $value['id']
                    );
                }
            }
        }
        $this->data['satuan'] = Satuan::all();
        $this->data['bahan'] = $bahan;


        if ($request->session()->get('tipe') == 'Office') {
            $Data = Inventory::where('delete', false)->with('Bahan', 'Store')->latest()->get();
        } else {
            $Data = Inventory::where('store_id', $request->session()->get('store_id'))->where('delete', false)->with('Bahan')->latest()->get();
        }

        $this->data['BahanPrint'] = $Data;
        return view('Stock', $this->data);
    }

    public function Tambah(Request $request)
    {

        if (!in_array('createInventoryStock', $this->permission())) {
            return redirect()->to('/');
        }
        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required',
                'qty' => 'required',
                'satuan' => 'required',
                'auto_harga' => 'required',
                'harga' => 'required',
                'margin' => 'required'
            ],
            $messages  = [
                'required' => 'Form :attribute harus terisi',
                'same' => 'Form :attribute & :other tidak sama.',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  $message
                ];
            }
        } else {
            if (Inventory::where('store_id', $request->session()->get('store_id'))->where('delete', false)->where('bahan_id', $request->input('nama'))->count()) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Nama Bahan Telah Ada'
                ];
            } else {

                $input = [
                    'bahan_id' => $request->input('nama'),
                    'store_id' => $request->session()->get('store_id'),
                    'users_id' => $request->session()->get('id'),
                    'margin' => $request->input('margin'),
                    'qty' => $request->input('qty'),
                    'satuan' => $request->input('satuan'),
                    'auto_harga' => $request->input('auto_harga'),
                    'harga_manual' => $this->unrupiah($request->input('harga')),
                    'harga_auto' => $this->unrupiah($request->input('harga')),
                    'tgl_harga' => date('Y-m-d H:i:s')
                ];
                if (Inventory::create($input)) {
                    $data = [
                        'toast' => true,
                        'status' => 'success',
                        'pesan' => 'Berhasil dibuat'
                    ];
                } else {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Terjadi kegagalan system'
                    ];
                };
            }
        }


        echo json_encode($data);
    }

    public function Manage(Request $request)
    {
        if (!in_array('viewInventoryStock', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Stock';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        if ($request->session()->get('tipe') == 'Office') {
            $Data = Inventory::where('delete', false)->with('Bahan', 'Store')->latest()->get();
        } else {
            $Data = Inventory::where('store_id', $request->session()->get('store_id'))->where('delete', false)->with('Bahan')->latest()->get();
        }
        foreach ($Data as $value) {
            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('updateInventoryStock', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Edit(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")' data-toggle='modal' data-target='#Modal' ><i class='fas fa-pencil-alt'></i> Edit</a></li>";
            }

            if (in_array('deleteInventoryStock', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")'  ><i class='fas fa-trash-alt'></i> Hapus</a></li>";
            }

            $button .= '</ul></div>';


            if ($value['qty'] < 10) {
                $qty = $value['qty'] . '/' . $value['satuan'] . ' &nbsp<span class="badge badge-danger"> <i class="fa fa-exclamation-triangle"></i></span> ';
            } else if ($value['qty'] < 20) {
                $qty = $value['qty'] . '/' . $value['satuan'] . ' &nbsp<span class="badge badge-warning"> <i class="fa fa-exclamation-triangle"></i></span> ';
            } else {
                $qty = $value['qty'] . '/' . $value['satuan'];
            }

            if ($value['auto_harga'] == 1) {
                $harga = $value['harga_auto'];
                $tanda = ' &nbsp<span class="badge badge-success"> Auto</span> ';
            } else {
                $harga = $value['harga_manual'];
                $tanda = '';
            }


            $generator = new BarcodeGeneratorPNG();

            if ($request->session()->get('tipe') == 'Office') {
                if (!$value['bahan']->delete) {
                    $result['data'][] = array(
                        '<center><img  width="150px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($value['bahan']->kode, $generator::TYPE_CODE_128)) . '"> <br>' . $value['bahan']->kode . '</center>',
                        $value['store']->nama,
                        $value['bahan']->nama,
                        $qty,
                        ($this->rupiah($harga) ?? 'Rp. 0') .  $tanda,
                        $value['margin'] . '%',
                        $button
                    );
                }
            } else {
                if (!$value['bahan']->delete) {
                    $result['data'][] = array(
                        '<center><img  width="150px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($value['bahan']->kode, $generator::TYPE_CODE_128)) . '"> <br>' . $value['bahan']->kode . '</center>',
                        $value['bahan']->nama,
                        $qty,
                        ($this->rupiah($harga) ?? 'Rp. 0') .  $tanda,
                        $value['margin'] . '%',
                        $button
                    );
                }
            }
        }
        echo json_encode($result);
    }

    public function Hapus(Request $request)
    {
        if (!in_array('deleteInventoryStock', $this->permission())) {
            return redirect()->to('/');
        }

        $id =  $request->input('id');
        if (Inventory::where('id', $id)->update(['delete' => true])) {
            $data = [
                'toast' => true,
                'status' => 'success',
                'pesan' => 'Berhasil Terhapus'
            ];
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Terjadi kegagalan system'
            ];
        };

        echo json_encode($data);
    }


    public function InventoryStockEdit(Request $request)
    {

        if (!in_array('updateInventoryStock', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');
        $request->session()->put('IdEdit', $id);

        $this->data['InventoryStockData'] = Inventory::with('Bahan')->where('id', $id)->first();
        return view('Edit', $this->data);
    }

    public function InventoryStockEditTambah(Request $request)
    {

        if (!in_array('updateInventoryStock', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->session()->get('IdEdit');
        $Inventory = Inventory::where('id', $id)->first();
        if ($Inventory) {
            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'harga' => 'required',
                    'auto_harga_edit' => 'required',
                    'margin' => 'required',
                ],
                $messages  = [
                    'required' => 'Form :attribute harus terisi',
                    'same' => 'Form :attribute & :other tidak sama.',
                ]
            );


            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $message) {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  $message
                    ];
                }
            } else {

                $input = [
                    'harga_manual' => $this->unrupiah($request->input('harga')),
                    'auto_harga' => $request->input('auto_harga_edit'),
                    'margin' => $request->input('margin')
                ];
                if (Inventory::where('id', $id)->update($input)) {
                    $data = [
                        'toast' => true,
                        'status' => 'success',
                        'pesan' => 'Berhasil dibuat'
                    ];
                } else {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Terjadi kegagalan system'
                    ];
                };
            }
        }


        echo json_encode($data);
    }



    public function Opname(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewInventoryOpname', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Opname';

        $bahan = [];
        $inv = [];
        $inventory = Inventory::where('delete', false)->get();
        foreach ($inventory as $v) {
            $inv[] = $v['bahan_id'];
        }

        foreach (Bahan::where('delete', false)->get() as $key => $value) {
            if (in_array($value['id'], $inv)) {
                $bahan[] = array(
                    'nama' => $value['nama'],
                    'id' => $value['id'],
                    'satuan' => $value['satuan_pengeluaran'],
                );
            }
        }
        $this->data['bahan'] = $bahan;

        return view('OpnameStock', $this->data);
    }
    public function ManageOpname(Request $request)
    {

        if (!in_array('viewInventoryOpname', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Stock';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = OpnameStock::where('delete', false)->latest()->get();
        foreach ($Data as $value) {

            if ($value['status'] == 'Tambah') {
                $qtyjml = $value['qty'] +  $value['qty_sebelum'];
            } elseif ($value['status'] == 'Kurang') {
                $qtyjml =  $value['qty_sebelum'] - $value['qty'];
            } else {
                $qtyjml = '';
            }
            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('deleteInventoryOpname', $this->permission())) {
                // $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")'  ><i class='fas fa-trash-alt'></i> Hapus</a></li>";
            }

            $button .= '</ul></div>';


            $result['data'][] = array(
                $value['tgl'],
                $value['nama'],
                $value['status'],
                $value['qty'] . '/' . $value['uom'],
                $value['qty_sebelum'] . '/' . $value['uom'],
                $qtyjml . '/' . $value['uom'],
                $value['ket'],
                $button

            );
        }
        echo json_encode($result);
    }
    public function TambahOpname(Request $request)
    {
        if (!in_array('createInventoryOpname', $this->permission())) {
            return redirect()->to('/');
        }

        $nama = $request->input('nama');
        $status = $request->input('status');
        $qty = $request->input('qty');
        $ket = $request->input('ket');

        $bahan = Inventory::where('bahan_id', $nama)->with('Bahan', 'Store')->first();

        if ($bahan) {
            if ($status == 'Tambah') {
                $qtyjml = $qty + $bahan['qty'];
            } elseif ($status == 'Kurang') {
                $qtyjml = $bahan['qty'] - $qty;
            } else {
                $qtyjml = '';
            }
            $input = [
                'tgl' => date('Y-m-d'),
                'bahan_id' => $nama,
                'nama' => $bahan['bahan']->nama,
                'uom' => $bahan['satuan'],
                'status' => $status,
                'qty' => $qty,
                'ket' => $ket,
                'store_id' => $request->session()->get('store_id'),
                'users_id' => $request->session()->get('id'),
                'qty_sebelum' => $bahan['qty']
            ];

            if ($qtyjml) {
                if (Inventory::where('id', $bahan['id'])->update(['qty' => $qtyjml])) {
                    if (OpnameStock::insert($input)) {
                        $data = [
                            'toast' => true,
                            'status' => 'success',
                            'pesan' =>  'Berhasil Menambah Stock'
                        ];
                    } else {
                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  'Terjadi kegagalan system'
                        ];
                    };
                } else {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Terjadi kegagalan system'
                    ];
                }
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Status Tidak didukung'
                ];
            }
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Inventory Tidak Ditemukan'
            ];
        }

        echo json_encode($data);
    }

    public function Bahan(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            if ($array = Bahan::where('id', $id)->first()) {
                $data = [
                    'satuan' => $array['satuan_pengeluaran'],
                    'harga' => $array['harga']
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Terjadi kegagalan system'
                ];
            }
        } else {
            $data = [
                'kosong' => true,
            ];
        }

        echo json_encode($data);
    }


    public function PrintBarcode(Request $request)
    {

        $generator = new BarcodeGeneratorPNG();

        if ($request->session()->get('tipe') == 'Office') {
            $Data = Inventory::where('delete', false)->with('Bahan', 'Store')->latest()->get();
        } else {
            $Data = Inventory::where('store_id', $request->session()->get('store_id'))->where('delete', false)->with('Bahan')->latest()->get();
        }

        echo '
        <html>
        <body onload="print()">
        <div class="page">';
        foreach ($Data as $key => $value) {
            echo '
            <div class="barcode">
            <small>' . $value['bahan']->nama . '</small><br>
            <img src="data:image/png;base64,' . base64_encode($generator->getBarcode($value['bahan']->kode, $generator::TYPE_CODE_128)) . '">
            <br>' . $value['bahan']->kode . '
            </div>';
        }
        echo '</div>
        <style>
        
        .page{
            font-family: monospace;
            text-align:center;
        }
        .barcode {
            border-bottom:1px dotted black;
            padding : 10px;
            margin:5px;
        }
        </style>
        </body>
        </html>
        ';
    }


    public function BarcodeCustom(Request $request)
    {

        $generator = new BarcodeGeneratorPNG();

        $id = $request->input('idbarcode');
        $jml = $request->input('jumlah');


        $Data = bahan::where('kode', $id)->first();
        echo '
        <html>
        <body onload="print()">
        <div class="page">';
        if ($Data) {
            for ($i = 0; $i < $jml; $i++) {
                echo '
            <div class="barcode">
            <small>' . $Data['nama'] . '</small><br>
            <img src="data:image/png;base64,' . base64_encode($generator->getBarcode($id, $generator::TYPE_CODE_128)) . '">
            <br>' . $Data['kode'] . '
            </div>';
            }
        } else {
            echo 'Tak ditemukan';
        }
        echo '</div>
        <style>
        
        .page{
            font-family: monospace;
            text-align:center;
        }
        .barcode {
            border-bottom:1px dotted black;
            padding : 10px;
            margin:5px;
        }
        </style>
        </body>
        </html>
        ';
    }
}
