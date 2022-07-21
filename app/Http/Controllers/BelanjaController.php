<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use App\Models\Belanja;
use App\Models\Inventory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class BelanjaController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Belanja';
        $this->title = $this->data['title'];
        $this->data['subtitle'] = '';
    }

    public function index(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewBelanja', $this->permission())) {
            return redirect()->to('/');
        }

        $this->AutoHarga();

        $this->data['Belanja'] = Inventory::with('Bahan')->first();

        $bhn = Inventory::where('store_id', $request->session()->get('store_id'))->where('delete', false)->with('Bahan')->get();
        $bahan = [];
        foreach ($bhn as $key => $value) {
            $bahan[] = array(
                'id' => $value['bahan']->id,
                'nama' => $value['bahan']->nama
            );
        }

        $this->data['satuan'] = Satuan::all();
        $this->data['bahan'] = $bahan;
        $this->data['Data'] = Belanja::where('tgl', date('Y-m-d'))->where('delete', false)->where('store_id', $request->session()->get('store_id'))->orderBy('up', 'DESC')->get();
        return view('Belanja', $this->data);
    }

    public function Input(Request $request)
    {

        if (!in_array('createBelanja', $this->permission())) {
            return redirect()->to('/');
        }

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required',
                'kategori' => 'required',
                'qty' => 'required'
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
            foreach ($request->input('kategori') as $key => $kategori) {
                if (isset($request->input('qty')[$key]) && isset($request->input('nama')[$key])) {
                    if ($kategori == 'Supplay' or $kategori == 'Oprasional' or $kategori == 'ART') {
                        $input = [
                            'nama' => $request->input('nama')[$key],
                            'tgl' => date('Y-m-d'),
                            'kategori' => $kategori,
                            'users_id' => $request->session()->get('id'),
                            'store_id' => $request->session()->get('store_id'),
                            'qty' => $request->input('qty')[$key],
                            'harga' => $request->input('harga')[$key] ?? null,
                            'ket' => $request->input('ket')[$key] ?? null,
                            'total' => $request->input('qty')[$key] * $request->input('harga')[$key] ?? 0,
                            'uom' => $request->input('uombelanja')[$key] ?? null,
                            'stock' => $request->input('stock')[$key] ?? null,
                            'stock_uom' => $request->input('stock_uom')[$key] ?? null,
                            'stock_harga' => $request->input('stock_harga')[$key] ?? null,
                            'hutang' => $request->input('hutang')[$key] ?? 0,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $id = $request->input('id')[$key] ?? 0;
                        if ($id) {
                            if (Belanja::where('id', $id)->update($input)) {
                                $data = [
                                    'toast' => true,
                                    'status' => 'success',
                                    'pesan' => 'Autosave Berhasil'
                                ];
                            } else {
                                $data = [
                                    'toast' => true,
                                    'status' => 'error',
                                    'pesan' =>  'Terjadi kegagalan system' . $id
                                ];
                            };
                        } else {
                            if ($idbelanja = Belanja::insertGetId($input)) {
                                $data = [
                                    'toast' => true,
                                    'status' => 'success',
                                    'pesan' => 'Autosave Berhasil',
                                    'id' => $idbelanja,
                                    'row' => $request->input('key')[$key]
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
                        $inventory = Inventory::with('Bahan')->where('bahan_id', $request->input('nama')[$key])->first();
                        $harga =  $request->input('stock_harga')[$key] ?? 0;
                        $stock = $request->input('stock')[$key] ?? 0;
                        $total = $harga * $stock;
                        $id = $request->input('id')[$key] ?? 0;

                        $jml = Belanja::where('bahan_id', $inventory['bahan']->id)
                            ->where('tgl', date('Y-m-d'))
                            ->where('store_id', $request->session()->get('store_id'))
                            ->where('up', false)
                            ->count();

                        if (!$jml or $id) {
                            $input = [
                                'nama' => $inventory['bahan']->nama,
                                'bahan_id' => $inventory['bahan_id'],
                                'tgl' => date('Y-m-d'),
                                'kategori' => 'Item',
                                'total' => $total,
                                'store_id' => $request->session()->get('store_id'),
                                'users_id' => $request->session()->get('id'),
                                'qty' => $request->input('qty')[$key] ?? null,
                                'harga' => $request->input('harga')[$key] ?? null,
                                'ket' => $request->input('ket')[$key] ?? null,
                                'uom' => $request->input('uombelanja')[$key] ?? null,
                                'stock' => $request->input('stock')[$key] ?? null,
                                'stock_harga' => $request->input('stock_harga')[$key] ?? null,
                                'stock_uom' => $inventory['satuan'],
                                'hutang' => $request->input('hutang')[$key] ?? 0,
                                'updated_at' => date('Y-m-d H:i:s'),
                                'created_at' => date('Y-m-d H:i:s')
                            ];

                            if ($id) {
                                if (Belanja::where('id', $id)->update($input)) {
                                    $data = [
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
                            } else {
                                if ($idbelanja = Belanja::insertGetId($input)) {
                                    $data = [
                                        'toast' => true,
                                        'status' => 'success',
                                        'pesan' => 'Autosave Berhasil',
                                        'id' => $idbelanja,
                                        'row' => $request->input('key')[$key]
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
                                'pesan' =>  '<b>' . $inventory['bahan']->nama . '</b> Telah ada, Silahkan cek kembali'
                            ];
                        }
                    }
                } else {
                    $data = false;
                }
            }
        }



        echo json_encode($data);
    }

    public function Upload(Request $request)
    {

        if (!in_array('createBelanja', $this->permission())) {
            return redirect()->to('/');
        }

        $belanja = Belanja::where('up', false)->where('store_id', $request->session()->get('store_id'))->where('tgl', date('Y-m-d'))->get();


        if (isset($belanja[0]['nama'])) {
            $cek = true;
            $item = '';
            foreach ($belanja as $key => $value) {
                if ($value['qty'] && $value['uom'] && $value['harga']) {
                    if (Belanja::where('id', $value['id'])->update(['up' => true])) {
                        if ($value['bahan_id']) {
                            if ($value['stock']) {
                                $bhn = Inventory::where('bahan_id', $value['bahan_id'])->first();
                                if ($bhn) {
                                    $jumlah = $value['stock'] + $bhn['qty'];
                                    if (!Inventory::where('bahan_id', $value['bahan_id'])->update(['qty' => $jumlah])) {
                                        Belanja::where('id', $value['id'])->update(['up' => false]);
                                        $cek = false;
                                        $item .= $value['nama'] . '- Inventory Gagal Menambah <br>';
                                    };
                                } else {
                                    Belanja::where('id', $value['id'])->update(['up' => false]);
                                    $cek = false;
                                    $item .= $value['nama'] . '- Inventory Kosong <br>';
                                }
                            } else {
                                Belanja::where('id', $value['id'])->update(['up' => false]);
                                $cek = false;
                                $item .= $value['nama'] . '- Qty UOM Kosong <br>';
                            }
                        }
                    } else {
                        $cek = false;
                        $item .= $value['nama'] . '- Gagal Upload <br>';
                    }
                } else {
                    $cek = false;
                    $item .= $value['nama'] . '- Tidak Lengkap <br>';
                }
            }
            if ($cek) {
                $data = [
                    'toast' => true,
                    'status' => 'success',
                    'pesan' =>  'Belanja Berhasil Diupload Dengan Aman'
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  $item
                ];
            }
        } else {
            $data = [
                'toast' => true,
                'status' => 'warning',
                'pesan' =>  'Item Belanja Tidak Ada'
            ];
        }

        echo json_encode($data);
    }

    public function Namabarang(Request $request)
    {

        if (!in_array('viewBelanja', $this->permission())) {
            return redirect()->to('/');
        }

        $bhn = Inventory::where('store_id', $request->session()->get('store_id'))->where('delete', false)->with('Bahan')->get();
        $bahan = [];
        foreach ($bhn as $key => $value) {
            $bahan[] = array(
                'id' => $value['id'],
                'bahan_id' => $value['bahan']->id,
                'nama' => $value['bahan']->nama
            );
        }

        $satuan = Satuan::all();
        echo json_encode(array('satuan' => $satuan, 'bahan' => $bahan));
    }

    public function Inventorybahanid(Request $request)
    {
        if (!in_array('viewBelanja', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');
        if ($id) {
            $bhn = Inventory::where('bahan_id', $id)->first();
            echo json_encode($bhn);
        }
    }

    public function HapusItem(Request $request)
    {
        if (!in_array('deleteBelanja', $this->permission())) {
            return redirect()->to('/');
        }

        $id =  $request->input('id');
        if (Belanja::where('id', $id)->delete()) {
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
        if (!in_array('viewBelanja', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Belanja';
        $this->subtitle = $this->data['subtitle'];
        $id_store = request()->session()->get('store_id');

        $result = array('data' => array());
        $tgl = [];
        foreach (Belanja::select('tgl')->where('store_id', $id_store)->where('delete', false)->get()->toArray() as $v) {
            $tgl[] = $v['tgl'];
        }
        $tgl = array_unique($tgl);


        foreach ($tgl as $value) {
            $total =  Belanja::where('store_id', $id_store)->where('tgl', $value)->where('delete', false)->sum('total');
            if (Belanja::where('store_id', $id_store)->where('tgl', $value)->where('up', false)->where('delete', false)->count()) {
                $up = '<a class="badge badge-danger">Proses</a>';
            } else {
                $up = '<a class="badge badge-success">Success</a>';
            }

            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('viewBelanja', $this->permission())) $button .= "<li><a class='dropdown-item' onclick='lihat(" . '"' . $value . '"' . "," . '"' . $this->title . '"' . ")' data-toggle='modal' data-target='#lihat' href='#'><i class='fas fa-eye'></i> Lihat</a></li>";

            $button .= '</ul></div>';


            $result['data'][] = array(
                $value,
                $this->rupiah($total),
                $up,
                $button
            );
        }
        echo json_encode($result);
    }

    public function ViewItem(Request $request)
    {
        if (!in_array('viewBelanja', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');
        $judul = $request->input('judul');
        $id_store = request()->session()->get('store_id');

        $variable = Belanja::with('Store')->where('store_id', $id_store)->where('tgl', $id)->get();

        if (request()->session()->get('tipe')) {
            $viewthstore = '<th rowspan="2" style="vertical-align : middle;text-align:center;">Store</th>';
        } else {
            $viewthstore = '';
        }

        $html = ' 
        <h5><b>' . $this->tanggal($id, true) . '</b></h5>
        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    ' . $viewthstore . '
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Nama</th>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Kategori</th>
                                    <th colspan="2" style="vertical-align : middle;text-align:center;">Qty Nota</th>
                                    <th colspan="2" style="vertical-align : middle;text-align:center;">Stock</th>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Ket</th>
                                    <th rowspan="2" style="vertical-align : middle;text-align:center;">Total</th>
                                </tr>
                                <tr>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>';

        $jumlah = 0;
        foreach ($variable as $key => $value) {
            if ($value['hutang']) {
                $hutang = ' <a class="badge badge-danger">Hutang</a> ';
            } else {
                $hutang = ' ';
            }

            if (!$value['up']) {
                $up = ' <a class="badge badge-warning">Proses</a> ';
                $hapus = ' <a class="btn btn-danger btn-sm" onclick="hapusbelanja(' . $value['id'] . ',0)"><i class="fa fa-times"></i> </a>';
            } else {
                $up = '';
                $hapus = '';
            }


            if ($value['stock']) {
                $stock = $value['stock'];
                $total = $value['stock'] * $value['stock_harga'];
                $jumlah += $total;
            } else {
                $stock = '-';
                $total = $value['qty'] * $value['harga'];
                $jumlah += $total;
            }

            if (request()->session()->get('tipe')) {
                $viewstore = '<td>' . $value['store']->nama . '</td>';
                $viewtotal = 8;
            } else {
                $viewtotal = 7;
                $viewstore = '';
            }

            $html .= '
                    <tr>
                        ' . $viewstore . '
                        <td>'  . $up . $value['nama'] . '</td>
                        <td>' . $value['kategori'] . '</td>
                        <td>' . $value['qty'] . ' ' . $value['uom'] . '</td>
                        <td>' . $this->rupiah($value['harga']) . '</td>
                        <td>' . $stock . '</td>
                        <td>' . $this->rupiah($value['stock_harga']) . '</td>
                        <td>' . $hutang . $value['ket'] . '</td>
                        <td>' . $this->rupiah($total) . $hapus . '</td>
                    </tr>
                       
            ';
        }
        $html .= '
                        <tr style="background-color:#607d8b7a;">
                            <td colspan="' . $viewtotal . '"><b>Total</b> </td>
                            <td><b>' . $this->rupiah($jumlah, true) . '</b></td>
                        </tr>
                        </table>';

        echo $html;
    }
}
