<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Store;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;



class AuthController extends Controller
{

    public function Login()
    {
        return view('Login');
    }

    public function Authenticate(Request $request)
    {
        $username = $request->input('username');
        $remember_me = $request->input('remember_me');
        $credentials = $request->only('username', 'password');

        $data = User::where('username', $username)->first();
        if ($data) {
            $DataStore = Store::where('id', $data['store_id'])->first();
            if ($DataStore) {
                $tipe = $DataStore['tipe'];
            } else {
                $tipe = 0;
            }
            $ses_data = [
                'id' => $data['id'],
                'username'  => $data['username'],
                'email'     => $data['email'],
                'store'     => $data['store'],
                'store_id'     => $data['store_id'],
                'group_id' => $data['group_id'],
                'logo' => $data['logo'],
                'tipe' => $tipe,
                'logged_in' => TRUE
            ];

            if (Auth::attempt($credentials, $remember_me)) {


                $request->session()->put($ses_data);

                User::where('id', $data['id'])->update(['last_login' => date('Y-m-d H:i:s')]);
                return redirect()->intended('/');
            } else {
                $this->data['err'] = 'Email  & Password Belum Terdaftar';
                return view('Login', $this->data);
            }
        } else {
            $this->data['err'] = 'Email  & Password Belum Terdaftar';
            return view('Login', $this->data);
        }
    }


    public function Logout()
    {
        Auth::logout();

        return redirect()->intended('/login');
    }
}
