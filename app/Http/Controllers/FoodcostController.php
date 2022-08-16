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
                        $jumlahb0 += $bahanolahan['produksi'];
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
            $jmlolh = Bahan_Olahan::where('olahan_id', $id)->with('Bahan', 'Olahan')->get();
            if ($jmlolh) {
                foreach ($jmlolh as $jmlpro) {
                    if ($jmlpro['bahan']) {
                        $jumlah += ($jmlpro->bahan['harga'] / $jmlpro['bahan']->konversi_pemakaian) * $jmlpro['pemakaian'];
                    }

                    if ($jmlpro['bahanolahan_id']) {
                        $bahanolahan = Olahan::where('id', $jmlpro['bahanolahan_id'])->first();
                        if ($bahanolahan) {
                            $jumlah += $bahanolahan['produksi'];
                        }
                    }
                }
            }



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

            $pakaiolahan =  $request->input('pakaiolahan');
            $pakai =  $request->input('pakai');
            if ($Olahan && $pakai) {
                $cekolahan = Bahan_Olahan::where('olahan_id', $id)->where('bahanolahan_id', null)->get();
                foreach ($cekolahan as $no => $v) {

                    if (!Bahan_Olahan::where('id', $v['id'])->update([
                        'pemakaian' => $pakai[$no]
                    ])) {

                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  'Terjadi kegagalan system'
                        ];
                    };
                }
            }


            if ($Olahan && $pakaiolahan) {

                $cekolahan = Bahan_Olahan::where('olahan_id', $id)->where('bahan_id', null)->get();
                foreach ($cekolahan as $no => $v) {

                    if (!Bahan_Olahan::where('id', $v['id'])->update([
                        'pemakaian' => $pakaiolahan[$no]
                    ])) {

                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  'Terjadi kegagalan system'
                        ];
                    };
                }
            }

            if ($nama && $Olahan) {
                $input = [
                    'nama' => $nama,
                    'hasil' => $request->input('hasil'),
                    'satuan_pengeluaran' => $request->input('satuan_pengeluaran'),
                    'satuan_penyajian' => $request->input('satuan_penyajian'),
                    'produksi' => $jumlah,
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


            if ($request->input('submit')) {
                Olahan::where('id', $id)->update(['draft' => false]);
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
            session()->flash('IdEdit', $id);
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
                $button = '<a onclick="hapusitemoalahan(' . $value['id'] . ')" class="btn btn-danger" ><i class="fas fa-trash"></i> </a>';

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
                    'olahan_id' => $request->session()->get('IdEdit'),
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
            session()->flash('IdEdit', $id);
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

                    $button = '<a onclick="hapusitemoalahan(' . $value['id'] . ')" class="btn btn-danger" ><i class="fas fa-trash"></i> </a>';

                    $result['data'][$key] = array(
                        $olahan->nama,
                        $olahan->hasil . ' ' . $olahan->satuan_penyajian,
                        $this->rupiah($olahan['produksi']),
                        '<div class="input-group"><input class="form-control" type="number" value="' . $value['pemakaian'] . '" onkeyup="jumlaholahan(' . $key . ', this.value)" name="pakaiolahan[]" id="pakaiolahan_' . $key . '" /> <div class="input-group-append"><span class="input-group-text">' . $olahan->satuan_penyajian . '</span></div></div>',
                        '<font id="jmlolah_' . $key . '">' . $this->rupiah($olahan['produksi']) . '</font>',
                        $button . '
                    <input type="hidden" class="totalolah" id="hargaolah_' . $key . '" value="' . $olahan->produksi . '" >
                    <input type="hidden" id="hasil_' . $key . '" value="' . $olahan->hasil . '" >
                    <input type="hidden" id="totalolah_' . $key . '" value="' . $olahan['produksi'] . '" >
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
                    'olahan_id' => $request->session()->get('IdEdit'),
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
    /////////////////////////////////// SUPLIER //////////////////////////

}
