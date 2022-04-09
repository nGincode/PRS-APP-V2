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


class StoreController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Store';
    }

    public function Index(Request $request)
    {
        $this->data['Store'] = Store::all();
        $this->data['Group'] = Groups::orderBy('group_name')->get();
        $this->data['DataUsers'] = User::orderBy('username')->get();
        return view('Stores', $this->data);
    }

    public function Tambah(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'GroupsUsers' => 'required',
                'OutletUsers' => 'required',
                'Email' => 'required|email|unique:users',
                'Username' => 'required|min:6|unique:users',
                'PasswordUsers' => 'required|min:6',
                'PasswordRipet' => 'required|same:PasswordUsers',
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
                'store' => $StoreName['name'],
                'store_id' => $request->input('OutletUsers'),
                'username' => $request->input('Username'),
                'password' => bcrypt($request->input('PasswordUsers')),
                'email' => $request->input('Email'),
                'firstname' => $request->input('NamaDepanUsers'),
                'lastname' => $request->input('NamaBelakangUsers'),
                'phone' => $request->input('NoUsers'),
                'gender' => $request->input('gender'),
                'group_id' => $request->input('GroupsUsers'),
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
        session()->flash('IdUsers', $id);

        $this->data['UsersData'] = User::where('id', $id)->first();
        $this->data['Store'] = Store::all();
        $this->data['Group'] = Groups::orderBy('group_name')->get();
        return view('Edit', $this->data);
    }

    public function TambahEdit(Request $request)
    {
        $id = session('IdUsers');
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
                    'GroupsUsers' => 'required',
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

            if ($Users['username'] === $request->input('Username')) {
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
                        $urlimg = '';
                    }

                    $StoreName = Store::where('id', $request->input('OutletUsers'))->first();
                    $input = [
                        'store' => $StoreName['name'],
                        'store_id' => $request->input('OutletUsers'),
                        'username' => $request->input('Username'),
                        'password' => bcrypt($request->input('PasswordUsersEdit')),
                        'email' => $request->input('Email'),
                        'firstname' => $request->input('NamaDepanUsers'),
                        'lastname' => $request->input('NamaBelakangUsers'),
                        'phone' => $request->input('NoUsers'),
                        'gender' => $request->input('gender'),
                        'group_id' => $request->input('GroupsUsers'),
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
}
