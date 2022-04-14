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


class UsersController extends Controller
{

    public function __construct()
    {
        $this->data['title'] = 'Users';
        $this->data['subtitle'] = '';
        $this->title = $this->data['title'];
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }

    public function Index(Request $request)
    {
        if (Store::where('active', 1)->count() > 1) {
            $this->data['Store'] = Store::where('active', 1)->orderBy('nama')->get();
            $this->data['Group'] = Groups::orderBy('nama')->get();
            return view('Users', $this->data);
        } else {
            return redirect('/Store')->with('toast_error', 'Membuat Users Memerlukan Store Active!');
        }
    }

    public function Tambah(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'OutletUsers' => 'required',
                'Email' => 'required|email|unique:users',
                'Username' => 'required|min:6|unique:users',
                'PasswordUsers' => 'required|min:6',
                'PasswordRipet' => 'required|same:PasswordUsers',
                'NamaDepanUsers' => 'required',
                'NamaBelakangUsers' => 'required',
                'NoUsers' => 'required',
                'img' => 'mimes:jpeg,jpg,png',
                'izin' => 'required',

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

            if ($request->hasFile('img')) {
                $files = $request->file('img');
                $imageName = $request->input('Username') . '.' . $files->getClientOriginalExtension();
                $files->move(public_path('uploads/users'), $imageName);
                $urlimg = url('/') . '/uploads/users/' . $imageName;
            } else {
                $urlimg = '';
            }

            $StoreName = Store::where('id', $request->input('OutletUsers'))->first();
            $input = [
                'store' => $StoreName['nama'],
                'store_id' => $request->input('OutletUsers'),
                'username' => $request->input('Username'),
                'password' => bcrypt($request->input('PasswordUsers')),
                'email' => $request->input('Email'),
                'firstname' => $request->input('NamaDepanUsers'),
                'lastname' => $request->input('NamaBelakangUsers'),
                'phone' => $request->input('NoUsers'),
                'gender' => $request->input('gender'),
                'izin' => $request->input('izin'),
                'img' => $urlimg,
                'updated_at' => date('Y-m-d H:i:s'),
                'last_login' => date('Y-m-d H:i:s')
            ];
            if (user::create($input)) {
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


    public function Edit(Request $request)
    {
        $id = $request->input('id');
        session()->flash('IdEdit', $id);

        $this->data['UsersData'] = User::where('id', $id)->first();
        $this->data['Store'] = Store::all();
        return view('Edit', $this->data);
    }

    public function TambahEdit(Request $request)
    {
        $id = session('IdEdit');
        $pass = $request->input('PasswordUsersLama');

        $Users = User::where('id', $id)->first();
        if ($Users) {
            $cek = password_verify($pass, $Users['password']);
        } else {
            $cek = '';
        }
        if ($id && $Users && $cek) {

            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'OutletUsers' => 'required',
                    'Email' => 'required|email',
                    'Username' => 'required|min:6',
                    'PasswordUsersEdit' => 'required|min:6',
                    'PasswordRipetEdit' => 'required|same:PasswordUsersEdit',
                    'NamaDepanUsers' => 'required',
                    'NamaBelakangUsers' => 'required',
                    'NoUsers' => 'required',
                    'img' => 'mimes:jpeg,jpg,png'
                ],
                $messages  = [
                    'required' => 'Form :attribute harus terisi',
                    'same' => 'Form :attribute & :other tidak sama.',
                ]
            );

            if ($Users['username'] == $request->input('Username')) {
                $username = $request->input('Username');
            } else {
                $usr = User::where('username', $request->input('Username'))->count();
                if ($usr) {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Username Telah digunakan'
                    ];
                    $username = '';
                } else {
                    $username = $request->input('Username');
                }
            }


            if ($Users['email'] == $request->input('Email')) {
                $Email = $request->input('Email');
            } else {
                $eml = User::where('email', $request->input('Email'))->count();
                if ($eml) {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Email Telah digunakan'
                    ];
                    $Email = '';
                } else {
                    $Email = $request->input('Email');
                }
            }

            if ($username && $Email) {
                if ($validator->fails()) {
                    session()->flash('IdUsers', $id);
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
                        $imageName = $request->input('Username') . '.' . $files->getClientOriginalExtension();
                        $files->move(public_path('uploads/users'), $imageName);
                        $urlimg = url('/') . '/uploads/users/' . $imageName;
                    } else {
                        $urlimg = $Users['img'];
                    }

                    $StoreName = Store::where('id', $request->input('OutletUsers'))->first();
                    $input = [
                        'store' => $StoreName['nama'],
                        'store_id' => $request->input('OutletUsers'),
                        'username' => $request->input('Username'),
                        'password' => bcrypt($request->input('PasswordUsersEdit')),
                        'email' => $request->input('Email'),
                        'firstname' => $request->input('NamaDepanUsers'),
                        'lastname' => $request->input('NamaBelakangUsers'),
                        'phone' => $request->input('NoUsers'),
                        'gender' => $request->input('gender'),
                        'img' => $urlimg,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    if (user::where('id', $id)->update($input)) {
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
            session()->flash('IdUsers', $id);
            if ($cek or $Users) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' => 'Password Salah'
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Identitas tak ditemukan, Refresh Kembali'
                ];
            }
        }

        echo json_encode($data);
    }


    public function Hapus(Request $request)
    {
        $id =  $request->input('id');
        if (user::where('id', $id)->delete()) {
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
        $result = array('data' => array());
        $Data = User::latest()->get();
        foreach ($Data as $value) {
            if ($value['id'] != 1) {
                if ($value['img']) {
                    $img = '<img width="30" class="rounded-circle" src="' . $value['img'] . '">';
                } else {
                    $img = '<img width="30" class="rounded-circle" src="http://prs/assets/images/unnamed.png">';
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

                $result['data'][] = array(
                    $img,
                    $value['username'],
                    $value['store'],
                    $value['email'],
                    $value['firstname'],
                    $value['phone'],
                    $value['last_login'],
                    $button
                );
            }
        }
        echo json_encode($result);
    }
}
