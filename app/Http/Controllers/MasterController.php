<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Supplier;
use App\Models\Bahan;
use App\Models\Peralatan;
use App\Models\Pegawai;
use App\Models\Satuan;


use App\Exports\BahanExport;
use App\Imports\BahanImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Picqer\Barcode\BarcodeGeneratorPNG;

class MasterController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Master';
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }


    /////////////////////////////////// SUPLIER //////////////////////////
    public function Supplier(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewSupplier', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Supplier';
        return view('Supplier', $this->data);
    }

    public function SupplierManage(Request $request)
    {

        if (!in_array('viewSupplier', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Supplier';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Supplier::where('delete', false)->latest()->get();
        foreach ($Data as $value) {
            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('updateSupplier', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Edit(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")' data-toggle='modal' data-target='#Modal' ><i class='fas fa-pencil-alt'></i> Edit</a></li>";
            }
            if (in_array('deleteSupplier', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")'  ><i class='fas fa-trash-alt'></i> Hapus</a></li>";
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

        if (!in_array('createSupplier', $this->permission())) {
            return redirect()->to('/');
        }

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

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  $message
                ];
            }
        } else {

            if (Supplier::where('delete', false)->where('nama', $request->input('nama'))->count()) {
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
                    'rekening' => $request->input('rekening'),
                    'hutang' => $request->input('hutang'),
                    'wa' => $request->input('wa'),
                    'delete' => false
                ];
                if (Supplier::create($input)) {
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

        if (!in_array('updateSupplier', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');
        $request->session()->put('IdEdit', $id);

        $this->data['SupplierData'] = Supplier::where('id', $id)->first();
        return view('Edit', $this->data);
    }

    public function SupplierEditTambah(Request $request)
    {

        if (!in_array('updateSupplier', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->session()->get('IdEdit');
        $SUpplier = Supplier::where('id', $id)->first();
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
                $str = Supplier::where('nama', $request->input('nama'))->count();
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
                        'wa' => $request->input('wa')
                    ];
                    if (Supplier::where('id', $id)->update($input)) {
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
        if (!in_array('deleteSupplier', $this->permission())) {
            return redirect()->to('/');
        }

        $id =  $request->input('id');
        if (Supplier::where('id', $id)->update(['delete' => true])) {
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


    ////////////////////////////////// BAHAN ///////////////////////////
    public function Bahan(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewBahan', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Bahan';
        $this->data['Store'] = Store::where('tipe', 'Outlet')->orWhere('tipe', 'Logistik')->get();
        $this->data['satuan'] = Satuan::all();
        return view('Bahan', $this->data);
    }

    public function BahanManage(Request $request)
    {

        if (!in_array('viewBahan', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Bahan';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Bahan::where('delete', false)->latest()->get();
        foreach ($Data as $value) {
            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('updateBahan', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Edit(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")' data-toggle='modal' data-target='#Modal' ><i class='fas fa-pencil-alt'></i> Edit</a></li>";
            }
            if (in_array('deleteBahan', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")'><i class='fas fa-trash-alt'></i> Hapus</a></li>";
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
                } elseif ($value['kategori'] == 11) {
                    $kategori = 'Bahan Supplay';
                } elseif ($value['kategori'] == 21) {
                    $kategori = 'Bahan Oprasional';
                } else {
                    $kategori = 'Not Found';
                }
            } else {
                $kategori = 'Not Found';
            }

            $konversi = 'Pemakaian : ' . $value['konversi_pemakaian'] . ' ' . $value['satuan_pemakaian'] . '<br> Pengeluaran : ' . $value['konversi_pengeluaran'] . ' ' . $value['satuan_pengeluaran'];

            $str = json_decode($value['pengguna']);
            $pengguna = '';
            if ($str) {
                foreach ($str as $v) {
                    $dtstr = Store::where('id', $v)->first();
                    if ($dtstr) {
                        $pengguna .= '<font size="2px">' . $dtstr['nama'] . '</font>, ';
                    }
                }
            } else {
                $pengguna .= 'Semua';
            }

            $generator = new BarcodeGeneratorPNG();

            if ($value['barcode']) {
                $barcode = '<i style="color:green" class="fa fa-check"></i>';
            } else {
                $barcode = '';
            }
            $result['data'][] = array(
                '<center><img width="150px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($value['kode'], $generator::TYPE_CODE_128)) . '"><br>' . $value['kode'] . ' ' . $barcode . '</center>',
                $value['nama'],
                $kategori,
                $this->rupiah($value['harga']) . '/' . $value['satuan_pembelian'],
                $konversi,
                $pengguna,
                $button
            );
        }
        echo json_encode($result);
    }

    public function BahanTambah(Request $request)
    {

        if (!in_array('createBahan', $this->permission())) {
            return redirect()->to('/');
        }
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
            if (Bahan::where('delete', false)->where('nama', $request->input('nama'))->count()) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' => 'Nama Telah Ada'
                ];
            } else {
                if ($request->input('kategori')) {

                    if ($request->input('kategori') == 1) {
                        $kategori = 'BBS' . sprintf("%05s", Bahan::where('kategori', $request->input('kategori'))->count() + 1);
                    } elseif ($request->input('kategori') == 2) {
                        $kategori = 'BBB' . sprintf("%05s", Bahan::where('kategori', $request->input('kategori'))->count() + 1);
                    } elseif ($request->input('kategori') == 3) {
                        $kategori = 'BBK' . sprintf("%05s", Bahan::where('kategori', $request->input('kategori'))->count() + 1);
                    } elseif ($request->input('kategori') == 4) {
                        $kategori = 'BBD' . sprintf("%05s", Bahan::where('kategori', $request->input('kategori'))->count() + 1);
                    } elseif ($request->input('kategori') == 11) {
                        $kategori = 'BS' . sprintf("%06s", Bahan::where('kategori', $request->input('kategori'))->count() + 1);
                    } elseif ($request->input('kategori') == 21) {
                        $kategori = 'BO' . sprintf("%06s", Bahan::where('kategori', $request->input('kategori'))->count() + 1);
                    } else {
                        $kategori = 'X' . sprintf("%06s", Bahan::where('kategori', $request->input('kategori'))->count() + 1);
                    }
                } else {
                    $kategori = 'X' . sprintf("%06s", Bahan::where('kategori', $request->input('kategori'))->count());
                }


                if ($request->input('pengguna')) {
                    $pengguna = json_encode($request->input('pengguna'));
                } else {
                    $pengguna = null;
                }

                if (Bahan::where('kode', $kategori)->count()) {
                    if ($request->input('kategori')) {
                        if ($request->input('kategori') == 1) {
                            $ktgr = 'BBS' . sprintf("%05s", Bahan::where('kategori', $request->input('kategori'))->count() + 2);
                        } elseif ($request->input('kategori') == 2) {
                            $ktgr = 'BBB' . sprintf("%05s", Bahan::where('kategori', $request->input('kategori'))->count() + 2);
                        } elseif ($request->input('kategori') == 3) {
                            $ktgr = 'BBK' . sprintf("%05s", Bahan::where('kategori', $request->input('kategori'))->count() + 2);
                        } elseif ($request->input('kategori') == 4) {
                            $ktgr = 'BBD' . sprintf("%05s", Bahan::where('kategori', $request->input('kategori'))->count() + 2);
                        } elseif ($request->input('kategori') == 11) {
                            $ktgr = 'BS' . sprintf("%06s", Bahan::where('kategori', $request->input('kategori'))->count() + 2);
                        } elseif ($request->input('kategori') == 21) {
                            $ktgr = 'BO' . sprintf("%06s", Bahan::where('kategori', $request->input('kategori'))->count() + 2);
                        } else {
                            $ktgr = 'X' . sprintf("%06s", Bahan::where('kategori', $request->input('kategori'))->count() + 2);
                        }
                    } else {
                        $ktgr = 'X' . sprintf("%06s", Bahan::where('kategori', $request->input('kategori'))->count());
                    }
                } else {
                    $ktgr = $kategori;
                }

                $input = [
                    'nama' => $request->input('nama'),
                    'kode' => $ktgr,
                    'kategori' => $request->input('kategori'),
                    'satuan_pembelian' => $request->input('satuan_pembelian'),
                    'harga' =>  $this->unrupiah($request->input('harga')),
                    'satuan_pemakaian' => $request->input('satuan_pemakaian'),
                    'konversi_pemakaian' => $this->unrupiah($request->input('konversi_pemakaian')),
                    'satuan_pengeluaran' => $request->input('satuan_pengeluaran'),
                    'konversi_pengeluaran' => $this->unrupiah($request->input('konversi_pengeluaran')),
                    'barcode' => $request->input('barcode'),
                    'pengguna' => $pengguna,
                    'delete' => false
                ];
                if (Bahan::create($input)) {
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

        if (!in_array('updateBahan', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');
        $request->session()->put('IdEdit', $id);

        $this->data['BahanData'] = Bahan::where('id', $id)->first();
        $this->data['Store'] = Store::where('tipe', 'Outlet')->orWhere('tipe', 'Logistik')->get();
        $this->data['satuan'] = Satuan::all();
        return view('Edit', $this->data);
    }

    public function BahanEditTambah(Request $request)
    {

        if (!in_array('updateBahan', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->session()->get('IdEdit');
        $Bahan = Bahan::where('id', $id)->first();
        if ($Bahan) {
            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'nama' => 'required',
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

            if ($Bahan['nama'] == $request->input('nama')) {
                $nama = $request->input('nama');
            } else {
                $str = Bahan::where('nama', $request->input('nama'))->count();
                if ($str) {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Nama Telah digunakan'
                    ];
                    $nama = false;
                } else {
                    $nama = $request->input('nama');
                }
            }


            if ($nama) {
                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $message) {
                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  $message
                        ];
                    }
                } else {

                    if ($request->input('pengguna')) {
                        $pengguna = json_encode($request->input('pengguna'));
                    } else {
                        $pengguna = null;
                    }

                    $input = [
                        'nama' => $request->input('nama'),
                        'satuan_pembelian' => $request->input('satuan_pembelian'),
                        'harga' =>  $this->unrupiah($request->input('harga')),
                        'satuan_pemakaian' => $request->input('satuan_pemakaian'),
                        'konversi_pemakaian' => $this->unrupiah($request->input('konversi_pemakaian')),
                        'satuan_pengeluaran' => $request->input('satuan_pengeluaran'),
                        'konversi_pengeluaran' => $this->unrupiah($request->input('konversi_pengeluaran')),
                        'barcode' => $request->input('barcode'),
                        'pengguna' => $pengguna,
                        'delete' => false
                    ];
                    if (Bahan::where('id', $id)->update($input)) {
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
        if (!in_array('deleteBahan', $this->permission())) {
            return redirect()->to('/');
        }
        $id =  $request->input('id');
        if (Bahan::where('id', $id)->update(['delete' => true])) {
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

    public function PrintBarcode(Request $request)
    {

        $generator = new BarcodeGeneratorPNG();

        $Data = Bahan::where('delete', false)->latest()->get();
        echo
        '
            <html>
            <body onload="print()" style="width:80mm">
            <div class="page">';

        $total = count($Data) - 1;
        foreach ($Data as $key => $value) {
            if (
                substr($key, -1) == 0 ||
                substr($key, -1) == 2 ||
                substr($key,  -1) == 4 ||
                substr($key,  -1) == 6 ||
                substr($key,  -1) == 8
            ) {
                echo '<div style="display:flex">';
            }
            echo
            '
                <div class="barcode">
                <small style="font-size: 7px;">' . $value['nama'] . '</small>
                <br><img width="115px" height="30px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($value['kode'], $generator::TYPE_CODE_39)) . '">
                <br> <small style="font-size: 9px;">' . $value['kode'] . '</small>
                </div>';


            if (
                substr($key,  -1) == 1 ||
                substr($key,  -1) == 3 ||
                substr($key,  -1) == 5 ||
                substr($key,  -1) == 7 ||
                substr($key,  -1) == 9 || $total == $key
            ) {
                echo '</div>';
            }
        }
        echo '</div>
            <style>

            .page{
                font-family: monospace;
            }
            .barcode {
                text-align:center;
                margin: 10px 7px;
                padding: 5px 10px;
                border-radius: 10px;
                border: 1px solid;
            }
            </style>
            </body>
            </html>
            ';


        // echo '<body onload="print()" style="width:80mm"><div class="page"><table style="width: 100%;">';
        // foreach ($Data as $key => $value) {
        //     echo
        //     '

        //     <tr>
        //         <td >
        //         <small style="font-size: 7px;">' . $value['nama'] . '</small>
        //         <br><img width="115px" height="30px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($value['kode'], $generator::TYPE_CODE_39)) . '">
        //         <br><small style="font-size: 9px;">' . $value['kode'] . '</small>
        //         </td>
        //     </tr>
        //         ';
        // }
        // echo '</table></div></body><style>td {text-align: center;padding:5px}</style>';
    }

    public function BahanExport(Request $request)
    {
        return Excel::download(new BahanExport, 'Master Bahan.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }


    public function BahanImport(Request $request)
    {
        $rows = Excel::toArray(new BahanImport, $request->file('import'));
        $error = '';
        if (isset($rows[0][0]['nama']) && isset($rows[0][0]['satuan_pembelian'])) {
            if ($rows[0][0]['kode']) {

                foreach ($rows[0] as $key => $row) {
                    if (
                        isset($row['nama']) &&
                        isset($row['kode']) &&
                        isset($row['kategori']) &&
                        isset($row['satuan_pembelian']) &&
                        isset($row['harga']) &&
                        isset($row['satuan_pemakaian']) &&
                        isset($row['pembelian_ke_pemakaian']) &&
                        isset($row['satuan_pengeluaran']) &&
                        isset($row['pembelian_ke_pengeluaran'])
                    ) {
                        if (
                            $row['kategori'] == 1 ||
                            $row['kategori'] == 2 ||
                            $row['kategori'] == 3 ||
                            $row['kategori'] == 4 ||
                            $row['kategori'] == 11 ||
                            $row['kategori'] == 21
                        ) {
                            if (
                                strlen($row['nama']) <= 50 &&
                                strlen($row['kode']) <= 20 &&
                                strlen($row['kategori']) <= 20 &&
                                strlen($row['satuan_pembelian']) <= 10 &&
                                strlen($row['harga']) <= 11 &&
                                strlen($row['satuan_pemakaian']) <= 10 &&
                                strlen($row['pembelian_ke_pemakaian']) <= 20 &&
                                strlen($row['satuan_pengeluaran']) <= 10 &&
                                strlen($row['pembelian_ke_pengeluaran']) <= 20
                            ) {
                                if ($row['id']) {
                                    if (Bahan::where('id', $row['id'])->count()) {
                                        if (Bahan::where('kode', $row['kode'])->count() < 2) {
                                        } else {
                                            $error .= '<font style="color:red"><i class="fa fa-times"></i> Kode Barang ' . $row['kode'] . ' Duplicate</font><br>';
                                        }
                                    } else {
                                        $error .= '<font style="color:red"><i class="fa fa-times"></i> ID ' . $row['id'] . ' Tidak ditemukan, Gagal Update</font><br>';
                                    }
                                } else {
                                    if (!Bahan::where('kode', $row['kode'])->count()) {
                                        if (strlen($row['kode']) == 8) {
                                        } else {
                                            $error .= '<font style="color:red"><i class="fa fa-times"></i> Kode Barang ' . $row['kode'] . ' Tidak Valid</font><br>';
                                        }
                                    } else {
                                        $error .= '<font style="color:red"><i class="fa fa-times"></i> Kode Barang ' . $row['kode'] . ' Telah Ada</font><br>';
                                    }
                                }
                            } else {
                                $error .= '<font style="color:red"><i class="fa fa-times"></i> Pada ' . $row['kode'] . ' Ada Text Terlalu Panjang</font><br>';
                            }
                        } else {
                            $error .= '<font style="color:red"><i class="fa fa-times"></i> Kategori ' . $row['kode'] . ' Tidak Valid</font><br>';
                        }
                    } else {
                        $error .= '<font style="color:red"><i class="fa fa-times"></i> Format Excel Tidak didukung </font><br>';
                    }
                }
            } else {
                $error .= '<font style="color:red"><i class="fa fa-times"></i> Tidak Ada Isi </font><br>';
            }
        } else {
            $error .= '<font style="color:red"><i class="fa fa-times"></i> Format Excel Tidak didukung </font><br>';
        }
        if ($error) {

            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  $error
            ];
        } else {
            foreach ($rows[0] as $key => $row) {
                if ($row['id']) {
                    Bahan::where('id', $row['id'])->update([
                        'nama' => ucwords($row['nama']),
                        'kode' => $row['kode'],
                        'kategori' => $row['kategori'],
                        'satuan_pembelian' => $row['satuan_pembelian'],
                        'harga' => $row['harga'],
                        'satuan_pemakaian' => $row['satuan_pemakaian'],
                        'konversi_pemakaian' => $row['pembelian_ke_pemakaian'],
                        'satuan_pengeluaran' => $row['satuan_pengeluaran'],
                        'konversi_pengeluaran' => $row['pembelian_ke_pengeluaran']
                    ]);
                } else {
                    Bahan::create([
                        'nama' => $row['nama'],
                        'kode' => $row['kode'],
                        'kategori' => $row['kategori'],
                        'satuan_pembelian' => $row['satuan_pembelian'],
                        'harga' => $row['harga'],
                        'satuan_pemakaian' => $row['satuan_pemakaian'],
                        'konversi_pemakaian' => $row['pembelian_ke_pemakaian'],
                        'satuan_pengeluaran' => $row['satuan_pengeluaran'],
                        'konversi_pengeluaran' => $row['pembelian_ke_pengeluaran']
                    ]);
                }
            }
            $data = [
                'toast' => true,
                'status' => 'success',
                'pesan' =>  'Berhasil diimport'
            ];
        }
        echo json_encode($data);
    }
    ////////////////////////////////// BAHAN ///////////////////////////



    ////////////////////////////////// PERALATAN ///////////////////////////
    public function Peralatan(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewPeralatan', $this->permission())) {
            return redirect()->to('/');
        }
        $this->data['subtitle'] = 'Peralatan';
        $this->data['Store'] = Store::where('tipe', 'Outlet')->get();
        $this->data['satuan'] = Satuan::all();
        return view('Peralatan', $this->data);
    }

    public function PeralatanManage(Request $request)
    {
        if (!in_array('viewPeralatan', $this->permission())) {
            return redirect()->to('/');
        }
        $this->data['subtitle'] = 'Peralatan';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Peralatan::where('delete', false)->latest()->get();
        foreach ($Data as $value) {
            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('updatePeralatan', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Edit(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")' data-toggle='modal' data-target='#Modal' ><i class='fas fa-pencil-alt'></i> Edit</a></li>";
            }
            if (in_array('deletePeralatan', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")'  ><i class='fas fa-trash-alt'></i> Hapus</a></li>";
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

            $str = json_decode($value['pengguna']);
            $pengguna = '';
            if ($str) {
                foreach ($str as $v) {
                    $dtstr = Store::where('id', $v)->first();
                    if ($dtstr) {
                        $pengguna .= '<font size="2px">' . $dtstr['nama'] . '</font>, ';
                    }
                }
            } else {
                $pengguna .= 'Semua';
            }

            $konversi = 'Pemakaian : ' . $value['konversi_pemakaian'] . ' ' . $value['satuan_pemakaian'];
            $result['data'][] = array(
                $value['kode'],
                $value['nama'],
                $kategori,
                $this->rupiah($value['harga']) . '/' . $value['satuan_pembelian'],
                $konversi,
                $pengguna,
                $button
            );
        }
        echo json_encode($result);
    }

    public function PeralatanTambah(Request $request)
    {

        if (!in_array('createPeralatan', $this->permission())) {
            return redirect()->to('/');
        }
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
            if (Peralatan::where('delete', false)->where('nama', $request->input('nama'))->count()) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' => 'Nama Telah Ada'
                ];
            } else {
                if ($request->input('kategori')) {
                    if ($request->input('kategori') == 1) {
                        $kategori = 'D' . sprintf("%05s", Peralatan::where('kategori', $request->input('kategori'))->count() + 1);
                    } elseif ($request->input('kategori') == 2) {
                        $kategori = 'K' . sprintf("%05s", Peralatan::where('kategori', $request->input('kategori'))->count() + 1);
                    } elseif ($request->input('kategori') == 3) {
                        $kategori = 'B' . sprintf("%05s", Peralatan::where('kategori', $request->input('kategori'))->count() + 1);
                    } elseif ($request->input('kategori') == 4) {
                        $kategori = 'W' . sprintf("%05s", Peralatan::where('kategori', $request->input('kategori'))->count() + 1);
                    } elseif ($request->input('kategori') == 4) {
                        $kategori = 'L' . sprintf("%05s", Peralatan::where('kategori', $request->input('kategori'))->count() + 1);
                    } else {
                        $kategori = 'X' . sprintf("%05s", Peralatan::where('kategori', $request->input('kategori'))->count() + 1);
                    }
                } else {
                    $kategori = 'X' . sprintf("%05s", Peralatan::where('kategori', $request->input('kategori'))->count() + 1);
                }


                if ($request->input('pengguna')) {
                    $pengguna = json_encode($request->input('pengguna'));
                } else {
                    $pengguna = null;
                }

                $input = [
                    'nama' => $request->input('nama'),
                    'kode' => 'P' . $kategori,
                    'kategori' => $request->input('kategori'),
                    'satuan_pembelian' => $request->input('satuan_pembelian'),
                    'harga' =>  $this->unrupiah($request->input('harga')),
                    'satuan_pemakaian' => $request->input('satuan_pemakaian'),
                    'konversi_pemakaian' => $this->unrupiah($request->input('konversi_pemakaian')),
                    'pengguna' => $pengguna,
                    'delete' => false
                ];
                if (Peralatan::create($input)) {
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
        if (!in_array('updatePeralatan', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->input('id');
        $request->session()->put('IdEdit', $id);

        $this->data['Store'] = Store::where('tipe', 'Outlet')->get();

        $this->data['satuan'] = Satuan::all();
        $this->data['PeralatanData'] = Peralatan::where('id', $id)->first();
        return view('Edit', $this->data);
    }

    public function PeralatanEditTambah(Request $request)
    {

        if (!in_array('updatePeralatan', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->session()->get('IdEdit');
        $Peralatan = Peralatan::where('id', $id)->first();
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
                $str = Peralatan::where('nama', $request->input('nama'))->count();
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
                    foreach ($validator->errors()->all() as $message) {
                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  $message
                        ];
                    }
                } else {


                    if ($request->input('pengguna')) {
                        $pengguna = json_encode($request->input('pengguna'));
                    } else {
                        $pengguna = null;
                    }
                    $input = [
                        'nama' => $request->input('nama'),
                        'satuan_pembelian' => $request->input('satuan_pembelian'),
                        'harga' =>  $this->unrupiah($request->input('hargaa')),
                        'satuan_pemakaian' => $request->input('satuan_pemakaian'),
                        'pengguna' => $pengguna,
                        'konversi_pemakaian' => $this->unrupiah($request->input('konversi_pemakaiann')),
                        'delete' => false
                    ];
                    if (Peralatan::where('id', $id)->update($input)) {
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
        if (!in_array('deletePeralatan', $this->permission())) {
            return redirect()->to('/');
        }
        $id =  $request->input('id');
        if (Peralatan::where('id', $id)->update(['delete' => true])) {
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
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewPegawai', $this->permission())) {
            return redirect()->to('/');
        }
        $this->data['subtitle'] = 'Pegawai';
        $this->data['Datastore'] = Store::where('active', 1)->get();
        return view('Pegawai', $this->data);
    }

    public function PegawaiManage(Request $request)
    {
        if (!in_array('viewPegawai', $this->permission())) {
            return redirect()->to('/');
        }
        $this->data['subtitle'] = 'Pegawai';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Pegawai::with('Store')->where('delete', false)->latest()->get();
        foreach ($Data as $value) {
            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('updatePegawai', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Edit(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")' data-toggle='modal' data-target='#Modal' ><i class='fas fa-pencil-alt'></i> Edit</a></li>";
            }
            if (in_array('deletePegawai', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")'  ><i class='fas fa-trash-alt'></i> Hapus</a></li>";
            }

            $button .= '</ul></div>';


            $result['data'][] = array(
                $value['kode'],
                $value['store']->nama,
                $value['nama'],
                $value['tempat_lahir'] . ',<br>' . $this->tanggal($value['tanggal_lahir'], true),
                $this->tanggal($value['tanggal_masuk'], true),
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

        if (!in_array('createPegawai', $this->permission())) {
            return redirect()->to('/');
        }
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
            if (Pegawai::where('delete', false)->where('nama', $request->input('nama'))->count()) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' => 'Nama Telah Ada'
                ];
            } else {
                $kode = 'PRS' . $request->input('store')   . sprintf("%05s", Pegawai::where('store_id', $request->input('store'))->count() + 1);

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
                    'delete' => false
                ];
                if (Pegawai::create($input)) {
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
        if (!in_array('updatePegawai', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->input('id');
        $request->session()->put('IdEdit', $id);

        $this->data['PegawaiData'] = Pegawai::where('id', $id)->first();
        $this->data['Datastore'] = Store::where('active', 1)->get();
        return view('Edit', $this->data);
    }

    public function PegawaiEditTambah(Request $request)
    {

        if (!in_array('updatePegawai', $this->permission())) {
            return redirect()->to('/');
        }
        $id = session('IdEdit');
        $Pegawai = Pegawai::where('id', $id)->first();
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
                $str = Pegawai::where('nama', $request->input('nama'))->count();
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
                    foreach ($validator->errors()->all() as $message) {
                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  $message
                        ];
                    }
                } else {

                    if ($request->hasFile('img')) {
                        $files = $request->file('img');
                        $imageName = $Pegawai['kode'] . '.' . $files->getClientOriginalExtension();
                        $files->move(public_path('uploads/pegawai'), $imageName);
                        $urlimg = url('/') . '/uploads/pegawai/' . $imageName;
                    } else {
                        $urlimg = $Pegawai['img'];
                    }


                    $input = [
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
                        'delete' => false
                    ];
                    if (Pegawai::where('id', $id)->update($input)) {
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
        if (!in_array('deletePegawai', $this->permission())) {
            return redirect()->to('/');
        }
        $id =  $request->input('id');
        if (Pegawai::where('id', $id)->update(['delete' => true])) {
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




    /////////////////////////////////// SATUAN //////////////////////////
    public function Satuan(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewSatuan', $this->permission())) {
            return redirect()->to('/');
        }
        $this->data['subtitle'] = 'Satuan';
        return view('Satuan', $this->data);
    }

    public function SatuanManage(Request $request)
    {
        if (!in_array('viewSatuan', $this->permission())) {
            return redirect()->to('/');
        }
        $this->data['subtitle'] = 'Satuan';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Satuan::where('delete', false)->latest()->get();
        foreach ($Data as $value) {
            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('updateSatuan', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Edit(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")' data-toggle='modal' data-target='#Modal' ><i class='fas fa-pencil-alt'></i> Edit</a></li>";
            }
            if (in_array('deleteSatuan', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")'  ><i class='fas fa-trash-alt'></i> Hapus</a></li>";
            }

            $button .= '</ul></div>';


            $result['data'][] = array(
                $value['nama'],
                $value['singkat'],
                $button
            );
        }
        echo json_encode($result);
    }

    public function SatuanTambah(Request $request)
    {
        if (!in_array('createSatuan', $this->permission())) {
            return redirect()->to('/');
        }

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required',
                'singkat' => 'required',
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

            if (Satuan::where('delete', false)->where('nama', $request->input('nama'))->count()) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' => 'Nama Telah Ada'
                ];
            } else {
                $input = [
                    'nama' => $request->input('nama'),
                    'singkat' => $request->input('singkat'),
                    'delete' => false
                ];
                if (Satuan::create($input)) {
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

    public function SatuanEdit(Request $request)
    {
        if (!in_array('updateSatuan', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->input('id');
        $request->session()->put('IdEdit', $id);

        $this->data['SatuanData'] = Satuan::where('id', $id)->first();
        return view('Edit', $this->data);
    }

    public function SatuanEditTambah(Request $request)
    {

        if (!in_array('updateSatuan', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->session()->get('IdEdit');
        $Satuan = Satuan::where('id', $id)->first();
        if ($Satuan) {
            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'nama' => 'required',
                    'singkat' => 'required',
                ],
                $messages  = [
                    'required' => 'Form :attribute harus terisi',
                    'same' => 'Form :attribute & :other tidak sama.',
                ]
            );

            if ($Satuan['nama'] == $request->input('nama')) {
                $nama = $request->input('nama');
            } else {
                $str = Satuan::where('nama', $request->input('nama'))->count();
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
                        'singkat' => $request->input('singkat')
                    ];
                    if (Satuan::where('id', $id)->update($input)) {
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

    public function SatuanHapus(Request $request)
    {
        if (!in_array('deleteSatuan', $this->permission())) {
            return redirect()->to('/');
        }
        $id =  $request->input('id');
        if (Satuan::where('id', $id)->update(['delete' => true])) {
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

}
