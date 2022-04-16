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
use App\Models\Master_Peralatan;
use App\Models\Master_Pegawai;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class MasterController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Master';
        if (Master_Bahan::latest()->first()) {
            $this->kodebahan = sprintf("%05s", Master_Bahan::latest()->first()->id + 1);
        } else {
            $this->kodebahan = sprintf("%05s", 1);
        }
        if (Master_Peralatan::latest()->first()) {
            $this->kodealat = sprintf("%05s", Master_Peralatan::latest()->first()->id + 1);
        } else {
            $this->kodealat = sprintf("%05s", 1);
        }
        if (Master_Pegawai::latest()->first()) {
            $this->kodepegawai = sprintf("%03s", Master_Pegawai::latest()->first()->id + 1);
        } else {
            $this->kodepegawai = sprintf("%03s", 1);
        }
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
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

            if (Master_Supplier::where('delete', false)->where('nama', $request->input('nama'))->count()) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' => 'Nama Telah Ada'
                ];
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
        if (Master_Supplier::where('id', $id)->update(['delete' => true])) {
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
        $this->data['kode'] = $this->kodebahan;
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
                $value['kode'],
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
                'nama' => 'required',
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
            if (Master_Bahan::where('delete', false)->where('nama', $request->input('nama'))->count()) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' => 'Nama Telah Ada'
                ];
            } else {
                if ($request->input('kategori')) {
                    if ($request->input('kategori') == 1) {
                        $kategori = 'S' . sprintf("%05s", $this->kodebahan);
                    } elseif ($request->input('kategori') == 2) {
                        $kategori = 'B' . sprintf("%05s", $this->kodebahan);
                    } elseif ($request->input('kategori') == 3) {
                        $kategori = 'K' . sprintf("%05s", $this->kodebahan);
                    } elseif ($request->input('kategori') == 4) {
                        $kategori = 'D' . sprintf("%05s", $this->kodebahan);
                    } else {
                        $kategori = 'X' . sprintf("%05s", 0);
                    }
                } else {
                    $kategori = 'X' . sprintf("%05s", 0);
                }
                $input = [
                    'nama' => $request->input('nama'),
                    'kode' => 'BB' . $kategori,
                    'kategori' => $request->input('kategori'),
                    'satuan_pembelian' => $request->input('satuan_pembelian'),
                    'harga' =>  $this->unrupiah($request->input('harga')),
                    'satuan_pemakaian' => $request->input('satuan_pemakaian'),
                    'konversi_pemakaian' => $this->unrupiah($request->input('konversi_pemakaian')),
                    'satuan_pengeluaran' => $request->input('satuan_pengeluaran'),
                    'konversi_pengeluaran' => $this->unrupiah($request->input('konversi_pengeluaran')),
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
        }


        echo json_encode($data);
    }

    public function BahanEdit(Request $request)
    {
        $id = $request->input('id');
        session()->flash('IdEdit', $id);

        $this->data['BahanData'] = Master_Bahan::where('id', $id)->first();
        $this->data['kode'] = sprintf("%05s", $this->data['BahanData']['id']);
        return view('Edit', $this->data);
    }

    public function BahanEditTambah(Request $request)
    {

        $id = session('IdEdit');
        $Bahan = Master_Bahan::where('id', $id)->first();
        if ($Bahan) {
            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'nama' => 'required',
                    'kategori' => 'required',
                    'satuan_pembelian' => 'required',
                    'hargaa' => 'required',
                    'satuan_pemakaian' => 'required',
                    'konversi_pemakaiann' => 'required',
                    'satuan_pengeluaran' => 'required',
                    'konversi_pengeluarann' => 'required',
                ],
                $messages  = [
                    'required' => 'Form :attribute harus terisi',
                    'same' => 'Form :attribute & :other tidak sama.',
                ]
            );

            if ($Bahan['nama'] == $request->input('nama')) {
                $nama = $request->input('nama');
            } else {
                $str = Master_Bahan::where('nama', $request->input('nama'))->count();
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

                    if ($request->input('kategori')) {
                        if ($request->input('kategori') == 1) {
                            $kategori = 'S' . sprintf("%05s", $Bahan['id']);
                        } elseif ($request->input('kategori') == 2) {
                            $kategori = 'B' . sprintf("%05s", $Bahan['id']);
                        } elseif ($request->input('kategori') == 3) {
                            $kategori = 'K' . sprintf("%05s", $Bahan['id']);
                        } elseif ($request->input('kategori') == 4) {
                            $kategori = 'D' . sprintf("%05s", $Bahan['id']);
                        } else {
                            $kategori = 'X' . sprintf("%05s", 0);
                        }
                    } else {
                        $kategori = 'X' . sprintf("%05s", 0);
                    }
                    $input = [
                        'nama' => $request->input('nama'),
                        'kode' => 'BB' . $kategori,
                        'kategori' => $request->input('kategori'),
                        'satuan_pembelian' => $request->input('satuan_pembelian'),
                        'harga' =>  $this->unrupiah($request->input('hargaa')),
                        'satuan_pemakaian' => $request->input('satuan_pemakaian'),
                        'konversi_pemakaian' => $this->unrupiah($request->input('konversi_pemakaiann')),
                        'satuan_pengeluaran' => $request->input('satuan_pengeluaran'),
                        'konversi_pengeluaran' => $this->unrupiah($request->input('konversi_pengeluarann')),
                        'delete' => false,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    if (Master_Bahan::where('id', $id)->update($input)) {
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
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'ID Tidak Ditemukan, Refresh'
            ];
        }

        echo json_encode($data);
    }

    public function BahanHapus(Request $request)
    {
        $id =  $request->input('id');
        if (Master_Bahan::where('id', $id)->update(['delete' => true])) {
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



    ////////////////////////////////// PERALATAN ///////////////////////////
    public function Peralatan(Request $request)
    {
        $this->data['subtitle'] = 'Peralatan';
        $this->data['kode'] = $this->kodealat;
        return view('Master_Peralatan', $this->data);
    }

    public function PeralatanManage(Request $request)
    {
        $this->data['subtitle'] = 'Peralatan';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Master_Peralatan::where('delete', false)->latest()->get();
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
                    $kategori = 'Peralatan Baku Segar';
                } elseif ($value['kategori'] == 2) {
                    $kategori = 'Peralatan Baku Beku';
                } elseif ($value['kategori'] == 3) {
                    $kategori = 'Peralatan Baku Dalam Kemasan';
                } elseif ($value['kategori'] == 4) {
                    $kategori = 'Peralatan Baku Dingin';
                } else {
                    $kategori = 'Not Found';
                }
            } else {
                $kategori = 'Not Found';
            }

            $konversi = 'Pemakaian : ' . $value['konversi_pemakaian'] . ' ' . $value['satuan_pemakaian'];
            $result['data'][] = array(
                $value['kode'],
                $value['nama'],
                $kategori,
                $value['satuan_pembelian'],
                $this->rupiah($value['harga']), $konversi,
                $button
            );
        }
        echo json_encode($result);
    }

    public function PeralatanTambah(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required',
                'kategori' => 'required',
                'satuan_pembelian' => 'required',
                'harga' => 'required',
                'satuan_pemakaian' => 'required',
                'konversi_pemakaian' => 'required'
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
            if (Master_Peralatan::where('delete', false)->where('nama', $request->input('nama'))->count()) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' => 'Nama Telah Ada'
                ];
            } else {
                if ($request->input('kategori')) {
                    if ($request->input('kategori') == 1) {
                        $kategori = 'D' . sprintf("%05s", $this->kodealat);
                    } elseif ($request->input('kategori') == 2) {
                        $kategori = 'K' . sprintf("%05s", $this->kodealat);
                    } elseif ($request->input('kategori') == 3) {
                        $kategori = 'B' . sprintf("%05s", $this->kodealat);
                    } elseif ($request->input('kategori') == 4) {
                        $kategori = 'W' . sprintf("%05s", $this->kodealat);
                    } elseif ($request->input('kategori') == 4) {
                        $kategori = 'L' . sprintf("%05s", $this->kodealat);
                    } else {
                        $kategori = 'X' . sprintf("%05s", 0);
                    }
                } else {
                    $kategori = 'X' . sprintf("%05s", 0);
                }
                $input = [
                    'nama' => $request->input('nama'),
                    'kode' => 'P' . $kategori,
                    'kategori' => $request->input('kategori'),
                    'satuan_pembelian' => $request->input('satuan_pembelian'),
                    'harga' =>  $this->unrupiah($request->input('harga')),
                    'satuan_pemakaian' => $request->input('satuan_pemakaian'),
                    'konversi_pemakaian' => $this->unrupiah($request->input('konversi_pemakaian')),
                    'delete' => false,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if (Master_Peralatan::create($input)) {
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

    public function PeralatanEdit(Request $request)
    {
        $id = $request->input('id');
        session()->flash('IdEdit', $id);
        $this->data['kode'] = $this->kodealat;

        $this->data['PeralatanData'] = Master_Peralatan::where('id', $id)->first();
        return view('Edit', $this->data);
    }

    public function PeralatanEditTambah(Request $request)
    {

        $id = session('IdEdit');
        $Peralatan = Master_Peralatan::where('id', $id)->first();
        if ($Peralatan) {
            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'nama' => 'required',
                    'kategori' => 'required',
                    'satuan_pembelian' => 'required',
                    'hargaa' => 'required',
                    'satuan_pemakaian' => 'required',
                    'konversi_pemakaiann' => 'required'
                ],
                $messages  = [
                    'required' => 'Form :attribute harus terisi',
                    'same' => 'Form :attribute & :other tidak sama.',
                ]
            );

            if ($Peralatan['nama'] == $request->input('nama')) {
                $nama = $request->input('nama');
            } else {
                $str = Master_Peralatan::where('nama', $request->input('nama'))->count();
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

                    if ($request->input('kategori')) {
                        if ($request->input('kategori') == 1) {
                            $kategori = 'D' . sprintf("%05s", $Peralatan['id']);
                        } elseif ($request->input('kategori') == 2) {
                            $kategori = 'K' . sprintf("%05s", $Peralatan['id']);
                        } elseif ($request->input('kategori') == 3) {
                            $kategori = 'B' . sprintf("%05s", $Peralatan['id']);
                        } elseif ($request->input('kategori') == 4) {
                            $kategori = 'W' . sprintf("%05s", $Peralatan['id']);
                        } elseif ($request->input('kategori') == 4) {
                            $kategori = 'L' . sprintf("%05s", $Peralatan['id']);
                        } else {
                            $kategori = 'X' . sprintf("%05s", 0);
                        }
                    } else {
                        $kategori = 'X' . sprintf("%05s", 0);
                    }

                    $input = [
                        'nama' => $request->input('nama'),
                        'kode' => 'P' . $kategori,
                        'kategori' => $request->input('kategori'),
                        'satuan_pembelian' => $request->input('satuan_pembelian'),
                        'harga' =>  $this->unrupiah($request->input('hargaa')),
                        'satuan_pemakaian' => $request->input('satuan_pemakaian'),
                        'konversi_pemakaian' => $this->unrupiah($request->input('konversi_pemakaiann')),
                        'delete' => false,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    if (Master_Peralatan::where('id', $id)->update($input)) {
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

    public function PeralatanHapus(Request $request)
    {
        $id =  $request->input('id');
        if (Master_Peralatan::where('id', $id)->update(['delete' => true])) {
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
    ////////////////////////////////// PERALATAN ///////////////////////////




    ////////////////////////////////// Pegawai ///////////////////////////
    public function Pegawai(Request $request)
    {
        $this->data['subtitle'] = 'Pegawai';
        $this->data['kode'] = $this->kodealat;
        $this->data['Datastore'] = Store::where('active', 1)->get();
        return view('Master_Pegawai', $this->data);
    }

    public function PegawaiManage(Request $request)
    {
        $this->data['subtitle'] = 'Pegawai';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Master_Pegawai::with('Store')->where('delete', false)->latest()->get();
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


            $result['data'][] = array(
                $value['kode'],
                $value['store']->nama,
                $value['nama'],
                $value['tempat_lahir'] . ',<br>' . $value['tanggal_lahir'],
                $value['tanggal_masuk'],
                $value['agama'],
                $value['gender'],
                $value['wa'],
                $value['jabatan'] . '<br>' . $value['divisi'],
                $button
            );
        }
        echo json_encode($result);
    }

    public function PegawaiTambah(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required',
                'store' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'tanggal_masuk' => 'required',
                'agama' => 'required',
                'gender' => 'required',
                'alamat' => 'required',
                'wa' => 'required',
                'divisi' => 'required',
                'jabatan' => 'required',
                'status_pekerja' => 'required',
                'img' => 'mimes:jpeg,jpg,png'
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
            if (Master_Pegawai::where('delete', false)->where('nama', $request->input('nama'))->count()) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' => 'Nama Telah Ada'
                ];
            } else {
                $kode = $request->input('store') . date_format(date_create($request->input('tanggal_masuk')), 'ym') . date_format(date_create($request->input('tanggal_lahir')), 'ymd') . $this->kodepegawai;

                if ($request->hasFile('img')) {
                    $files = $request->file('img');
                    $imageName = $kode . '.' . $files->getClientOriginalExtension();
                    $files->move(public_path('uploads/pegawai'), $imageName);
                    $urlimg = url('/') . '/uploads/pegawai/' . $imageName;
                } else {
                    $urlimg = '';
                }
                $input = [
                    'kode' => $kode,
                    'nama' => $request->input('nama'),
                    'store_id' => $request->input('store'),
                    'tempat_lahir' => $request->input('tempat_lahir'),
                    'tanggal_lahir' => date_create($request->input('tanggal_lahir')),
                    'tanggal_masuk' => date_create($request->input('tanggal_masuk')),
                    'agama' => $request->input('agama'),
                    'gender' => $request->input('gender'),
                    'alamat' => $request->input('alamat'),
                    'wa' => $request->input('wa'),
                    'divisi' => $request->input('divisi'),
                    'jabatan' => $request->input('jabatan'),
                    'active' => $request->input('status_pekerja'),
                    'img' => $urlimg,
                    'delete' => false,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if (Master_Pegawai::create($input)) {
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

    public function PegawaiEdit(Request $request)
    {
        $id = $request->input('id');
        session()->flash('IdEdit', $id);
        $this->data['kode'] = $this->kodepegawai;

        $this->data['PegawaiData'] = Master_Pegawai::where('id', $id)->first();
        $this->data['Datastore'] = Store::where('active', 1)->get();
        return view('Edit', $this->data);
    }

    public function PegawaiEditTambah(Request $request)
    {

        $id = session('IdEdit');
        $Pegawai = Master_Pegawai::where('id', $id)->first();
        if ($Pegawai) {
            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'nama' => 'required',
                    'store' => 'required',
                    'tempat_lahir' => 'required',
                    'tanggal_lahir' => 'required',
                    'tanggal_masuk' => 'required',
                    'agama' => 'required',
                    'gender' => 'required',
                    'alamat' => 'required',
                    'wa' => 'required',
                    'divisi' => 'required',
                    'jabatan' => 'required',
                    'status_pekerja' => 'required',
                    'img' => 'mimes:jpeg,jpg,png'
                ],
                $messages  = [
                    'required' => 'Form :attribute harus terisi',
                    'same' => 'Form :attribute & :other tidak sama.',
                ]
            );

            if ($Pegawai['nama'] == $request->input('nama')) {
                $nama = $request->input('nama');
            } else {
                $str = Master_Pegawai::where('nama', $request->input('nama'))->count();
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

                    $kode = $request->input('store') . date_format(date_create($request->input('tanggal_masuk')), 'ym') . date_format(date_create($request->input('tanggal_lahir')), 'ymd') . sprintf("%03s",  $Pegawai['id']);
                    if ($request->hasFile('img')) {
                        $files = $request->file('img');
                        $imageName = $kode . '.' . $files->getClientOriginalExtension();
                        $files->move(public_path('uploads/pegawai'), $imageName);
                        $urlimg = url('/') . '/uploads/pegawai/' . $imageName;
                    } else {
                        $urlimg = $Pegawai['img'];
                    }


                    $input = [
                        'kode' => $kode,
                        'nama' => $request->input('nama'),
                        'store_id' => $request->input('store'),
                        'tempat_lahir' => $request->input('tempat_lahir'),
                        'tanggal_lahir' => date_create($request->input('tanggal_lahir')),
                        'tanggal_masuk' => date_create($request->input('tanggal_masuk')),
                        'agama' => $request->input('agama'),
                        'gender' => $request->input('gender'),
                        'alamat' => $request->input('alamat'),
                        'wa' => $request->input('wa'),
                        'divisi' => $request->input('divisi'),
                        'jabatan' => $request->input('jabatan'),
                        'active' => $request->input('status_pekerja'),
                        'img' => $urlimg,
                        'delete' => false,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    if (Master_Pegawai::where('id', $id)->update($input)) {
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

    public function PegawaiHapus(Request $request)
    {
        $id =  $request->input('id');
        if (Master_Pegawai::where('id', $id)->update(['delete' => true])) {
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
    ////////////////////////////////// PERALATAN ///////////////////////////
}
