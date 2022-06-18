<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\Inventaris;
use App\Models\Pengadaan;
use App\Models\Bahan;
use App\Models\Peralatan;
use App\Models\Satuan;
use App\Models\Belanja;
use App\Models\Inventory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class BelanjaController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Belanja';
        $this->data['subtitle'] = '';
    }

    public function index(Request $request)
    {
        $this->data['Belanja'] = Inventory::with('Bahan')->first();

        $bhn = Inventory::where('store_id', $request->session()->get('store_id'))->where('delete', false)->with('Bahan')->get();
        $bahan = [];
        foreach ($bhn as $key => $value) {
            $bahan[] = array(
                'id' => $value['id'],
                'nama' => $value['bahan']->nama
            );
        }

        $this->data['satuan'] = Satuan::all();
        $this->data['bahan'] = $bahan;
        $this->data['Data'] = Belanja::where('tgl', date('Y-m-d'))->where('delete', false)->where('store_id', $request->session()->get('store_id'))->orderBy('up', 'DESC')->orderBy('nama', 'ASC')->get();
        return view('Belanja', $this->data);
    }

    public function Input(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required'
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
            foreach ($request->input('nama') as $key => $nama) {
                if ($request->input('qty')[$key]) {
                    if ($nama == 'Supplay' or $nama == 'Oprasional') {
                        $input = [
                            'nama' => $nama,
                            'tgl' => date('Y-m-d'),
                            'kategori' => $nama,
                            'store_id' => $request->session()->get('store_id'),
                            'qty' => $request->input('qty')[$key],
                            'harga' => $request->input('harga')[$key] ?? null,
                            'ket' => $request->input('ket')[$key] ?? null,
                            'total' => $request->input('qty')[$key] * $request->input('harga')[$key] ?? 0,
                            'uom' => $request->input('uombelanja')[$key] ?? null,
                            'konversi' => $request->input('konversi')[$key] ?? null,
                            'hutang' => $request->input('hutang')[$key] ?? 0,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $id = $request->input('id')[$key] ?? 0;
                        if ($id) {
                            if (Belanja::where('id', $id)->update($input)) {
                                $data = [
                                    'toast' => true,
                                    'status' => 'success',
                                    'pesan' => 'Autosave Berhasil'
                                ];
                            } else {
                                $data = [
                                    'toast' => true,
                                    'status' => 'error',
                                    'pesan' =>  'Terjadi kegagalan system' . $id
                                ];
                            };
                        } else {
                            if (Belanja::insert($input)) {
                                $idbelanja = Belanja::select('id')->latest()->first();
                                $data = [
                                    'toast' => true,
                                    'status' => 'success',
                                    'pesan' => 'Autosave Berhasil',
                                    'id' => $idbelanja['id'],
                                    'row' => $request->input('key')[$key]
                                ];
                            } else {

                                $data = [
                                    'toast' => true,
                                    'status' => 'error',
                                    'pesan' =>  'Terjadi kegagalan system'
                                ];
                            };
                        }
                    } else {
                        $bahan = Bahan::where('id', $nama)->first();
                        $harga =  $request->input('harga')[$key] ?? 0;
                        $konversi = $request->input('konversi')[$key] ?? 1;
                        $total = $harga * $konversi;
                        $id = $request->input('id')[$key] ?? 0;

                        $jml = Belanja::where('bahan_id', $nama)->where('tgl', date('Y-m-d'))->where('store_id', $request->session()->get('store_id'))->count();
                        if (!$jml or $id) {
                            $input = [
                                'nama' => $bahan['nama'],
                                'bahan_id' => $bahan['id'],
                                'item_uom' => $bahan['satuan_pembelian'],
                                'tgl' => date('Y-m-d'),
                                'kategori' => 'Item',
                                'total' => $total,
                                'store_id' => $request->session()->get('store_id'),
                                'qty' => $request->input('qty')[$key] ?? null,
                                'harga' => $request->input('harga')[$key] ?? null,
                                'ket' => $request->input('ket')[$key] ?? null,
                                'uom' => $request->input('uombelanja')[$key] ?? null,
                                'konversi' => $request->input('konversi')[$key] ?? null,
                                'hutang' => $request->input('hutang')[$key] ?? 0,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'created_at' => date('Y-m-d H:i:s')
                            ];

                            if ($id) {
                                if (Belanja::where('id', $id)->update($input)) {
                                    $data = [
                                        'toast' => true,
                                        'status' => 'success',
                                        'pesan' => 'Autosave Berhasil'
                                    ];
                                } else {

                                    $data = [
                                        'toast' => true,
                                        'status' => 'error',
                                        'pesan' =>  'Terjadi kegagalan system'
                                    ];
                                };
                            } else {
                                if (Belanja::insert($input)) {
                                    $idbelanja = Belanja::select('id')->latest()->first();
                                    $data = [
                                        'toast' => true,
                                        'status' => 'success',
                                        'pesan' => 'Autosave Berhasil',
                                        'id' => $idbelanja['id'],
                                        'row' => $request->input('key')[$key]
                                    ];
                                } else {

                                    $data = [
                                        'toast' => true,
                                        'status' => 'error',
                                        'pesan' =>  'Terjadi kegagalan system'
                                    ];
                                };
                            }
                        } else {
                            $data = [
                                'toast' => true,
                                'status' => 'error',
                                'pesan' =>  '<b>' . $bahan['nama'] . '</b> Telah ada, Silahkan cek kembali'
                            ];
                        }
                    }
                } else {
                    $data = false;
                }
            }
        }



        echo json_encode($data);
    }

    public function Upload(Request $request)
    {
        $belanja = Belanja::where('up', false)->where('store_id', $request->session()->get('store_id'))->where('tgl', date('Y-m-d'))->get();
        if ($belanja) {
            $cek = true;
            $item = '';
            foreach ($belanja as $key => $value) {
                if ($value['qty'] && $value['uom'] && $value['harga']) {
                    if (Belanja::where('id', $value['id'])->update(['up' => true])) {
                        if ($value['bahan_id']) {
                            if ($value['konversi']) {
                                $bhn = Inventory::where('bahan_id', $value['bahan_id'])->first();
                                if ($bhn) {
                                    $jumlah = $value['konversi'] + $bhn['qty'];
                                    if (!Inventory::where('bahan_id', $value['bahan_id'])->update(['qty' => $jumlah])) {
                                        Belanja::where('id', $value['id'])->update(['up' => false]);
                                        $cek = false;
                                        $item .= $value['nama'] . '- Inventory Gagal Menambah <br>';
                                    };
                                } else {
                                    Belanja::where('id', $value['id'])->update(['up' => false]);
                                    $cek = false;
                                    $item .= $value['nama'] . '- Inventory Kosong <br>';
                                }
                            } else {
                                Belanja::where('id', $value['id'])->update(['up' => false]);
                                $cek = false;
                                $item .= $value['nama'] . '- Qty UOM Kosong <br>';
                            }
                        }
                    } else {
                        $cek = false;
                        $item .= $value['nama'] . '- Gagal Upload <br>';
                    }
                } else {
                    $cek = false;
                    $item .= $value['nama'] . '- Tidak Lengkap <br>';
                }
            }
            if ($cek) {
                $data = [
                    'toast' => true,
                    'status' => 'success',
                    'pesan' =>  'Belanja Berhasil Diupload Dengan Aman'
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  $item
                ];
            }
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Belanja tidak ditemukan'
            ];
        }

        echo json_encode($data);
    }

    public function Namabarang(Request $request)
    {
        $bhn = Inventory::where('store_id', $request->session()->get('store_id'))->where('delete', false)->with('Bahan')->get();
        $bahan = [];
        foreach ($bhn as $key => $value) {
            $bahan[] = array(
                'id' => $value['id'],
                'nama' => $value['bahan']->nama
            );
        }

        $satuan = Satuan::all();
        echo json_encode(array('satuan' => $satuan, 'bahan' => $bahan));
    }

    public function Inventorybahanid(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            $bhn = Inventory::where('id', $id)->first();
            echo json_encode($bhn);
        }
    }


    public function HapusItem(Request $request)
    {
        $id =  $request->input('id');
        if (Belanja::where('id', $id)->delete()) {
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


    public function Manage(Request $request)
    {
        $this->data['subtitle'] = 'Belanja';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $tgl = [];
        foreach (Belanja::select('tgl')->where('delete', false)->get()->toArray() as $v) {
            $tgl[] = $v['tgl'];
        }
        $tgl = array_unique($tgl);


        foreach ($tgl as $value) {
            $total =  Belanja::where('tgl', $value)->where('delete', false)->sum('total');
            if (Belanja::where('up', false)->where('delete', false)->count()) {
                $up = '<a class="badge badge-danger">Proses</a>';
            } else {
                $up = '<a class="badge badge-success">Success</a>';
            }

            $result['data'][] = array(
                $value,
                $this->rupiah($total),
                $up
            );
        }
        echo json_encode($result);
    }
}
