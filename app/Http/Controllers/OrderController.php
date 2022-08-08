<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Store;
use App\Models\Inventory;
use App\Models\Olahan;
use App\Models\Order;
use App\Models\Order_Item;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Order';
        $this->data['subtitle'] = '';
        $this->title = $this->data['title'];
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }


    public function Index(Request $request)
    {

        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewOrder', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['store'] = store::where('tipe', 'Outlet')->where('active', true)->get();
        $this->data['logistik'] = store::where('tipe', 'Logistik')->where('active', true)->get();
        $this->data['order'] = order::with('users')->where('id', $request->session()->get('IdEditOrder'))->first();
        $this->data['order_item'] = Order_Item::where('order_id', $request->session()->get('IdEditOrder'))->get();
        if ($this->data['order']) {
            $this->data['item'] = Inventory::where('store_id', $this->data['order']['logistik'])->where('delete', false)->with('Bahan')->get();
        }
        return view('Order', $this->data);
    }

    public function Items(Request $request)
    {
        if (!in_array('viewOrder', $this->permission())) {
            $data = [];
        } else {

            $data = [];

            $id = $request->input('id');
            $result = Inventory::where('store_id', $id)->where('delete', false)->with('Bahan')->get();
            if (isset($result[0])) {
                $select = [];
                foreach ($result as $key => $value) {

                    if ($value['auto_harga'] == 1) {
                        $harga = $value['harga_auto'];
                    } else {
                        $harga = $value['harga_manual'];
                    }

                    $select[] = [
                        'id' => $value['id'],
                        'nama' => $value['bahan']->nama,
                        'harga' =>  $harga,
                        'uom' => $value['satuan'],
                        'harga_update' => $value['tgl_harga']
                    ];
                }
                $data['select'] = $select;
                $data['id'] = $id;
                $data['status'] = true;
                if (request()->session()->get('tipe') === 'Outlet') {
                    $data['disabled_order'] = '';
                    $data['disabled_deliv'] = 'disabled';
                    $data['disabled_arrive'] = '';
                } else {
                    $data['disabled_order'] = 'disabled';
                    $data['disabled_deliv'] = '';
                    $data['disabled_arrive'] = 'disabled';
                }
            } else {
                if ($store = Store::where('id', $id)->first()) {
                    $data['store'] = ' untuk ' . $store['nama'];
                } else {
                    $data['store'] = '';
                }
                $data['id'] = 0;
                $data['select'] = [];
                $data['status'] = false;
            }
        }
        echo json_encode($data);
    }


    public function Select(Request $request)
    {
        if (!in_array('viewOrder', $this->permission())) {
            return redirect()->to('/');
        }

        $bahan = $request->input('id');
        $store = $request->input('store');
        $bhn = Inventory::where('id', $bahan)->where('store_id', $store)->first();
        if ($bhn) {
            if ($bhn['auto_harga'] == 1) {
                $harga = $bhn['harga_auto'];
            } else {
                $harga = $bhn['harga_manual'];
            }


            $data = [
                'id' => $bhn['id'],
                'satuan' => $bhn['satuan'],
                'harga' => $harga,
                'tgl_diubah' => $bhn['tgl_harga']
            ];

            if (request()->session()->get('tipe') === 'Outlet') {
                $data['disabled_order'] = '';
                $data['disabled_deliv'] = 'disabled';
                $data['disabled_arrive'] = '';
            } else {
                $data['disabled_order'] = 'disabled';
                $data['disabled_deliv'] = '';
                $data['disabled_arrive'] = 'disabled';
            }

            echo json_encode($data);
        }
    }

    function array_has_dupes($array)
    {
        return count($array) !== count(array_unique($array));
    }


    public function Input(Request $request)
    {
        if (!in_array('createOrder', $this->permission())) {
            return redirect()->to('/');
        }

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required',
                'no' => 'required',
                'outlet' => 'required'
            ],
            $messages  = [
                'required' => 'Form :attribute harus terisi',
                'same' => 'Form :attribute & :other tidak sama.',
            ]
        );

        $store_id = $request->input('outlet');

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  $message
                ];
            }
        } else {
            if ($request->session()->get('IdEditOrder')) {
                if (Order::where('id', $request->session()->get('IdEditOrder'))->count()) {
                    $orderid = $request->session()->get('IdEditOrder');
                    $tgl_laporan = $request->input('tgl_laporan');
                    Order::where('id', $orderid)->update(
                        [
                            'nama' => $request->input('nama'),
                            'users_id' => $request->session()->get('id'),
                            'store_id' =>  $store_id,
                            'tgl' => date('Y-m-d'),
                            'tgl_laporan' => $tgl_laporan,
                            'ket' => $request->input('ket'),
                            'nohp' => $request->input('no'),
                            'logistik' => $request->input('tujuan'),
                            'created_at' => date('Y-m-d H:i:s')
                        ]
                    );
                } else {
                    $tgl_laporan =  date('Y-m-d');
                    $orderid = Order::insertGetId(
                        [
                            'nama' => $request->input('nama'),
                            'users_id' => $request->session()->get('id'),
                            'store_id' =>  $store_id,
                            'tgl_laporan' =>  $tgl_laporan,
                            'tgl' => date('Y-m-d'),
                            'ket' => $request->input('ket'),
                            'nohp' => $request->input('no'),
                            'logistik' => $request->input('tujuan'),
                            'created_at' => date('Y-m-d H:i:s')
                        ]
                    );
                }
            } else {
                $tgl_laporan =  date('Y-m-d');
                $orderid = Order::insertGetId(
                    [
                        'nama' => $request->input('nama'),
                        'users_id' => $request->session()->get('id'),
                        'store_id' =>  $store_id,
                        'tgl' => date('Y-m-d'),
                        'tgl_laporan' =>  $tgl_laporan,
                        'ket' => $request->input('ket'),
                        'nohp' => $request->input('no'),
                        'logistik' => $request->input('tujuan'),
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );
            }

            if ($orderid && $tgl_laporan) {
                $request->session()->put('IdEditOrder', $orderid);
                if ($request->input('select')) {
                    if ($this->array_has_dupes($request->input('select'))) {
                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  'Nama Barang Duplikat'
                        ];
                    } else {
                        foreach ($request->input('select') as $key => $select) {
                            $inventory = Inventory::where('id', $select)->with('Bahan')->first();

                            if ($inventory['auto_harga'] == 1) {
                                $harga = $inventory['harga_auto'];
                            } else {
                                $harga = $inventory['harga_manual'];
                            }


                            if (request()->session()->get('tipe') === 'Office' or request()->session()->get('tipe') === 'Logistik') {
                                $qty_order = null;
                                $qty_deliv = $request->input('qty_deliv')[$key] ?? null;
                                $qty_arrive = $request->input('qty_arrive')[$key] ?? null;
                            } else {
                                $qty_order = $request->input('qty_deliv')[$key] ?? null;
                                $qty_deliv = null;
                                $qty_arrive = null;
                            }


                            $input = [
                                'users_id' => $request->session()->get('id'),
                                'store_id' =>  $store_id,
                                'order_id' => $orderid,
                                'satuan' => $inventory['satuan'],
                                'logistik' => $request->input('tujuan'),
                                'bahan_id' => $inventory['bahan_id'],
                                'tgl' => $tgl_laporan,
                                'nama' => $inventory['bahan']->nama,
                                'qty_order' => $qty_order,
                                'qty_deliv' => $qty_deliv,
                                'qty_arrive' => $qty_arrive,
                                'harga' => $harga,
                                'created_at' => date('Y-m-d H:i:s')
                            ];
                            $input2 = [
                                'users_id' => $request->session()->get('id'),
                                'store_id' =>  $store_id,
                                'order_id' => $orderid,
                                'satuan' => $inventory['satuan'],
                                'logistik' => $request->input('tujuan'),
                                'bahan_id' => $inventory['bahan_id'],
                                'tgl' => $tgl_laporan,
                                'nama' => $inventory['bahan']->nama,
                                'qty_order' => $qty_order,
                                'qty_deliv' => $qty_deliv,
                                'qty_arrive' => $qty_arrive,
                                'harga' => $harga
                            ];

                            $id = $request->input('id')[$key] ?? 0;

                            if (!$id) {
                                if ($idorderitem = Order_Item::insertGetId($input)) {
                                    $data = [
                                        'toast' => true,
                                        'status' => 'success',
                                        'pesan' => 'Autosave Berhasil',
                                        'id' => $idorderitem,
                                        'row' => $request->input('key')[$key]
                                    ];
                                } else {
                                    $data = [
                                        'toast' => true,
                                        'status' => 'error',
                                        'pesan' =>  'Terjadi kegagalan system'
                                    ];
                                };
                            } else {
                                if (Order_Item::where('id', $id)->update($input2)) {
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
                            }
                        }
                    }
                } else {
                    $data = [
                        'toast' => true,
                        'status' => 'success',
                        'pesan' => 'Autosave Berhasil'
                    ];
                }
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Terjadi kegagalan system'
                ];
            }
        }



        echo json_encode($data);
    }



    public function Hapus(Request $request)
    {
        if (!in_array('deleteOrder', $this->permission())) {
            return redirect()->to('/');
        }

        $id =  $request->input('id');
        if (Order_Item::where('id', $id)->delete()) {
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
        $this->data['subtitle'] = 'Olahan';
        $this->subtitle = $this->data['subtitle'];

        $result = array('data' => array());
        $Data = Olahan::where('delete', false)->with('Bahan')->latest()->get();
        foreach ($Data as $value) {

            $id = session('IdOlahan');
            if ($id != $value['id']) {
                $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

                if (in_array('updateMaster', $this->permission())) {
                    $button .= "<li><a class='dropdown-item' href='Olahan/SessionCreate?id=" . $value['id'] . "'><i class='fas fa-pencil-alt'></i> Edit</a></li>";
                }
                if (in_array('deleteMaster', $this->permission())) {
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
}
