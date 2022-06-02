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
        $this->data['Data'] = Belanja::where('tgl', date('Y-m-d'))->where('delete', false)->where('store_id', $request->session()->get('store_id'))->orderBy('nama', 'ASC')->get();
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
            $cek = true;
            foreach ($request->input('qty') as $cek) {
                if (!$cek) {
                    $cek = false;
                }
            }
            if ($cek) {
                Belanja::where('tgl', date('Y-m-d'))->where('store_id', $request->session()->get('store_id'))->delete();

                foreach ($request->input('nama') as $key => $nama) {
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

                        if (Belanja::insert($input)) {
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
                        $bahan = Bahan::where('id', $nama)->first();
                        $qty = $request->input('qty')[$key] ?? 0;
                        $harga =  $request->input('harga')[$key] ?? 0;
                        $konversi = $request->input('konversi')[$key] ?? 1;
                        $total = ($qty * $harga) * $konversi;

                        $jml = Belanja::where('bahan_id', $nama)->where('tgl', date('Y-m-d'))->where('store_id', $request->session()->get('store_id'))->count();
                        if (!$jml) {
                            $input = [
                                'nama' => $bahan['nama'],
                                'bahan_id' => $bahan['id'],
                                'item_qty' => $qty * $konversi,
                                'item_harga' => $bahan['harga'],
                                'item_uom' => $bahan['satuan_pembelian'],
                                'tgl' => date('Y-m-d'),
                                'kategori' => 'Item',
                                'total' => $total,
                                'store_id' => $request->session()->get('store_id'),
                                'qty' => $request->input('qty')[$key],
                                'harga' => $request->input('harga')[$key] ?? null,
                                'ket' => $request->input('ket')[$key] ?? null,
                                'uom' => $request->input('uombelanja')[$key] ?? null,
                                'konversi' => $request->input('konversi')[$key] ?? null,
                                'hutang' => $request->input('hutang')[$key] ?? 0,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'created_at' => date('Y-m-d H:i:s')
                            ];
                            if (Belanja::insert($input)) {
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
                            $data = [
                                'toast' => true,
                                'status' => 'error',
                                'pesan' =>  '<b>' . $bahan['nama'] . '</b> Telah ada, Silahkan cek kembali'
                            ];
                        }
                    }
                }
            } else {

                $data = [
                    'toast' => true,
                    'status' => 'success',
                    'pesan' =>  'Isi Qty Untuk Autosave'
                ];
            }
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

    public function Masterbahan(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            $bhn = Bahan::where('id', $id)->first();
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
        // $tgl = Belanja::select('tgl')->where('delete', false)->get();
        // $Data = array_unique($tgl);

        // foreach ($Data as $value) {
        //     $result['data'][] = array(
        //         $value['tgl'],
        //         $value['tgl'],
        //         $qty
        //     );
        // }
        echo json_encode($result);
    }
}
