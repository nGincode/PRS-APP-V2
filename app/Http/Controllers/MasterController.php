<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\Ivn;
use App\Models\Pengadaan;
use App\Models\LogistikProduk;
use App\Models\LogistikBelanja;
use App\Models\LogistikOrder;
use App\Models\Groups;
use App\Models\Master_Supplier;
use App\Models\Master_Bahan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class MasterController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Master';
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
        $this->jmlbahan = Master_Bahan::where('delete', false)->count();
    }


    /////////////////////////////////// SUPLIER //////////////////////////
    public function Supplier(Request $request)
    {
        $this->data['subtitle'] = 'Supplier';
        return view('Master_Supplier', $this->data);
    }

    public function SupplierManage(Request $request)
    {
        $this->data['subtitle'] = 'Supplier';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Master_Supplier::where('delete', false)->latest()->get();
        foreach ($Data as $value) {
            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('updateMaster', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Edit(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")' data-toggle='modal' data-target='#Modal' href='#'><i class='fas fa-pencil-alt'></i> Edit</a></li>";
            }
            if (in_array('deleteMaster', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")'  href='#'><i class='fas fa-trash-alt'></i> Hapus</a></li>";
            }

            $button .= '</ul></div>';

            if ($value['hutang']) {
                $hutang = 'Hutang';
            } else {
                $hutang = 'Dimuka';
            }

            $result['data'][] = array(
                $value['nama'],
                $value['alamat'],
                $hutang,
                $value['tipe'],
                $value['rekening'],
                $value['wa'],
                $button
            );
        }
        echo json_encode($result);
    }

    public function SupplierTambah(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required|unique:master_supplier',
                'alamat' => 'required',
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
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'tipe' => $request->input('tipe'),
                'hutang' => $request->input('hutang'),
                'wa' => $request->input('wa'),
                'delete' => false,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            if (Master_Supplier::create($input)) {
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


        echo json_encode($data);
    }

    public function SupplierEdit(Request $request)
    {
        $id = $request->input('id');
        session()->flash('IdEdit', $id);

        $this->data['SupplierData'] = Master_Supplier::where('id', $id)->first();
        return view('Edit', $this->data);
    }

    public function SupplierEditTambah(Request $request)
    {

        $id = session('IdEdit');
        $SUpplier = Master_Supplier::where('id', $id)->first();
        if ($SUpplier) {
            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'nama' => 'required',
                    'alamat' => 'required',
                ],
                $messages  = [
                    'required' => 'Form :attribute harus terisi',
                    'same' => 'Form :attribute & :other tidak sama.',
                ]
            );

            if ($SUpplier['nama'] == $request->input('nama')) {
                $nama = $request->input('nama');
            } else {
                $str = Master_Supplier::where('nama', $request->input('nama'))->count();
                if ($str) {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Nama Telah digunakan'
                    ];
                    $nama = '';
                } else {
                    $nama = $request->input('nama');
                }
            }


            if ($nama) {
                if ($validator->fails()) {
                    session()->flash('IdEdit', $id);
                    foreach ($validator->errors()->all() as $message) {
                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  $message
                        ];
                    }
                } else {

                    $input = [
                        'nama' => $request->input('nama'),
                        'alamat' => $request->input('alamat'),
                        'tipe' => $request->input('tipe'),
                        'rekening' => $request->input('rekening'),
                        'hutang' => $request->input('hutang'),
                        'wa' => $request->input('wa'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    if (Master_Supplier::where('id', $id)->update($input)) {
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
        }


        echo json_encode($data);
    }

    public function SupplierHapus(Request $request)
    {
        $id =  $request->input('id');
        if (Master_Supplier::create(['delete' => true])) {
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
    /////////////////////////////////// SUPLIER //////////////////////////


    ////////////////////////////////// BARANG ///////////////////////////
    public function Bahan(Request $request)
    {
        $this->data['subtitle'] = 'Bahan';
        $this->data['kode'] = 'B' . $this->jmlbahan + 1;
        return view('Master_Bahan', $this->data);
    }

    public function BahanManage(Request $request)
    {
        $this->data['subtitle'] = 'Bahan';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Master_Bahan::where('delete', false)->latest()->get();
        foreach ($Data as $value) {
            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('updateMaster', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Edit(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")' data-toggle='modal' data-target='#Modal' href='#'><i class='fas fa-pencil-alt'></i> Edit</a></li>";
            }
            if (in_array('deleteMaster', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")'  href='#'><i class='fas fa-trash-alt'></i> Hapus</a></li>";
            }

            $button .= '</ul></div>';

            if ($value['kategori']) {
                if ($value['kategori'] == 1) {
                    $kategori = 'Bahan Baku Segar';
                } elseif ($value['kategori'] == 2) {
                    $kategori = 'Bahan Baku Beku';
                } elseif ($value['kategori'] == 3) {
                    $kategori = 'Bahan Baku Dalam Kemasan';
                } elseif ($value['kategori'] == 4) {
                    $kategori = 'Bahan Baku Dingin';
                } else {
                    $kategori = 'Not Found';
                }
            } else {
                $kategori = 'Not Found';
            }

            $konversi = 'Pemakaian : ' . $value['konversi_pemakaian'] . ' ' . $value['satuan_pemakaian'] . '<br> Pengeluaran : ' . $value['konversi_pengeluaran'] . ' ' . $value['satuan_pengeluaran'];
            $result['data'][] = array(
                $value['nama'],
                $kategori,
                $value['satuan_pembelian'],
                $this->rupiah($value['harga']), $konversi,
                $button
            );
        }
        echo json_encode($result);
    }

    public function BahanTambah(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required|unique:master_bahan',
                'kategori' => 'required',
                'satuan_pembelian' => 'required',
                'harga' => 'required',
                'satuan_pemakaian' => 'required',
                'konversi_pemakaian' => 'required',
                'satuan_pengeluaran' => 'required',
                'konversi_pengeluaran' => 'required',
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
                'nama' => $request->input('nama'),
                'kategori' => $request->input('kategori'),
                'satuan_pembelian' => $request->input('satuan_pembelian'),
                'harga' => $request->input('harga'),
                'satuan_pemakaian' => $request->input('satuan_pemakaian'),
                'konversi_pemakaian' => $request->input('konversi_pemakaian'),
                'satuan_pengeluaran' => $request->input('satuan_pengeluaran'),
                'konversi_pengeluaran' => $request->input('konversi_pengeluaran'),
                'delete' => false,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            if (Master_Bahan::create($input)) {
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


        echo json_encode($data);
    }

    public function BahanEdit(Request $request)
    {
        $id = $request->input('id');
        session()->flash('IdEdit', $id);

        $this->data['BahanData'] = Master_Bahan::where('id', $id)->first();
        return view('Edit', $this->data);
    }

    public function BahanEditTambah(Request $request)
    {

        $id = session('IdEdit');
        $SUpplier = Master_Supplier::where('id', $id)->first();
        if ($SUpplier) {
            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'nama' => 'required',
                ],
                $messages  = [
                    'required' => 'Form :attribute harus terisi',
                    'same' => 'Form :attribute & :other tidak sama.',
                ]
            );

            if ($SUpplier['nama'] == $request->input('nama')) {
                $nama = $request->input('nama');
            } else {
                $str = Master_Supplier::where('nama', $request->input('nama'))->count();
                if ($str) {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Nama Telah digunakan'
                    ];
                    $nama = '';
                } else {
                    $nama = $request->input('nama');
                }
            }


            if ($nama) {
                if ($validator->fails()) {
                    session()->flash('IdEdit', $id);
                    foreach ($validator->errors()->all() as $message) {
                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  $message
                        ];
                    }
                } else {

                    $input = [
                        'nama' => $request->input('nama'),
                        'alamat' => $request->input('alamat'),
                        'tipe' => $request->input('tipe'),
                        'rekening' => $request->input('rekening'),
                        'hutang' => $request->input('hutang'),
                        'wa' => $request->input('wa'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    if (Master_Supplier::where('id', $id)->update($input)) {
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
        }


        echo json_encode($data);
    }

    public function BahanHapus(Request $request)
    {
        $id =  $request->input('id');
        if (Master_Bahan::create(['delete' => true])) {
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
    ////////////////////////////////// BARANG ///////////////////////////
}
