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
        return view('Olahan', $this->data);
    }

    public function OlahanManage(Request $request)
    {
        $this->data['subtitle'] = 'Olahan';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Olahan::where('delete', false)->latest()->get();
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

    public function OlahanTambah(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required|unique:Olahan',
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

            if (Olahan::where('delete', false)->where('nama', $request->input('nama'))->count()) {
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
                if (Olahan::create($input)) {
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

    public function OlahanEdit(Request $request)
    {
        $id = $request->input('id');
        session()->flash('IdEdit', $id);

        $this->data['OlahanData'] = Olahan::where('id', $id)->first();
        return view('Edit', $this->data);
    }

    public function OlahanEditTambah(Request $request)
    {

        $id = session('IdEdit');
        $Olahan = Olahan::where('id', $id)->first();
        if ($Olahan) {
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
                    if (Olahan::where('id', $id)->update($input)) {
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
