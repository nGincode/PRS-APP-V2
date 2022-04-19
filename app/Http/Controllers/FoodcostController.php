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
use App\Models\Olahan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class FoodcostController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Foodcost';
        $this->data['subtitle'] = '';
        $this->title = $this->data['title'];
        if (Olahan::latest()->first()) {
            $this->kode = sprintf("%05s", Olahan::latest()->first()->id + 1);
        } else {
            $this->kode = sprintf("%05s", 1);
        }
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }


    /////////////////////////////////// SUPLIER //////////////////////////
    public function Olahan(Request $request)
    {
        $this->data['subtitle'] = 'Olahan';
        $this->data['kode'] = 'BO' . $this->kode;


        $id = session('IdOlahan');
        $this->data['Olahan'] = Olahan::where('id', $id)->first();
        return view('Olahan', $this->data);
    }

    public function OlahanManage(Request $request)
    {
        $this->data['subtitle'] = 'Olahan';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Olahan::where('delete', false)->with('Bahan')->latest()->get();
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



            $produksi = 0;
            foreach ($value->bahan as $v) {
            }

            $result['data'][] = array(
                $value['kode'],
                $value['nama'],
                $value['satuan_pengeluaran'],
                json_encode($value->bahan),
                $button
            );
        }
        echo json_encode($result);
    }

    public function OlahanTambah(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required',
                'satuan_pengeluaran' => 'required',
                'satuan_penyajian' => 'required',
                'konversi_penyajian' => 'required'
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

            $id = session('IdOlahan');
            $Olahan = Olahan::where('id', $id)->first();
            if ($Olahan) {
                if ($Olahan['nama'] == $request->input('nama')) {
                    $nama = $request->input('nama');
                } else {
                    $str = Olahan::where('nama', $request->input('nama'))->count();
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
            } else {
                if (Olahan::where('delete', false)->where('nama', $request->input('nama'))->count()) {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' => 'Nama Telah Ada'
                    ];
                    $nama = '';
                } else {
                    $nama = $request->input('nama');
                }
            }

            if ($nama && $Olahan) {
                $input = [
                    'nama' => $nama,
                    'satuan_pengeluaran' => $request->input('satuan_pengeluaran'),
                    'satuan_penyajian' => $request->input('satuan_penyajian'),
                    'kode' => 1,
                    'konversi_penyajian' => $this->unrupiah($request->input('konversi_penyajian')),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if (Olahan::where('id', $id)->update($input)) {
                    $data = [
                        'toast' => true,
                        'status' => 'success',
                        'pesan' => 'Autosave Berhasil',
                        'id' => $id
                    ];
                } else {

                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Terjadi kegagalan system'
                    ];
                };
            } else if ($nama) {
                $input = [
                    'nama' => $nama,
                    'satuan_pengeluaran' => $request->input('satuan_pengeluaran'),
                    'satuan_penyajian' => $request->input('satuan_penyajian'),
                    'konversi_penyajian' => $this->unrupiah($request->input('konversi_penyajian')),
                    'kode' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if ($olahan = Olahan::create($input)) {
                    request()->session()->put('IdOlahan', $olahan->id);
                    $data = [
                        'id' => $olahan->id,
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
            };
        }


        echo json_encode($data);
    }

    public function OlahanEdit(Request $request)
    {
        $id = $request->input('id');

        $this->data['OlahanData'] = Bahan::all();
        if ($id) {
            session()->flash('IdEdit', $id);
            $data = Bahan_Olahan::where('olahan_id', $id)->with('Bahan')->get();
            $cekid = array();
            foreach ($data as $v) {
                $cekid[] = $v->bahan['id'];
            }
            $this->data['cekid'] = $cekid;
        } else {
            $this->data['cekid'] = null;
        }
        return view('Edit', $this->data);
    }

    public function OlahanItemManage(Request $request)
    {
        $this->data['subtitle'] = 'Olahan';
        $this->subtitle = $this->data['subtitle'];


        $id = session('IdOlahan');
        if ($id) {
            $Data = Bahan_Olahan::where('olahan_id', $id)->with('Bahan', 'Olahan')->latest()->get();
        } else {
            $Data = array();
        }

        $result = array('data' => array());
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



            $produksi = 0;
            foreach ($value->bahan as $v) {
            }

            $result['data'][] = array(
                $value->bahan['nama'],
                $value->olahan['nama'],
                $value->olahan['nama'],
                $value->olahan['nama'],
                $value->olahan['nama'],
                $button
            );
        }
        echo json_encode($result);
    }

    public function ItemTambahEdit(Request $request)
    {


        $id = $request->input('id');

        $input = array();
        foreach ($id as $v) {
            $input[] = array(
                'olahan_id' => session('IdEdit'),
                'bahan_id' => $v,
                'pemakaian' => 0
            );
        }

        if (Bahan_Olahan::insert($input)) {
            $data = [
                'toast' => true,
                'status' => 'success',
                'pesan' => 'Berhasil'
            ];
        } else {
            $data = [
                'toast' => true,
                'status' => 'errror',
                'pesan' => 'Gagal'
            ];
        }

        echo json_encode($data);
    }

    public function OlahanHapus(Request $request)
    {
        $id =  $request->input('id');
        if (Olahan::where('id', $id)->update(['delete' => true])) {
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
