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
    }

    public function index(Request $request)
    {

        $this->data['Store'] = Store::all();
        $this->data['Group'] = Groups::orderBy('group_name')->get();
        $this->data['DataUsers'] = User::orderBy('username')->get();
        return view('Users', $this->data);
    }

    public function tambah(Request $request)
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
                'img' => 'mimes:jpeg,jpg,png|required'
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
            } else {
                $imageName = '';
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
                'img' => url('/') . '/uploads/users/' . $imageName,
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
}
