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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class StoreController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Store';
        $this->data['subtitle'] = '';
        $this->title = $this->data['title'];
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }

    public function Index(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewStore', $this->permission())) {
            return redirect()->to('/');
        }
        return view('Stores', $this->data);
    }


    public function Tambah(Request $request)
    {
        if (!in_array('createStore', $this->permission())) {
            return redirect()->to('/');
        }
        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required|unique:store',
                'status' => 'required',
                'tipe' => 'required',
                'alamat' => 'required',
                'wa' => 'required',
                'nama_shift' => 'required',
                'masuk_kerja' => 'required',
                'pulang_kerja' => 'required',
                'img' => 'mimes:jpeg,jpg,png'
            ],
            $messages  = [
                'required' => 'Form :attribute harus terisi',
                'same' => 'Form :attribute & :other tidak sama.',
            ]
        );

        $hitung_shift = count($request->input('nama_shift'));
        $input_shift = array();
        $cekvalueinput = 0;
        if ($hitung_shift > 1) {
            for ($x = 0; $x < $hitung_shift; $x++) {
                if ($request->input('nama_shift')[$x] == '' or $request->input('masuk_kerja')[$x] == '' or $request->input('pulang_kerja')[$x] == '') {
                    $cekvalueinput += 1;
                }
                $input_shift[] = array(
                    'No' => $x,
                    'Nama' => $request->input('nama_shift')[$x],
                    'Masuk' => $request->input('masuk_kerja')[$x],
                    'Pulang' => $request->input('pulang_kerja')[$x]
                );
            }
        } else {
            if ($request->input('nama_shift')[0] == '' or $request->input('masuk_kerja')[0] == '' or $request->input('pulang_kerja')[0] == '') {
                $cekvalueinput += 1;
            }
            $input_shift[] = array(
                'No' => 0,
                'Nama' => $request->input('nama_shift')[0],
                'Masuk' => $request->input('masuk_kerja')[0],
                'Pulang' => $request->input('pulang_kerja')[0]
            );
        }
        $Jam_kerja = json_encode($input_shift);

        if ($cekvalueinput == 0) {
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
                    $imageName = date('YmdHis') . '.' . $files->getClientOriginalExtension();
                    $files->move(public_path('uploads/stores'), $imageName);
                    $urlimg = url('/') . '/uploads/stores/' . $imageName;
                } else {
                    $urlimg = '';
                }

                $input = [
                    'nama' => $request->input('nama'),
                    'active' => $request->input('status'),
                    'tipe' => $request->input('tipe'),
                    'alamat' => $request->input('alamat'),
                    'wa' => $request->input('wa'),
                    'jam_kerja' => $Jam_kerja,
                    'img' => $urlimg
                ];
                if (store::create($input)) {
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
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Form Shift Ada Yang Kosong'
            ];
        }


        echo json_encode($data);
    }


    public function Edit(Request $request)
    {
        if (!in_array('updateStore', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->input('id');
        $request->session()->put('IdEdit', $id);

        $this->data['StoreData'] = Store::where('id', $id)->first();
        return view('Edit', $this->data);
    }

    public function TambahEdit(Request $request)
    {

        if (!in_array('updateStore', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->session()->get('IdEdit');
        $Store = Store::where('id', $id)->first();
        if ($Store) {

            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'nama' => 'required',
                    'status' => 'required',
                    'tipe' => 'required',
                    'alamat' => 'required',
                    'wa' => 'required',
                    'nama_shift' => 'required',
                    'masuk_kerja' => 'required',
                    'pulang_kerja' => 'required',
                    'img' => 'mimes:jpeg,jpg,png'
                ],
                $messages  = [
                    'required' => 'Form :attribute harus terisi',
                    'same' => 'Form :attribute & :other tidak sama.',
                ]
            );

            if ($Store['nama'] == $request->input('nama')) {
                $name = $request->input('nama');
            } else {
                $str = Store::where('nama', $request->input('nama'))->count();
                if ($str) {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Nama Telah digunakan'
                    ];
                    $name = '';
                } else {
                    $name = $request->input('nama');
                }
            }

            if ($name) {
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
                        $imageName = date('YmdHis')  . '.' . $files->getClientOriginalExtension();
                        $files->move(public_path('uploads/stores'), $imageName);
                        $urlimg = url('/') . '/uploads/stores/' . $imageName;
                    } else {
                        $urlimg = $Store['img'];
                    }

                    $hitung_shift = count($request->input('nama_shift'));
                    $input_shift = array();
                    $cekvalueinput = 0;
                    if ($hitung_shift > 1) {
                        for ($x = 0; $x < $hitung_shift; $x++) {
                            if ($request->input('nama_shift')[$x] == '' or $request->input('masuk_kerja')[$x] == '' or $request->input('pulang_kerja')[$x] == '') {
                                $cekvalueinput += 1;
                            }
                            $input_shift[] = array(
                                'No' => $x,
                                'Nama' => $request->input('nama_shift')[$x],
                                'Masuk' => $request->input('masuk_kerja')[$x],
                                'Pulang' => $request->input('pulang_kerja')[$x]
                            );
                        }
                    } else {
                        if ($request->input('nama_shift')[0] == '' or $request->input('masuk_kerja')[0] == '' or $request->input('pulang_kerja')[0] == '') {
                            $cekvalueinput += 1;
                        }
                        $input_shift[] = array(
                            'No' => 0,
                            'Nama' => $request->input('nama_shift')[0],
                            'Masuk' => $request->input('masuk_kerja')[0],
                            'Pulang' => $request->input('pulang_kerja')[0]
                        );
                    }
                    $Jam_kerja = json_encode($input_shift);

                    if ($cekvalueinput == 0) {
                        $input = [
                            'nama' => $request->input('nama'),
                            'active' => $request->input('status'),
                            'tipe' => $request->input('tipe'),
                            'alamat' => $request->input('alamat'),
                            'wa' => $request->input('wa'),
                            'jam_kerja' => $Jam_kerja,
                            'img' => $urlimg
                        ];
                        if (store::where('id', $id)->update($input)) {
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
                    } else {
                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  'Form Shift Ada Yang Kosong'
                        ];
                    }
                }
            }
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Gagal mengambil data, Refresh Kembali'
            ];
        }

        echo json_encode($data);
    }


    public function Hapus(Request $request)
    {
        if (!in_array('deleteStore', $this->permission())) {
            return redirect()->to('/');
        }
        $id =  $request->input('id');
        if (Store::where('id', $id)->delete()) {
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
        if (!in_array('viewStore', $this->permission())) {
            return redirect()->to('/');
        }
        $result = array('data' => array());
        $Data = Store::latest()->get();
        foreach ($Data as $value) {
            if ($value['id'] != 1) {
                if ($value['img']) {
                    $img = '<img width="30" class="rounded-circle" src="' . $value['img'] . '">';
                } else {
                    $img = '<img width="30" class="rounded-circle" src="' . url('/assets/images/unnamed.png') . '">';
                }

                $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

                if (in_array('updateUser', $this->permission())) {
                    $button .= "<li><a class='dropdown-item' onclick='Edit(" . $value['id'] . "," . '"' . $this->title . '"' . ")' data-toggle='modal' data-target='#Modal' href='#'><i class='fas fa-pencil-alt'></i> Edit</a></li>";
                }
                if (in_array('deleteUser', $this->permission())) {
                    $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->title . '"' . ")'  href='#'><i class='fas fa-trash-alt'></i> Hapus</a></li>";
                }

                $button .= '</ul></div>';

                if ($value['active'] == 1) {
                    $active = '<span class="badge badge-success">Active</span>';
                } else {
                    $active = '<span class="badge badge-secondary">Not Active</span>';
                }


                if ($value['jam_kerja']) {
                    $jam_kerja = json_decode($value['jam_kerja'], true);

                    $jam = '';
                    foreach ($jam_kerja as $v) {
                        $jam .= $v['Nama'] . ' (' . $v['Masuk'] . ' - ' . $v['Pulang'] . ')<br>';
                    }
                } else {
                    $jam = null;
                }

                $result['data'][] = array(
                    $img,
                    $value['nama'],
                    $active,
                    '<span class="badge badge-light">' . $value['tipe'] . '</span>',
                    Str::limit($value['alamat'], 20),
                    $value['wa'],
                    $jam,
                    $button
                );
            }
        }
        echo json_encode($result);
    }
}
