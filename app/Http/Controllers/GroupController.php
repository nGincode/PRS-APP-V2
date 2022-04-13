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
use App\Models\GroupsUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class GroupController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Group';
        $this->title = $this->data['title'];
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }

    public function Index(Request $request)
    {
        if (User::count() > 1) {
            $this->data['Users'] = User::all();
            return view('Group', $this->data);
        } else {
            return redirect('/Users')->with('toast_error', 'Membuat Group Memerlukan Users!');
        }
    }


    public function Manage(Request $request)
    {
        $result = array('data' => array());
        $GroupsUsers = GroupsUsers::with(['Users', 'Groups'])->latest()->get();

        $id = array();
        $usr = array();
        $nama = array();
        $permission = array();
        foreach ($GroupsUsers as $v) {
            if (isset($v->groups->id)) {
                if ($v->groups->id != 1) {
                    $usr[] = array(
                        str_replace(" ", "_", $v->groups->nama)  => $v->users->username
                    );
                    $nama[] = $v->groups->nama;
                    $permission[] = $v->groups->permission;
                    $id[] = $v->groups->id;
                }
            } else {
                $usr[] = array();
                $nama[] = 'Tak Ditemukan (Hapus)';
                $id[] = $v['id'];
                $permission[] = '';
            }
        }
        $nama = array_unique($nama);

        foreach ($nama as $key => $v1) {

            $username = '';
            foreach ($usr as $v2) {
                if (isset($v2[str_replace(" ", "_", $v1)])) {
                    $username .= $v2[str_replace(" ", "_", $v1)] . '<br>';
                }
            }


            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('updateUser', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Edit(" . $id[$key] . "," . '"' . $this->title . '"' . ")' data-toggle='modal' data-target='#Modal' href='#'><i class='fas fa-pencil-alt'></i> Edit</a></li>";
            }
            if (in_array('deleteUser', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $id[$key] . "," . '"' . $this->title . '"' . ")'  href='#'><i class='fas fa-trash-alt'></i> Hapus</a></li>";
            }
            $button .= '</ul></div>';

            $izin = '';
            if ($permission[$key]) {
                $judul = array_unique(str_replace(['create', 'update', 'view', 'delete'], '', unserialize($permission[$key])));
                $user_permission = unserialize($permission[$key]);
                foreach ($judul as $v) {
                    $izin .= ' ' . $v . ' ( ';
                    if (in_array('view' . $v, $user_permission)) {
                        $izin .= '<i class="fa fa-eye"></i> ';
                    }
                    if (in_array('create' . $v, $user_permission)) {
                        $izin .= '<i class="fa fa-plus"></i> ';
                    }
                    if (in_array('update' . $v, $user_permission)) {
                        $izin .= '<i class="fa fa-pen"></i> ';
                    }
                    if (in_array('delete' . $v, $user_permission)) {
                        $izin .= '<i class="fa fa-trash"></i>';
                    }
                    $izin .= ' )<br>';
                }
            }

            $result['data'][$key] = array(
                $v1,
                $izin,
                $username,
                $button
            );
        }

        echo json_encode($result);
    }


    public function Tambah(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'permission' => 'required',
                'users' => 'required',
                'nama' => 'required|unique:groups'
            ],
            $messages  = [
                'required' => 'Form :attribute harus terisi',
                'same' => 'Form :attribute & :other tidak sama.',
            ]
        );

        $permission = serialize($request->input('permission'));
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
                'permission' => $permission,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            if (Groups::create($input)) {
                $grp = Groups::orderBy('id', 'desc')->first();
                if ($grp) {
                    foreach ($request->input('users') as $v) {
                        GroupsUsers::create([
                            'groups_id' => $grp['id'],
                            'users_id' => $v,
                        ]);
                    }
                }

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


    public function Hapus(Request $request)
    {
        $id =  $request->input('id');
        if (Groups::where('id', $id)->delete() && GroupsUsers::where('groups_id', $id)->delete()) {
            $data = [
                'toast' => true,
                'status' => 'success',
                'pesan' => 'Berhasil Terhapus'
            ];
        } else {
            if (GroupsUsers::where('id', $id)->delete()) {
                $data = [
                    'toast' => true,
                    'status' => 'success',
                    'pesan' => 'Eror Berhasil Terhapus'
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Terjadi kegagalan system'
                ];
            }
        };

        echo json_encode($data);
    }


    public function Edit(Request $request)
    {
        $id = $request->input('id');
        session()->flash('IdEdit', $id);

        $GroupsData = Groups::where('id', $id)->first();
        $Users = User::all();
        $this->data['GroupsUsers'] = GroupsUsers::where('groups_id', $GroupsData['id'])->get();
        $this->data['Users'] = $Users;
        $this->data['GroupsData'] = $GroupsData;
        $this->data['permission'] = unserialize($GroupsData['permission']);
        return view('Edit', $this->data);
    }


    public function TambahEdit(Request $request)
    {
        $id = session('IdEdit');
        $Groups = Groups::where('id', $id)->first();
        if ($Groups) {

            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'permission' => 'required',
                    'usersedit' => 'required',
                    'nama' => 'required'
                ],
                $messages  = [
                    'required' => 'Form :attribute harus terisi',
                    'same' => 'Form :attribute & :other tidak sama.',
                ]
            );

            if ($Groups['nama'] == $request->input('nama')) {
                $name = $request->input('nama');
            } else {
                $str = Groups::where('nama', $request->input('nama'))->count();
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
                    session()->flash('IdEdit', $id);
                    foreach ($validator->errors()->all() as $message) {
                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  $message
                        ];
                    }
                } else {

                    $permission = serialize($request->input('permission'));
                    $input = [
                        'nama' => $request->input('nama'),
                        'permission' => $permission,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    if (Groups::where('id', $id)->update($input)) {
                        if ($request->input('usersedit')) {
                            foreach ($request->input('usersedit') as $v) {
                                if (GroupsUsers::where('groups_id', $id)->delete()) {
                                    GroupsUsers::create([
                                        'groups_id' => $id,
                                        'users_id' => $v,
                                    ]);
                                }
                            }
                        }

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
                'pesan' =>  'Gagal mengambil data, Refresh Kembali'
            ];
        }

        echo json_encode($data);
    }
}
