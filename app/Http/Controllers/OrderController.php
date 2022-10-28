<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Belanja;
use App\Models\Store;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\POS;
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

        if (request()->session()->get('tipe') === 'Logistik') {
            Orderitem::where('logistik', request()->session()->get('store_id'))->update(['view' => true]);
        }


        $this->data['store'] = store::where('tipe', 'Outlet')->where('active', true)->get();
        $this->data['logistik'] = store::where('tipe', 'Logistik')->where('active', true)->get();
        $this->data['order'] = order::with('users')->where('id', $request->session()->get('IdEditOrder'))->first();
        $this->data['order_item'] = Orderitem::where('order_id', $request->session()->get('IdEditOrder'))->get();
        if ($this->data['order']) {
            $this->data['item'] = Inventory::where('store_id', $this->data['order']['logistik'])->where('delete', false)->with('Bahan')->get();
            if ($this->data['order']['users']->id == request()->session()->get('id')) {
                $this->data['pemilik_order'] = true;
            } else {
                $this->data['pemilik_order'] = false;
            }
        } else {
            $this->data['pemilik_order'] = true;
        }
        if (isset($this->data['order']['up'])) {
            if ($this->data['order']['up']) {
                $this->data['up'] = true;
            } else {

                $this->data['up'] = false;
            }
        } else {
            $this->data['up'] = false;
        }
        if (isset($this->data['order']['logistik'])) {
            if ($this->data['order']['logistik']) {
                $this->data['logistik_id'] = true;
            } else {

                $this->data['logistik_id'] = false;
            }
        } else {
            $this->data['logistik_id'] = false;
        }
        Orderitem::where('logistik', $request->session()->get('id'))->update(['view' => true]);
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
                    $data['disabled_arrive'] = 'disabled';
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
                $data['disabled_arrive'] = 'disabled';
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
                'nama' => 'required'
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
            if ($request->input('tgl_laporan')) {
                $tgl_laporan = $request->input('tgl_laporan');
            } else {
                $tgl_laporan = false;
            }

            if ($request->input('tujuan')) {
                $tujuan = $request->input('tujuan');
            } else {
                $tujuan = false;
            }

            if ($request->session()->get('tipe') == 'Outlet') {
                $store_id = $request->session()->get('store_id');
            } else {
                if ($request->input('outlet')) {
                    $store_id = $request->input('outlet');
                } else {
                    if ($orderData = Order::where('id', $request->session()->get('IdEditOrder'))->first()) {
                        $store_id = $orderData['store_id'];
                    }
                }
            }

            $ordercount = Order::where('tgl', date('Y-m-d'))->count() + 1;
            if ($request->session()->get('IdEditOrder')) {
                if (Order::where('id', $request->session()->get('IdEditOrder'))->count()) {
                    $orderid = $request->session()->get('IdEditOrder');
                    if ($tgl_laporan) {
                        if ($tujuan) {
                            Order::where('id', $orderid)->update(
                                [
                                    'nama' => $request->input('nama'),
                                    'tgl_laporan' => $tgl_laporan,
                                    'ket' => $request->input('ket'),
                                    'nohp' => $request->input('no'),
                                    'logistik' => $request->input('tujuan')
                                ]
                            );
                        } else {
                            Order::where('id', $orderid)->update(
                                [
                                    'nama' => $request->input('nama'),
                                    'tgl_laporan' => $tgl_laporan,
                                    'ket' => $request->input('ket'),
                                    'nohp' => $request->input('no')
                                ]
                            );
                        }
                    } else {
                        if ($tujuan) {
                            Order::where('id', $orderid)->update(
                                [
                                    'nama' => $request->input('nama'),
                                    'ket' => $request->input('ket'),
                                    'nohp' => $request->input('no'),
                                    'logistik' => $request->input('tujuan')
                                ]
                            );
                        } else {
                            Order::where('id', $orderid)->update(
                                [
                                    'nama' => $request->input('nama'),
                                    'ket' => $request->input('ket'),
                                    'nohp' => $request->input('no')
                                ]
                            );
                        }
                    }
                } else {
                    $orderid = Order::insertGetId(
                        [
                            'nama' => $request->input('nama'),
                            'users_id' => $request->session()->get('id'),
                            'bill' =>  $store_id . $request->session()->get('id') .  date('ymd') . $ordercount,
                            'store_id' =>  $store_id,
                            'tgl_laporan' => $tgl_laporan ? $tgl_laporan : date('Y-m-d'),
                            'tgl' => date('Y-m-d'),
                            'ket' => $request->input('ket'),
                            'nohp' => $request->input('no'),
                            'logistik' => $request->input('tujuan'),
                            'created_at' => date('Y-m-d H:i:s')
                        ]
                    );
                }
            } else {
                $orderid = Order::insertGetId(
                    [
                        'nama' => $request->input('nama'),
                        'users_id' => $request->session()->get('id'),
                        'store_id' =>  $store_id,
                        'bill' =>  $store_id . $request->session()->get('id') . date('ymd') .  $ordercount,
                        'tgl' => date('Y-m-d'),
                        'tgl_laporan' => $tgl_laporan ? $tgl_laporan : date('Y-m-d'),
                        'ket' => $request->input('ket'),
                        'nohp' => $request->input('no'),
                        'logistik' => $request->input('tujuan'),
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );
            }

            if ($orderid) {
                $request->session()->put('IdEditOrder', $orderid);
                $DataOrder = Order::where('id', $orderid)->first();
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
                            $Orderitem = Orderitem::where('order_id', $orderid)->where('bahan_id', $inventory['bahan_id'])->first();
                            if ($inventory) {
                                if ($inventory['auto_harga'] == 1) {
                                    $harga = $inventory['harga_auto'];
                                } else {
                                    $harga = $inventory['harga_manual'];
                                }

                                if ($request->input('qty_order')[$key] == 'false') {
                                    if (isset($Orderitem['qty_order'])) {
                                        $qty_order = $Orderitem['qty_order'];
                                    } else {
                                        $qty_order = null;
                                    }
                                } else {
                                    $qty_order = $request->input('qty_order')[$key] != 'false' ? $request->input('qty_order')[$key] : null;
                                }

                                if ($request->input('qty_deliv')[$key] == 'false') {
                                    if (isset($Orderitem['qty_deliv'])) {
                                        $qty_deliv = $Orderitem['qty_deliv'];
                                    } else {
                                        $qty_deliv = null;
                                    }
                                } else {
                                    $qty_deliv = $request->input('qty_deliv')[$key]  != 'false' ? $request->input('qty_deliv')[$key] :  null;
                                }

                                if ($request->input('qty_arrive')[$key] == 'false') {
                                    if (isset($Orderitem['qty_arrive'])) {
                                        $qty_arrive = $Orderitem['qty_arrive'];
                                    } else {
                                        $qty_arrive = null;
                                    }
                                } else {
                                    $qty_arrive = $request->input('qty_arrive')[$key]  != 'false' ? $request->input('qty_arrive')[$key] : null;
                                }


                                if (request()->session()->get('tipe') === 'Logistik') {
                                    $input = [
                                        'satuan' => $inventory['satuan'],
                                        'logistik' => ($request->input('tujuan') ?? $DataOrder['logistik']),
                                        'bahan_id' => $inventory['bahan_id'],
                                        'tgl' => $DataOrder['tgl_laporan'],
                                        'nama' => $inventory['bahan']->nama,
                                        'qty_deliv' => $qty_deliv,
                                        'harga' => $harga
                                    ];
                                } else {
                                    $input = [
                                        'qty_arrive' => $qty_arrive,
                                        'qty_order' => $qty_order,
                                        'logistik' => ($request->input('tujuan') ?? $DataOrder['logistik']),
                                        'bahan_id' => $inventory['bahan_id'],
                                        'nama' => $inventory['bahan']->nama

                                    ];
                                }

                                $id = $request->input('id')[$key] ?? 0;

                                if (!$id) {
                                    if ($idorderitem = Orderitem::insertGetId([
                                        'users_id' => $request->session()->get('id'),
                                        'store_id' =>  $store_id,
                                        'order_id' => $orderid,
                                        'satuan' => $inventory['satuan'],
                                        'logistik' => ($request->input('tujuan') ?? $DataOrder['logistik']),
                                        'bahan_id' => $inventory['bahan_id'],
                                        'tgl' => $DataOrder['tgl_laporan'],
                                        'nama' => $inventory['bahan']->nama,
                                        'qty_order' => $qty_order,
                                        'qty_deliv' => $qty_deliv,
                                        'qty_arrive' => $qty_arrive,
                                        'harga' => $harga,
                                        'created_at' => date('Y-m-d H:i:s')
                                    ])) {
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
                                    if (Orderitem::where('id', $id)->update($input)) {
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
                            } else {
                                $data = [
                                    'toast' => true,
                                    'status' => 'error',
                                    'pesan' =>  'id ' . $select . ' Tak ditemukan'
                                ];
                            }
                        }
                    }
                } else {
                    $data = [
                        'toast' => true,
                        'status' => 'success',
                        'pesan' => 'Autosave Berhasil',
                        'isiitem' => true
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

    public function RemoveSessionEdit(Request $request)
    {
        if ($request->session()->get('IdEditOrder')) {
            $request->session()->forget('IdEditOrder');
            $data = [
                'toast' => true,
                'status' => 'success',
                'pesan' => 'Berhasil Keluar Dari Edit'
            ];
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Edit tidak ditemukan'
            ];
        }
        echo json_encode($data);
    }

    public function SessionEdit(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            $request->session()->put('IdEditOrder', $id);
            $data = [
                'toast' => true,
                'status' => 'info',
                'pesan' => 'Mengambil Data Edit'
            ];
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Edit tidak ditemukan'
            ];
        }
        echo json_encode($data);
    }

    public function Upload(Request $request)
    {
        $id = $request->input('id');
        $Order = Order::where('id', $id)->with('Orderitem')->first();

        if ($Order) {
            $pesan = '';
            if (isset($Order['Orderitem'][0])) {
                foreach ($Order['Orderitem'] as $key => $value) {
                    if (!$value['up']) {
                        $inventory = Inventory::where('bahan_id', $value['bahan_id'])->first();
                        if ($inventory && $value['qty_deliv'] != null) {
                            $qty = $inventory['qty'];
                            $jumlah = $qty - $value['qty_deliv'];

                            if ($inventory['auto_harga'] == 1) {
                                $harga = $inventory['harga_auto'];
                            } else {
                                $harga = $inventory['harga_manual'];
                            }

                            if (Inventory::where('id', $inventory['id'])->update([
                                'qty' => $jumlah,
                            ])) {
                                Orderitem::where('id', $value['id'])->update(['up' => true, 'harga' =>  $harga]);
                            } else {
                                $pesan .= $value['nama'] . ' Tidak dapat diupload <br>';
                            }
                        } else {
                            $pesan .= $value['nama'] . ' Tidak dapat diupload <br>';
                        }
                    } else {
                        $pesan .= $value['nama'] . ' Telah diupload <br>';
                    }
                }
                if ($pesan) {
                    Order::where('id', $id)->update(['up' => true]);
                    $data = [
                        'toast' => true,
                        'status' => 'info',
                        'pesan' =>  $pesan
                    ];
                } else {
                    Order::where('id', $id)->update(['up' => true]);
                    $data = [
                        'toast' => true,
                        'status' => 'info',
                        'pesan' =>  'Berhasil di upload dengan aman'
                    ];
                }
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Tidak Ada Item'
                ];
            }
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Terjadi kegagalan system'
            ];
        }

        echo json_encode($data);
    }

    public function UpRepair(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        $data = [];
        if ($status == 'Hapus') {
            if (Orderitem::where('id', $id)->delete()) {
                $data = [
                    'toast' => true,
                    'status' => 'success',
                    'pesan' =>  'Berhasil di Hapus'
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Gagal di Hapus'
                ];
            }
        }

        if ($status == 'Upload') {
            if ($order = Orderitem::where('id', $id)->first()) {
                $ivn = Inventory::where('bahan_id', $order['bahan_id'])->first();
                if ($ivn && $order['qty_deliv'] != null) {
                    $qty = $ivn['qty'] - $order['qty_deliv'];
                    if (Inventory::where('id', $ivn['id'])->update([
                        'qty' => $qty
                    ])) {
                        Orderitem::where('id', $id)->update([
                            'up' => true
                        ]);
                        $data = [
                            'toast' => true,
                            'status' => 'success',
                            'pesan' =>  'Berhasil di Upload'
                        ];
                    } else {
                        $data = [
                            'toast' => true,
                            'status' => 'error',
                            'pesan' =>  'Gagal di Upload'
                        ];
                    }
                } else {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Gagal di Upload Qty Deliv Kosong'
                    ];
                }
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Order Tidak ditemukan'
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
        $order = Orderitem::where('id', $id)->first();
        if (Orderitem::where('id', $id)->delete()) {
            if ($order) {
                if (Orderitem::where('order_id', $order['order_id'])->first()) {
                    $item = true;
                } else {
                    $item = false;
                }
            } else {
                $item = false;
            }
            $data = [
                'toast' => true,
                'status' => 'success',
                'pesan' => 'Berhasil Terhapus',
                'item' =>  $item
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


    public function LihatBill(Request $request)
    {
        if (!in_array('viewOrder', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->input('id');
        $judul = $request->input('judul');
        $id_store = request()->session()->get('store_id');

        $variable = Orderitem::where('order_id', $id)->get();
        $bill = Order::with('Users')->where('id', $id)->first();

        $html = ' 
        <h5 style="float:right"><b>Bill ' . '#' . $bill['bill'] . '</b></h5>
        <h6><b>' . $this->tanggal($bill['tgl'], true) . '</b></h6>
        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Qty Order</th>
                                    <th>Qty Deliv</th>
                                    <th>Qty Arrive</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>';

        $total = 0;
        foreach ($variable as $key => $value) {
            $qty = 0;
            if ($value['qty_deliv'] !== null) {
                $totalitem = $value['qty_deliv'] * $value['harga'];
                $qty += $value['qty_deliv'];
            } else {
                $totalitem = $value['qty_order'] * $value['harga'];
                $qty += $value['qty_order'];
            }
            $html .= '
                    <tr>
                        <td>' . $value['nama'] . '</td>
                        <td>' . ($value['qty_order'] ?? 0) . ' ' . $value['satuan'] . '</td>
                        <td>' . ($value['qty_deliv'] ?? 0) . ' ' . $value['satuan'] . '</td>
                        <td>' . ($value['qty_arrive'] ?? 0) . ' ' . $value['satuan'] . '</td>
                        <td>' . $this->rupiah($value['harga']) . '</td>
                        <td>' . $this->rupiah($totalitem) . '</td>
                    </tr>
                       
            ';
            $total += $totalitem;
        }
        $html .= '
                        <tr style="background-color:#607d8b7a;">
                            <td colspan="5"><b>Total</b> </td>
                            <td><b>' . $this->rupiah($total) . '</b></td>
                        </tr>
                        </table><br>
                        Ket :<br>
                        <font color="red">*</font> Order Ini dibuat Oleh Username ' . $bill['users']->username . '
                        ';

        echo $html;
    }

    public function Manage(Request $request)
    {
        if (!in_array('viewOrder', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['subtitle'] = 'Order';
        $this->subtitle = $this->data['subtitle'];
        $id_store = request()->session()->get('store_id');

        $result = array('data' => array());


        if ($date = $request->input('tgl')) {
            $tgl_awal = date('Y-m-d', strtotime(explode(" - ", $date)[0]));
            $tgl_akhir = date('Y-m-d', strtotime(explode(" - ", $date)[1]));
        } else {
            $tgl_awal = date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
            $tgl_akhir = date('Y-m-d', strtotime(date("Y-m-d")));
        }

        if (request()->session()->get('tipe') === 'Office' or request()->session()->get('tipe') === 'Logistik') {
            if (is_numeric($filter = $request->input('filter'))) {
                $Data = Order::with('Orderitem')->where('store_id', $filter)->whereBetween('tgl', [$tgl_awal, $tgl_akhir])->orderBy('id', 'DESC')->get();
            } else {
                $Data = Order::with('Orderitem')->whereBetween('tgl', [$tgl_awal, $tgl_akhir])->orderBy('id', 'DESC')->get();
            }
        } else {
            if (is_numeric($filter = $request->input('filter'))) {
                $Data = Order::with('Orderitem')->where('store_id', $filter)->whereBetween('tgl', [$tgl_awal, $tgl_akhir])->orderBy('id', 'DESC')->get();
            } else {
                $Data = Order::with('Orderitem')->where('store_id', $id_store)->whereBetween('tgl', [$tgl_awal, $tgl_akhir])->orderBy('id', 'DESC')->get();
            }
        }

        if ($Data) {
            foreach ($Data as $key => $value) {

                $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

                if (in_array('viewOrder', $this->permission())) {
                    if ($request->session()->get('tipe') === 'Logistik') {
                        $button .= "<li><a class='dropdown-item' onclick='KePOS(" . '"' . $value['id'] . '"' . "," . '"' . $this->title . '"' . ")'  ><i class='fas fa-download'></i> Tranfer Ke POS</a></li>";
                    }

                    $button .= "<li><a class='dropdown-item' onclick='Lihat(" . '"' . $value['id'] . '"' . "," . '"' . $this->title . '"' . ")' data-toggle='modal' data-target='#lihat' ><i class='fas fa-eye'></i> Lihat</a></li>";
                }
                if (in_array('updateOrder', $this->permission())) {
                    $button .= "<li><a class='dropdown-item' onclick='OrderEdit(" . '"' . $value['id'] . '"' . "," . '"' . $this->title . '"' . ")'><i class='fas fa-pencil-alt'></i> Edit</a></li>";
                }


                $button .= '</ul></div>';

                $jumlah = 0;

                $status_view = false;
                $status_deliv = false;
                $status_arrive = false;
                if ($value['Orderitem']) {
                    foreach ($value['Orderitem'] as $v) {
                        if ($v['qty_deliv']) {
                            $qty = $v['qty_deliv'];
                            $status_deliv = true;
                        } else {
                            $qty = $v['qty_order'];
                        }

                        if ($v['qty_arrive']) {
                            $status_arrive = true;
                        }


                        if ($v['view']) {
                            $status_view = true;
                        }

                        $jumlah += $qty * $v['harga'];
                    }
                }

                if ($status_deliv) {
                    $deliv = ' <span class="badge badge-success" data-toggle="tooltip" data-placement="top"  title="Telah Sampai"><i class="fa fa-truck"></i></span>';
                } else {
                    $deliv = ' <span class="badge badge-light" data-toggle="tooltip" data-placement="top"  title="Belum Diantar"><i class="fa fa-truck"></i></span>';
                }

                if ($status_arrive) {
                    $arrive = ' <span class="badge badge-success" data-toggle="tooltip" data-placement="top"  title="Sampai"><i class="fa fa-home"></i></span>';
                } else {
                    $arrive = ' <span class="badge badge-light" data-toggle="tooltip" data-placement="top"  title="Belum Sampai"><i class="fa fa-home"></i></span>';
                }

                if ($status_view) {
                    $view = ' <span class="badge badge-success" data-toggle="tooltip" data-placement="top"  title="Diproses"><i class="fa fa-eye"></i></span>';
                } else {
                    $view = ' <span class="badge badge-light" data-toggle="tooltip" data-placement="top"  title="Belum Diproses"><i class="fa fa-eye"></i></span>';
                }


                if ($value['up'] == 1) {
                    $up = ' <span class="badge badge-success" data-toggle="tooltip" data-placement="top"  title="Stock Dikurangi"><i class="fa fa-upload"></i></span>';
                } else {
                    $up = ' <span class="badge badge-light" data-toggle="tooltip" data-placement="top"  title="Stock Belum Dikurangi"><i class="fa fa-upload"></i></span>';
                }

                $result['data'][$key] = array(
                    '#' . $value['bill'],
                    $value['store']->nama,
                    $this->tanggal($value['tgl'], true),
                    $value['nama'],
                    $this->rupiah($jumlah),
                    $view . $deliv . $arrive . $up,
                    $button
                );
            }
        }
        echo json_encode($result);
    }

    public function KePOS(Request $request)
    {

        $id = $request->input('id');

        $info = '';
        if ($order = Orderitem::where('order_id', $id)->with('Bahan')->get()) {
            POS::where('store_id', $request->session()->get('store_id'))->delete();

            foreach ($order as $key => $value) {
                if ($value['qty_deliv'] === null) {
                    Orderitem::where('id', $value['id'])->update(['qty_deliv' => $value['qty_order']]);
                }
                $inventory = Inventory::where('bahan_id', $value['bahan_id'])->where('store_id', $request->session()->get('store_id'))->first();

                if ($inventory['auto_harga'] == 1) {
                    $harga = $inventory['harga_auto'];
                } else {
                    $harga = $inventory['harga_manual'];
                }
                $input = [
                    'users_id' => $request->session()->get('id'),
                    'store_id' => $request->session()->get('store_id'),
                    'inventory_id' => $inventory['id'],
                    'bahan_id' => $value['bahan_id'],
                    'qty' => ($value['qty_order'] ?? $value['qty_deliv']) ?? 0,
                    'harga' => $harga,
                    'satuan' => $inventory['satuan'],
                ];

                if (!POS::create($input)) {
                    $info .= $order['Bahan']->nama . ' Gagal Masuk POS';
                }
            }

            if ($info) {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  $info
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'success',
                    'pesan' =>  'Berhasil di Tranfer'
                ];
            }
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Gagal di Tranfer'
            ];
        }

        echo json_encode($data);
    }
}
