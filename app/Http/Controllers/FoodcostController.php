<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Bahan_Olahan;
use App\Models\Bahan_Resep;
use App\Models\Resep;
use App\Models\Resep_Olahan;
use App\Models\User;
use App\Models\Store;
use App\Models\Ivn;
use App\Models\Pengadaan;
use App\Models\LogistikProduk;
use App\Models\LogistikBelanja;
use App\Models\LogistikOrder;
use App\Models\Groups;
use App\Models\Olahan;
use App\Models\Satuan;

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
        if ($kode = Olahan::latest()->first()) {
            $this->kode = sprintf("%05s", $kode->id + 1);
        } else {
            $this->kode = sprintf("%05s", 1);
        }

        if ($koderesep = Resep::latest()->first()) {
            $this->kodeResep = sprintf("%05s", $koderesep->id + 1);
        } else {
            $this->kodeResep = sprintf("%05s", 1);
        }
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }


    /////////////////////////////////// OLAHAN //////////////////////////
    public function Olahan(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Olahan';
        $this->data['kode'] = 'BO' . $this->kode;
        $this->data['satuan'] = Satuan::all();


        $id = $request->session()->get('IdOlahan');
        $this->data['Olahan'] = Olahan::where('id', $id)->with('Bahan')->first();

        $jumlahbb = 0;
        $jumlahb0 = 0;
        $Data = Bahan_Olahan::where('olahan_id', $id)->with('Bahan', 'Olahan')->get();
        if ($Data) {
            foreach ($Data as $value) {
                if ($value->bahan) {
                    $jumlahbb += ($value->bahan['harga'] / $value->bahan['konversi_pemakaian']) * $value['pemakaian'];
                }

                if ($value['bahanolahan_id']) {
                    $bahanolahan = Olahan::where('id', $value['bahanolahan_id'])->first();
                    if ($bahanolahan) {
                        $jumlahb0 += ($bahanolahan['produksi'] / $bahanolahan['hasil']) * $value['pemakaian'];
                    }
                }
            }
        }
        $this->data['Jmlbb'] = $this->rupiah($jumlahbb);
        $this->data['Jmlbo'] = $this->rupiah($jumlahb0);
        $this->data['totaljml'] = $this->rupiah($jumlahb0 + $jumlahbb);
        return view('Olahan', $this->data);
    }

    public function OlahanManage(Request $request)
    {

        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Olahan';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Olahan::where('delete', false)->with('Bahan')->latest()->get();
        foreach ($Data as $value) {

            $id = $request->session()->get('IdOlahan');
            if ($id != $value['id']) {
                $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

                if (in_array('updateFoodcostBahanOlahan', $this->permission())) {
                    $button .= "<li><a class='dropdown-item' href='Olahan/SessionCreate?id=" . $value['id'] . "'><i class='fas fa-pencil-alt'></i> Edit</a></li>";
                }
                if (in_array('deleteFoodcostBahanOlahan', $this->permission())) {
                    $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")'  ><i class='fas fa-trash-alt'></i> Hapus</a></li>";
                }
                $button .= '</ul></div>';


                if ($value['draft']) {
                    $draft = 'Draft';
                } else {
                    $draft = '';
                }

                $result['data'][] = array(
                    $value['kode'],
                    $value['nama']  . ' <span class="badge badge-info">' . $draft . '</span>',
                    $this->rupiah($value['produksi']),
                    $this->unrupiah($value['hasil']) . ' ' . $value['satuan_penyajian'],
                    $button
                );
            }
        }
        echo json_encode($result);
    }

    public function OlahanTambah(Request $request)
    {


        $this->data['user_permission'] = $this->permission();
        if (!in_array('createFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }

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

            $id = $request->session()->get('IdOlahan');

            $jumlah = 0;
            $bahanolahan = Bahan_Olahan::where('olahan_id', $id)->with('Bahan', 'Olahan')->get();
            if ($bahanolahan) {
                foreach ($bahanolahan as $v) {
                    if ($v['bahan']) {
                        $jumlah += ($v->bahan['harga'] / $v['bahan']->konversi_pemakaian) * $v['pemakaian'];
                    }

                    if ($v['bahanolahan_id']) {
                        $idbahanolahan = Olahan::where('id', $v['bahanolahan_id'])->first();
                        if ($idbahanolahan) {
                            $jumlah += ($idbahanolahan['produksi'] / $idbahanolahan['hasil']) * $v['pemakaian'];
                        }
                    }
                }
            }


            //cek nama
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
                    'hasil' => $request->input('hasil'),
                    'satuan_pengeluaran' => $request->input('satuan_pengeluaran'),
                    'satuan_penyajian' => $request->input('satuan_penyajian'),
                    'produksi' => round($jumlah),
                    'konversi_penyajian' => $this->unrupiah($request->input('konversi_penyajian'))
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
                    'hasil' => $request->input('hasil'),
                    'satuan_pengeluaran' => $request->input('satuan_pengeluaran'),
                    'satuan_penyajian' => $request->input('satuan_penyajian'),
                    'konversi_penyajian' => $this->unrupiah($request->input('konversi_penyajian')),
                    'kode' => 'BO' . $this->kode,
                    'produksi' => $jumlah,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if ($olahanid = Olahan::insertGetId($input)) {
                    $request->session()->put('IdOlahan', $olahanid);
                    $data = [
                        'id' => $olahanid,
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


            //bahan baku
            $pakai =  $request->input('pakai');
            $rows1 = 0;
            if ($Olahan && $pakai) {
                foreach ($bahanolahan as $v) {
                    if ($v['bahan_id']) {
                        if (!Bahan_Olahan::where('id', $v['id'])->update(['pemakaian' => $pakai[$rows1++], 'draft' => true])) {
                            $data = [
                                'toast' => true,
                                'status' => 'error',
                                'pesan' =>  'Terjadi kegagalan system'
                            ];
                        } else {
                            Olahan::where('id', $id)->update(['draft' => true]);
                        }
                    }
                }
            }

            //bahan olahan
            $pakaiolahan =  $request->input('pakaiolahan');
            $rows2 = 0;
            if ($Olahan && $pakaiolahan) {
                foreach ($bahanolahan as $v) {
                    if ($v['bahanolahan_id']) {
                        if (!Bahan_Olahan::where('id', $v['id'])->update([
                            'pemakaian' => $pakaiolahan[$rows2++], 'draft' => true
                        ])) {
                            $data = [
                                'toast' => true,
                                'status' => 'error',
                                'pesan' =>  'Terjadi kegagalan system'
                            ];
                        } else {
                            Olahan::where('id', $id)->update(['draft' => true]);
                        }
                    }
                }
            }



            if ($request->input('submit')) {
                Olahan::where('id', $id)->update(['draft' => false, 'produksi' => round($jumlah),]);
                Bahan_Olahan::where('olahan_id', $id)->update(['draft' => false]);
                $request->session()->forget('IdOlahan');
            }
        }


        echo json_encode($data);
    }

    //bahan baku
    public function PilihBahanBaku(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');

        $this->data['OlahanDataBahanBaku'] = Bahan::all();
        if ($id) {
            $request->session()->put('IdEditOlahan', $id);
            $data = Bahan_Olahan::where('olahan_id', $id)->with('Bahan')->get();
            $cekid = array();
            foreach ($data as $v) {
                if (isset($v->bahan['id'])) {
                    $cekid[] = $v->bahan['id'];
                }
            }
            $this->data['cekid'] = $cekid;
        } else {
            $this->data['cekid'] = null;
        }
        return view('Edit', $this->data);
    }

    public function OlahanItemBahanBaku(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Olahan';
        $this->subtitle = $this->data['subtitle'];


        $id = $request->session()->get('IdOlahan');
        if ($id) {
            $Data = Bahan_Olahan::where('olahan_id', $id)->where('bahanolahan_id', null)->with('Bahan', 'Olahan')->get();
        } else {
            $Data = array();
        }

        $result = array('data' => array());
        $key = 0;
        foreach ($Data as $value) {
            if ($value->bahan) {
                $button = '<a onclick="hapusitemolahan(' . $value['id'] . ')" class="btn btn-danger" ><i class="fas fa-trash"></i> </a>';

                $result['data'][$key] = array(
                    $value->bahan['nama'],
                    $value->bahan['konversi_pemakaian'] . '/' . $value->bahan['satuan_pemakaian'],
                    $this->rupiah($value->bahan['harga']),
                    '<div class="input-group"><input onkeyup="jumlahbahan(' . $key . ', this.value)" class="form-control" type="number" value="' . $value['pemakaian'] . '" name="pakai[]" id="pakai_' . $key . '" /> <div class="input-group-append"><span class="input-group-text">' . $value->bahan['satuan_pemakaian'] . '</span></div></div>',
                    '<font id="jmlbahan_' . $key . '">' . $this->rupiah(($value->bahan['harga'] / $value->bahan['konversi_pemakaian']) * $value['pemakaian']) . '</font>/' . $value->bahan['satuan_pemakaian'],
                    $button . '
                    <input type="hidden" class="totalbahan" id="hargabahan_' . $key . '" value="' . $value->bahan['harga'] . '" >
                    <input type="hidden" id="konversi_pemakaian_' . $key . '" value="' . $value->bahan['konversi_pemakaian'] . '" >
                    <input type="hidden" id="totalbahan_' . $key . '" value="' . ($value->bahan['harga'] / $value->bahan['konversi_pemakaian']) * $value['pemakaian'] . '" >
                    '
                );

                $key++;
            }
        }
        echo json_encode($result);
    }

    public function TambahItemBahanBaku(Request $request)
    {


        $this->data['user_permission'] = $this->permission();
        if (!in_array('createFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');

        if ($id) {
            $input = array();
            foreach ($id as $v) {
                $input[] = array(
                    'olahan_id' => $request->session()->get('IdEditOlahan'),
                    'bahan_id' => $v,
                    'pemakaian' => 0,
                    'created_at' => date('Y-m-d H:i:s')
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
                    'pesan' => 'Gagal Saat Menambah Data'
                ];
            }
        } else {
            $data = [
                'toast' => true,
                'status' => 'errror',
                'pesan' => 'Belum memilih item'
            ];
        }

        echo json_encode($data);
    }
    //bahan baku

    //Olahan
    public function PilihBahanOlahan(Request $request)
    {

        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');

        $this->data['OlahanDataBahanOlahan'] = Olahan::where('delete', 0)->where('draft', false)->get();
        if ($id) {
            $request->session()->put('IdEditOlahan', $id);
            $data = Bahan_Olahan::where('olahan_id', $id)->with('Bahan')->get();
            $cekid = array();
            foreach ($data as $v) {
                if ($v['bahanolahan_id']) {
                    $cekid[] = $v['bahanolahan_id'];
                }
            }
            $this->data['cekid'] = $cekid;
        } else {
            $this->data['cekid'] = null;
        }


        return view('Edit', $this->data);
    }
    public function OlahanItemBahanOlahan(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Olahan';
        $this->subtitle = $this->data['subtitle'];


        $id = $request->session()->get('IdOlahan');
        if ($id) {
            $Data = Bahan_Olahan::where('olahan_id', $id)->where('bahan_id', null)->get();
        } else {
            $Data = array();
        }

        $result = array('data' => array());
        $key = 0;
        if ($Data) {
            foreach ($Data as $value) {
                if ($value['bahanolahan_id']) {
                    $olahan = Olahan::where('id', $value['bahanolahan_id'])->with('Bahan')->first();

                    $button = '<a onclick="hapusitemolahan(' . $value['id'] . ')" class="btn btn-danger" ><i class="fas fa-trash"></i> </a>';

                    $result['data'][$key] = array(
                        $olahan->nama,
                        $olahan->hasil . ' ' . $olahan->satuan_penyajian,
                        $this->rupiah($olahan['produksi']),
                        '<div class="input-group"><input class="form-control" type="number" value="' . $value['pemakaian'] . '" onkeyup="jumlaholahan(' . $key . ', this.value)" name="pakaiolahan[]" id="pakaiolahan_' . $key . '" /> <div class="input-group-append"><span class="input-group-text">' . $olahan->satuan_penyajian . '</span></div></div>',
                        '<font id="jmlolah_' . $key . '">' . $this->rupiah(($olahan['produksi'] / $olahan['hasil']) * $value['pemakaian']) . '</font>',
                        $button . '
                    <input type="hidden" class="totalolah" id="hargaolah_' . $key . '" value="' . $olahan->produksi . '" >
                    <input type="hidden" id="hasil_' . $key . '" value="' . $olahan->hasil . '" >
                    <input type="hidden" id="totalolah_' . $key . '" value="' . ($olahan['produksi'] / $olahan['hasil']) * $value['pemakaian'] . '" >
                    '
                    );

                    $key++;
                }
            }
        }
        echo json_encode($result);
    }
    public function TambahItemBahanOlahan(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('createFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }


        $id = $request->input('id');

        if ($id) {
            $input = array();
            foreach ($id as $v) {
                $input[] = array(
                    'olahan_id' => $request->session()->get('IdEditOlahan'),
                    'bahanolahan_id' => $v,
                    'pemakaian' => 0,
                    'created_at' => date('Y-m-d H:i:s')
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
                    'pesan' => 'Gagal Saat Menambah Data'
                ];
            }
        } else {
            $data = [
                'toast' => true,
                'status' => 'errror',
                'pesan' => 'Belum memilih item'
            ];
        }

        echo json_encode($data);
    }
    //Olahan

    public function OlahanBahanManage(Request $request)
    {

        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Olahan';
        $this->subtitle = $this->data['subtitle'];


        $id = $request->session()->get('IdOlahan');
        if ($id) {
            $Data = Bahan_Olahan::where('olahan_id', $id)->with('Bahan', 'Olahan')->get();
        } else {
            $Data = array();
        }

        $result = array('data' => array());
        $key = 0;
        foreach ($Data as $value) {
            if ($value->bahan) {
                $button = '<a onclick="hapusitemoalahan(' . $value['id'] . ')" class="btn btn-danger" ><i class="fas fa-trash"></i> </a>';

                $result['data'][$key] = array(
                    $value->bahan['nama'],
                    $value->bahan['konversi_pemakaian'] . '/' . $value->bahan['satuan_pemakaian'],
                    $this->rupiah($value->bahan['harga']),
                    '<div class="input-group"><input class="form-control" type="number" value="' . $value['pemakaian'] . '" name="pakai[]" id="pakai_' . $key . '" /> <div class="input-group-append"><span class="input-group-text">' . $value->bahan['satuan_pemakaian'] . '</span></div></div>',
                    $this->rupiah(($value->bahan['harga'] / $value->bahan['konversi_pemakaian']) * $value['pemakaian']) . '/' . $value->bahan['satuan_pemakaian'],
                    $button
                );

                $key++;
            }
        }
        echo json_encode($result);
    }

    public function OlahanHapus(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('deleteFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }

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

    public function ItemOlahanHapus(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('deleteFoodcostBahanOlahan', $this->permission())) {
            return redirect()->to('/');
        }

        $id =  $request->input('id');
        if ($id) {
            if (Bahan_Olahan::where('id', $id)->delete()) {
                $data = [
                    'toast' => true,
                    'status' => 'success',
                    'pesan' => 'Berhasil Terhapus'
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Terjadi kegagalan system saat hapus'
                ];
            };
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Id tak ditemukan'
            ];
        };

        echo json_encode($data);
    }
    /////////////////////////////////// OLAHAN //////////////////////////










    /////////////////////////////////// Resep //////////////////////////
    public function Resep(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Resep';
        $this->data['kode'] = 'BR' . $this->kodeResep;
        $this->data['satuan'] = Satuan::all();


        $id = $request->session()->get('IdResep');
        $this->data['Resep'] = Resep::where('id', $id)->with('Bahan')->first();

        $jumlahbb = 0;
        $jumlahb0 = 0;
        $Data = Bahan_Resep::where('resep_id', $id)->with('Bahan', 'Olahan')->get();
        if ($Data) {
            foreach ($Data as $value) {
                if ($value->bahan) {
                    $jumlahbb += ($value->bahan['harga'] / $value->bahan['konversi_pemakaian']) * $value['pemakaian'];
                }

                if ($value['olahan']) {
                    $jumlahb0 += ($value['olahan']->produksi / $value['olahan']->hasil) * $value['pemakaian'];
                }
            }
        }
        $this->data['Jmlbb'] = $this->rupiah($jumlahbb);
        $this->data['Jmlbo'] = $this->rupiah($jumlahb0);
        $this->data['totaljml'] = $this->rupiah($jumlahb0 + $jumlahbb);
        return view('Resep', $this->data);
    }

    public function ResepManage(Request $request)
    {

        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Resep';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Resep::where('delete', false)->with('Bahan')->latest()->get();
        foreach ($Data as $value) {
            $id = $request->session()->get('IdOlahan');
            if ($id != $value['id']) {
                $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

                if (in_array('updateFoodcostResep', $this->permission())) {
                    $button .= "<li><a class='dropdown-item' href='Resep/SessionCreate?id=" . $value['id'] . "'><i class='fas fa-pencil-alt'></i> Edit</a></li>";
                }
                if (in_array('deleteFoodcostResep', $this->permission())) {
                    $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->subtitle . '"' . ")'  ><i class='fas fa-trash-alt'></i> Hapus</a></li>";
                }
                $button .= '</ul></div>';


                if ($value['draft']) {
                    $draft = 'Draft';
                } else {
                    $draft = '';
                }

                $result['data'][] = array(
                    $value['kode'],
                    $value['nama']  . ' <span class="badge badge-info">' . $draft . '</span>',
                    $this->rupiah($value['hpp']),
                    $this->unrupiah($value['hpp']) . ' ' . $value['satuan'],
                    $button
                );
            }
        }
        echo json_encode($result);
    }

    public function ResepTambah(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('createFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required',
                'satuan' => 'required',
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

            $id = $request->session()->get('IdResep');

            $jumlah = 0;
            $bahanresep = Bahan_Resep::where('resep_id', $id)->with('Bahan', 'Olahan')->get();
            if ($bahanresep) {
                foreach ($bahanresep as $v) {
                    if ($v['bahan']) {
                        $jumlah += ($v->bahan['harga'] / $v['bahan']->konversi_pemakaian) * $v['pemakaian'];
                    }

                    if ($v['olahan']) {
                        $jumlah += ($v['olahan']->produksi / $v['olahan']->hasil) * $v['pemakaian'];
                    }
                }
            }



            $Resep = Resep::where('id', $id)->first();
            if ($Resep) {
                if ($Resep['nama'] == $request->input('nama')) {
                    $nama = $request->input('nama');
                } else {
                    $str = Resep::where('nama', $request->input('nama'))->count();
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
                if (Resep::where('delete', false)->where('nama', $request->input('nama'))->count()) {
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
            if ($nama && $Resep) {
                $input = [
                    'nama' => $nama,
                    'kategori' => $request->input('kategori'),
                    'satuan' => $request->input('satuan'),
                    'hpp' => round($jumlah),
                ];
                if (Resep::where('id', $id)->update($input)) {
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
                    'kategori' => $request->input('kategori'),
                    'satuan' => $request->input('satuan'),
                    'kode' => 'BR' . $this->kodeResep,
                    'hpp' => $jumlah,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if ($resepid = Resep::insertGetId($input)) {
                    $request->session()->put('IdResep', $resepid);
                    $data = [
                        'id' => $resepid,
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


            //input pakai bahan baku
            $pakai =  $request->input('pakai');
            $key = 0;
            if ($Resep && $pakai) {
                foreach ($bahanresep as $no => $v) {
                    if ($v['bahan_id']) {
                        if (!Bahan_Resep::where('id', $v['id'])->update([
                            'pemakaian' => $pakai[$key++] ?? 0, 'draft' => true
                        ])) {
                            $data = [
                                'toast' => true,
                                'status' => 'error',
                                'pesan' =>  'Terjadi kegagalan system'
                            ];
                        } else {
                            Resep::where('id', $id)->update(['draft' => true]);
                        }
                    }
                }
            }

            //input pakai bahan olahan
            $pakaiolahan =  $request->input('pakaiolahan');
            $key1 = 0;
            if ($Resep && $pakaiolahan) {
                foreach ($bahanresep as $no => $v) {
                    if ($v['olahan_id']) {
                        if (!Bahan_Resep::where('id', $v['id'])->update([
                            'pemakaian' => $pakaiolahan[$key1++] ?? 0, 'draft' => true
                        ])) {

                            $data = [
                                'toast' => true,
                                'status' => 'error',
                                'pesan' =>  'Terjadi kegagalan system'
                            ];
                        } else {
                            Resep::where('id', $id)->update(['draft' => true]);
                        }
                    }
                }
            }


            if ($request->input('submit')) {
                Resep::where('id', $id)->update(['draft' => false, 'hpp' => round($jumlah)]);
                Bahan_Resep::where('resep_id', $id)->update(['draft' => false]);
                $request->session()->forget('IdResep');
            }
        }


        echo json_encode($data);
    }

    //bahan baku
    public function PilihResepBahanBaku(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');

        $this->data['ResepDataBahanBaku'] = Bahan::all();
        if ($id) {
            $request->session()->put('IdEditResep', $id);
            $data = Bahan_Resep::where('resep_id', $id)->where('olahan_id', null)->with('Bahan')->get();
            $cekid = array();
            foreach ($data as $v) {
                if (isset($v->bahan['id'])) {
                    $cekid[] = $v->bahan['id'];
                }
            }
            $this->data['cekid'] = $cekid;
        } else {
            $this->data['cekid'] = null;
        }
        return view('Edit', $this->data);
    }

    public function ResepItemBahanBaku(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Resep';
        $this->subtitle = $this->data['subtitle'];


        $id = $request->session()->get('IdResep');
        if ($id) {
            $Data = Bahan_Resep::where('resep_id', $id)->where('olahan_id', null)->with('Bahan')->get();
        } else {
            $Data = array();
        }

        $result = array('data' => array());
        $key = 0;
        foreach ($Data as $value) {
            if ($value->bahan) {
                $button = '<a onclick="hapusitemresep(' . $value['id'] . ')" class="btn btn-danger" ><i class="fas fa-trash"></i> </a>';

                $result['data'][$key] = array(
                    $value->bahan['nama'],
                    $value->bahan['konversi_pemakaian'] . '/' . $value->bahan['satuan_pemakaian'],
                    $this->rupiah($value->bahan['harga']),
                    '<div class="input-group"><input onkeyup="jumlahbahan(' . $key . ', this.value)" class="form-control" type="number" value="' . $value['pemakaian'] . '" name="pakai[]" id="pakai_' . $key . '" /> <div class="input-group-append"><span class="input-group-text">' . $value->bahan['satuan_pemakaian'] . '</span></div></div>',
                    '<font id="jmlbahan_' . $key . '">' . $this->rupiah(($value->bahan['harga'] / $value->bahan['konversi_pemakaian']) * $value['pemakaian']) . '</font>/' . $value->bahan['satuan_pemakaian'],
                    $button . '
                    <input type="hidden" class="totalbahan" id="hargabahan_' . $key . '" value="' . $value->bahan['harga'] . '" >
                    <input type="hidden" id="konversi_pemakaian_' . $key . '" value="' . $value->bahan['konversi_pemakaian'] . '" >
                    <input type="hidden" id="totalbahan_' . $key . '" value="' . ($value->bahan['harga'] / $value->bahan['konversi_pemakaian']) * $value['pemakaian'] . '" >
                    '
                );

                $key++;
            }
        }
        echo json_encode($result);
    }

    public function TambahResepItemBahanBaku(Request $request)
    {


        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');

        if ($id) {
            $input = array();
            foreach ($id as $v) {
                $input[] = array(
                    'resep_id' => $request->session()->get('IdEditResep'),
                    'bahan_id' => $v,
                    'pemakaian' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                );
            }
            if (Bahan_Resep::insert($input)) {
                $data = [
                    'toast' => true,
                    'status' => 'success',
                    'pesan' => 'Berhasil'
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'errror',
                    'pesan' => 'Gagal Saat Menambah Data'
                ];
            }
        } else {
            $data = [
                'toast' => true,
                'status' => 'errror',
                'pesan' => 'Belum memilih item'
            ];
        }

        echo json_encode($data);
    }
    //bahan baku

    //Olahan
    public function PilihResepBahanOlahan(Request $request)
    {

        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');

        $this->data['ResepDataBahanOlahan'] = Olahan::where('delete', 0)->where('draft', false)->get();
        if ($id) {
            $request->session()->put('IdEditResep', $id);
            $data = Bahan_Resep::where('resep_id', $id)->where('bahan_id', null)->with('Olahan')->get();
            $cekid = array();
            foreach ($data as $v) {
                if (isset($v->olahan['id'])) {
                    $cekid[] = $v->olahan['id'];
                }
            }
            $this->data['cekid'] = $cekid;
        } else {
            $this->data['cekid'] = null;
        }


        return view('Edit', $this->data);
    }
    public function ResepItemBahanOlahan(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Resep';
        $this->subtitle = $this->data['subtitle'];


        $id = $request->session()->get('IdResep');
        if ($id) {
            $Data = Bahan_Resep::where('resep_id', $id)->where('bahan_id', null)->get();
        } else {
            $Data = array();
        }

        $result = array('data' => array());
        $key = 0;
        if ($Data) {
            foreach ($Data as $value) {
                if ($value['olahan']) {

                    $button = '<a onclick="hapusitemresep(' . $value['id'] . ')" class="btn btn-danger" ><i class="fas fa-trash"></i> </a>';

                    $result['data'][$key] = array(
                        $value['olahan']->nama,
                        $value['olahan']->hasil . ' ' . $value['olahan']->satuan_penyajian,
                        $this->rupiah($value['olahan']['produksi']),
                        '<div class="input-group"><input class="form-control" type="number" value="' . $value['pemakaian'] . '" onkeyup="jumlaholahan(' . $key . ', this.value)" name="pakaiolahan[]" id="pakaiolahan_' . $key . '" /> <div class="input-group-append"><span class="input-group-text">' . $value['olahan']->satuan_penyajian . '</span></div></div>',
                        '<font id="jmlolah_' . $key . '">' . $this->rupiah(($value['olahan']['produksi'] / $value['olahan']->hasil) * $value['pemakaian']) . '</font>',
                        $button . '
                    <input type="hidden" class="totalolah" id="hargaolah_' . $key . '" value="' . $value['olahan']->produksi . '" >
                    <input type="hidden" id="hasil_' . $key . '" value="' . $value['olahan']->hasil . '" >
                    <input type="hidden" id="totalolah_' . $key . '" value="' . ($value['olahan']['produksi'] / $value['olahan']->hasil) * $value['pemakaian'] . '" >
                    '
                    );

                    $key++;
                }
            }
        }
        echo json_encode($result);
    }
    public function TambahResepItemBahanOlahan(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }


        $id = $request->input('id');

        if ($id) {
            $input = array();
            foreach ($id as $v) {
                $input[] = array(
                    'resep_id' => $request->session()->get('IdEditResep'),
                    'olahan_id' => $v,
                    'pemakaian' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                );
            }
            if (Bahan_Resep::insert($input)) {
                $data = [
                    'toast' => true,
                    'status' => 'success',
                    'pesan' => 'Berhasil'
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'errror',
                    'pesan' => 'Gagal Saat Menambah Data'
                ];
            }
        } else {
            $data = [
                'toast' => true,
                'status' => 'errror',
                'pesan' => 'Belum memilih item'
            ];
        }

        echo json_encode($data);
    }
    //Olahan

    public function ResepBahanManage(Request $request)
    {

        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Resep';
        $this->subtitle = $this->data['subtitle'];


        $id = $request->session()->get('IdResep');
        if ($id) {
            $Data = Bahan_Resep::where('resep_id', $id)->with('Bahan', 'Olahan')->get();
        } else {
            $Data = array();
        }

        $result = array('data' => array());
        $key = 0;
        foreach ($Data as $value) {
            if ($value->bahan) {
                $button = '<a onclick="hapusitemresep(' . $value['id'] . ')" class="btn btn-danger" ><i class="fas fa-trash"></i> </a>';

                $result['data'][$key] = array(
                    $value->bahan['nama'],
                    $value->bahan['konversi_pemakaian'] . '/' . $value->bahan['satuan_pemakaian'],
                    $this->rupiah($value->bahan['harga']),
                    '<div class="input-group"><input class="form-control" type="number" value="' . $value['pemakaian'] . '" name="pakai[]" id="pakai_' . $key . '" /> <div class="input-group-append"><span class="input-group-text">' . $value->bahan['satuan_pemakaian'] . '</span></div></div>',
                    $this->rupiah(($value->bahan['harga'] / $value->bahan['konversi_pemakaian']) * $value['pemakaian']) . '/' . $value->bahan['satuan_pemakaian'],
                    $button
                );

                $key++;
            }
        }
        echo json_encode($result);
    }

    public function ResepHapus(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('deleteFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }

        $id =  $request->input('id');
        if (Resep::where('id', $id)->update(['delete' => true])) {
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

    public function ItemResepHapus(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('deleteFoodcostResep', $this->permission())) {
            return redirect()->to('/');
        }

        $id =  $request->input('id');
        if ($id) {
            if (Bahan_Resep::where('id', $id)->delete()) {
                $data = [
                    'toast' => true,
                    'status' => 'success',
                    'pesan' => 'Berhasil Terhapus'
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Terjadi kegagalan system saat hapus'
                ];
            };
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Id tak ditemukan'
            ];
        };

        echo json_encode($data);
    }
    /////////////////////////////////// OLAHAN //////////////////////////
}
