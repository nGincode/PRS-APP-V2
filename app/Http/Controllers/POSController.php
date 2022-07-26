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
use App\Models\Inventory;
use App\Models\Olahan;
use App\Models\Satuan;
use App\Models\OpnameStock;
use App\Models\POS;
use App\Models\POSBill;
use App\Models\POSBillItem;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class POSController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'POS';
        $this->data['subtitle'] = '';
        $this->title = $this->data['title'];
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }
    public function index(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewPOS', $this->permission())) {
            return redirect()->to('/');
        }

        $this->data['item'] = Inventory::where('store_id', $request->session()->get('store_id'))->with('Bahan')->where('delete', false)->get();


        return view('POS', $this->data);
    }

    public function pilih(Request $request)
    {
        if (!in_array('viewPOS', $this->permission())) {
            return redirect()->to('/');
        }
        $bahan_id = $request->input('bahan');
        $inventory_id = $request->input('id');
        $id_store = request()->session()->get('store_id');
        $id_users = request()->session()->get('id');

        $inventory = Inventory::where('id', $inventory_id)->first();

        $cek = POS::where('inventory_id', $inventory_id)->first();

        if ($inventory_id && $bahan_id) {
            if ($cek) {
                POS::where('inventory_id', $inventory_id)->update([
                    'qty' => 1 + $cek['qty'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                if ($inventory['auto_harga']) {
                    $harga = $inventory['harga_auto'];
                } else {
                    $harga = $inventory['harga_manual'];
                }
                POS::insert([
                    'users_id' => $id_users,
                    'store_id' => $id_store,
                    'inventory_id' => $inventory_id,
                    'bahan_id' => $bahan_id,
                    'qty' => 1,
                    'satuan' => $inventory['satuan'],
                    'harga' => $harga,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        $dtpos = POS::all();
        $jumlah = 0;
        foreach ($dtpos as $key => $value) {
            $jumlah += $value['qty'] * $value['harga'];
        }

        echo json_encode($this->rupiah($jumlah));
    }


    public function Totalbill(Request $request)
    {
        if (!in_array('viewPOS', $this->permission())) {
            return redirect()->to('/');
        }
        $dtpos = POS::all();
        $jumlah = 0;
        foreach ($dtpos as $key => $value) {
            $jumlah += $value['qty'] * $value['harga'];
        }

        echo json_encode(['rp' => $this->rupiah($jumlah), 'no' => $jumlah]);
    }

    public function layar(Request $request)
    {

        if (!in_array('viewPOS', $this->permission())) {
            return redirect()->to('/');
        }

        $pos = POS::where('store_id', $request->session()->get('store_id'))->with('Bahan')->get();



        foreach ($pos as $key => $value) {
            echo  $data = ' <div>
                <div class="float-right">

                    <button class="btn btn-danger btn-sm"  onclick="positemhapus(' . $value['id'] . ')">
                    <i class="fa fa-trash"></i>
                    </button>
                </div>
                <p style="float:right"><b>' . $this->rupiah($value['qty'] * $value['harga']) . ' &nbsp</b></p>
                 <h5 class="card-title">' . $value['bahan']->nama . ' x' . $value['qty'] . '</h5>
                <p class="card-text" style="margin-bottom:2px">' . $this->rupiah($value['harga']) . '</p>
                    <div style="float: right;margin-top: -1.5rem;">
                    <button class="btn btn-warning btn-sm" id="TblMinus_' . $value['id'] . '"  onclick="positemminus(' . $value['id'] . ')">
                    <i class="fa fa-minus"></i>
                    </button>
                    
                    <button class="btn btn-success btn-sm" id="TblPlus_' . $value['id'] . '"  onclick="positemplus(' . $value['id'] . ')">
                    <i class="fa fa-plus"></i>
                    </button>
                    </div>
                <hr>
                
                </div>';
        }
    }


    public function Search(Request $request)
    {
        if (!in_array('viewPOS', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');
        if ($id) {

            $cek = Inventory::count();

            if ($cek) {
                $pos = Inventory::search($id)->where('delete', false)->get()->toArray();
                $data = '';
                foreach ($pos as $key => $v) {

                    $bahan = Bahan::where('id', $v['bahan_id'])->first();
                    if (!$bahan->delete) {
                        $data .= '<div class="item" id="pilihan_' . $v['id'] . '"
                                            onclick="pilih(' . $v['id'] . ',' . $v['bahan_id'] . ')">
                                            <div class="float-right"><b>';
                        if ($v['qty'] < 5) {
                            $data .= '<i class="fa fa-exclamation-triangle"></i>';
                        }
                        $data .= $v['qty'] . ' ' . $v['satuan'];

                        if ($v['auto_harga']) {
                            $harga = $v['harga_auto'];
                        } else {
                            $harga = $v['harga_manual'];
                        }

                        $data .= '</b> </div> <h5 class="card-title"><b>' . $bahan['nama'] . '</b></h5>
                                            <p class="card-text">' . 'Rp ' . number_format($harga, 0, ',', '.') . '</p>
                                            <hr>
                                        </div>';
                    }
                }
                if ($data) {
                    echo $data;
                } else {
                    echo 'Tidak Ditemukan';
                }
            } else {
                echo 'Tidak Ditemukan';
            }
        } else {
            $data = '';

            $item = Inventory::where('store_id', $request->session()->get('store_id'))->with('Bahan')->where('delete', false)->get();


            foreach ($item as $key => $v) {
                if (!$v['bahan']->delete) {
                    $data .= '<div class="animate__animated animate__backInDown animate__faster item" id="pilihan_' . $v['id'] . '"
                                            onclick="pilih(' . $v['id'] . ',' . $v['bahan_id'] . ')">
                                            <div class="float-right"><b>';

                    if ($v['qty'] < 5) {
                        $data .= '<i class="fa fa-exclamation-triangle"></i>';
                    }

                    if ($v['auto_harga']) {
                        $harga = $v['harga_auto'];
                    } else {
                        $harga = $v['harga_manual'];
                    }

                    $data .= $v['qty'] . ' ' . $v['satuan'];
                    $data .= '</b> </div> <h5 class="card-title"><b>' . $v['bahan']->nama . '</b></h5>
                                            <p class="card-text">' . 'Rp ' . number_format($harga, 0, ',', '.') . '</p>
                                            <hr>
                                        </div>';
                }
            }

            if ($data) {
                echo $data;
            } else {
                echo 'Tidak Ditemukan';
            }
        }
    }


    public function positemhapus(Request $request)
    {
        if (!in_array('viewPOS', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->input('id');
        if (POS::where('id', $id)->delete()) {
            $data = [
                'toast' => true,
                'status' => 'success',
                'pesan' =>  'Berhasil Menghapus'
            ];
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Gagal Menghapus Data' . $id
            ];
        };
        echo json_encode($data);
    }


    public function positemplus(Request $request)
    {
        if (!in_array('viewPOS', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->input('id');

        $data = POS::where('id', $id)->first();

        if (POS::where('id', $id)->update(['qty' => $data['qty'] + 1])) {
            echo json_encode([]);
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Gagal Menambah Data ' . $id
            ];
            echo json_encode($data);
        };
    }


    public function positemminus(Request $request)
    {
        if (!in_array('viewPOS', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->input('id');

        $data = POS::where('id', $id)->first();

        if ($data) {
            if ($data['qty'] <= 1) {
                echo json_encode([]);
            } else {
                if (POS::where('id', $id)->update(['qty' => $data['qty'] - 1])) {
                    echo json_encode([]);
                } else {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Gagal Mengurangi Data ' . $id
                    ];
                    echo json_encode($data);
                };
            }
        }
    }


    public function Input(Request $request)
    {

        if (!in_array('createPOS', $this->permission())) {
            redirect('dashboard', 'refresh');
        }

        $pengorder = $request->input('pengorder');
        $no = $request->input('no');
        $jumlah = $request->input('jumlah');
        $duit = $request->input('duit');

        $id_store = request()->session()->get('store_id');


        $dtpos = POS::with('Bahan', 'Inventory')->get();
        $jumlahbelanja = 0;
        foreach ($dtpos as $value) {
            $jumlahbelanja += $value['qty'] * $value['harga'];
        }

        if ($jumlah) {
            $jumlahqty = $jumlah;
        } else {
            $jumlahqty = $duit;
        }

        if ($jumlahbelanja <= $jumlahqty) {
            $bill_no = 'BILL-' . $id_store . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
            $data = [
                'users_id' => $request->session()->get('id'),
                'store_id' => $id_store,
                'tgl' => date('Y-m-d H:i:s'),
                'no_bill' => $bill_no,
                'no_hp' => $no,
                'nama_bill' => $pengorder,
                'gross_total' => $jumlahbelanja,
                'disc' => null,
                'tax' => null,
                'paid' => 1,
                'total' => $jumlahbelanja,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($id = POSBill::insertGetId($data)) {

                $dataitem = [];
                foreach ($dtpos as $value1) {
                    $dataitem[] = [
                        'users_id' => $request->session()->get('id'),
                        'store_id' => $id_store,
                        'posbill_id' => $id,
                        'bahan_id' => $value1['bahan_id'],
                        'tgl' => date('Y-m-d'),
                        'nama' => $value1['bahan']->nama,
                        'qty' => $value1['qty'],
                        'satuan' => $value1['satuan'],
                        'harga' => $value1['harga'],
                        'total' => $value1['qty'] * $value1['harga'],
                        'paid' => 1,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }

                $kembalian = $this->rupiah($jumlahqty - $jumlahbelanja);

                if (POSBillItem::insert($dataitem)) {

                    foreach ($dtpos as $value2) {
                        $dtinven = Inventory::where('bahan_id', $value2['bahan_id'])->first();
                        if ($dtinven) {
                            $qty = $dtinven['qty'] - $value2['qty'];
                            Inventory::where('bahan_id', $value2['bahan_id'])->update(['qty' => $qty]);
                        }
                    }
                    POS::where('store_id', $id_store)->delete();
                    $data = [
                        'kembalian' => $kembalian,
                        'id' => $id
                    ];
                }
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Pembayaran Tidak Mencukupi'
                ];
            };
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Pembayaran Tidak Mencukupi'
            ];
        }
        echo json_encode($data);
    }


    public function Manage(Request $request)
    {
        if (!in_array('viewPOS', $this->permission())) {
            return redirect()->to('/');
        }
        $result = array('data' => array());
        $id_store = request()->session()->get('store_id');

        if ($tgl = $request->input('tgl')) {
            $tgl_awal = date('Y-m-d', strtotime(explode(" - ", $tgl)[0]));
            $tgl_akhir = date('Y-m-d', strtotime("+1 day", strtotime(explode(" - ", $tgl)[1])));
        } else {
            $tgl_awal = date('Y-m-d', strtotime("-30 day", strtotime(date("Y-m-d"))));
            $tgl_akhir = date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))));
        }

        if (request()->session()->get('tipe') === 'Office' or request()->session()->get('tipe') === 'Logistik') {
            if (is_numeric($filter = $request->input('filter'))) {
                $Data = POSBill::where('store_id', $filter)->whereBetween('tgl', [$tgl_awal, $tgl_akhir])->orderBy('id', 'DESC')->get();
            } else {
                $Data = POSBill::whereBetween('tgl', [$tgl_awal, $tgl_akhir])->orderBy('id', 'DESC')->get();
            }
        } else {
            if (is_numeric($filter = $request->input('filter'))) {
                $Data = POSBill::where('store_id', $filter)->whereBetween('tgl', [$tgl_awal, $tgl_akhir])->orderBy('id', 'DESC')->get();
            } else {
                $Data = POSBill::where('store_id', $id_store)->whereBetween('tgl', [$tgl_awal, $tgl_akhir])->orderBy('id', 'DESC')->get();
            }
        }



        foreach ($Data as $key => $value) {
            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';
            $button .= "<li><a class='dropdown-item' onclick='Print(" . $value['id'] . "," . '"' . $this->title . '"' . ")' style='cursor:pointer'><i class='fas fa-print'></i> Print</a></li>";

            if (in_array('viewPOS', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='lihat(" . $value['id'] . "," . '"' . $this->title . '"' . ")' data-toggle='modal' data-target='#lihat' href='#'><i class='fas fa-eye'></i> Lihat</a></li>";
            }

            $button .= '</ul></div>';

            if ($value['paid'] == 1) {
                $paid = '<span class="badge badge-success">Paid</span>';
            } else {
                $paid = '<span class="badge badge-danger">Unpaid</span>';
            }

            if ($value['nama_bill']) {
                $nama_bill = $value['nama_bill'];
            } else {
                $nama_bill = '-';
            }


            if ($value['no_hp']) {
                $no_hp = $value['no_hp'];
            } else {
                $no_hp = '-';
            }

            $result['data'][$key] = array(
                $this->tanggal($value['tgl']),
                $value['no_bill'],
                $nama_bill,
                $no_hp,
                $this->rupiah($value['total']),
                $paid,
                $button
            );
        }
        echo json_encode($result);
    }

    public function LihatBill(Request $request)
    {
        if (!in_array('viewPOS', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->input('id');
        $judul = $request->input('judul');
        $id_store = request()->session()->get('store_id');

        $variable = POSBillItem::where('store_id', $id_store)->where('posbill_id', $id)->get();
        $bill = POSBill::where('id', $id)->first();

        $html = ' 
        <h5 style="float:right"><b>' . $bill['no_bill'] . '</b></h5>
        <h6><b>' . $this->tanggal($bill['tgl']) . '</b></h6>
        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>';

        foreach ($variable as $key => $value) {
            $html .= '
                    <tr>
                        <td>' . $value['nama'] . '</td>
                        <td>' . $value['qty'] . ' ' . $value['satuan'] . '</td>
                        <td>' . $this->rupiah($value['harga']) . '</td>
                        <td>' . $this->rupiah($value['qty'] * $value['harga']) . '</td>
                    </tr>
                       
            ';
        }
        $html .= '
                        <tr style="background-color:#607d8b7a;">
                            <td colspan="3"><b>Total</b> </td>
                            <td><b>' . $this->rupiah($bill['total']) . '</b></td>
                        </tr>
                        </table>';

        echo $html;
    }

    public function Print(Request $request)
    {
        if (!in_array('viewPOS', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->input('id');

        $BillItem = POSBillItem::where('posbill_id', $id)->get();
        $Bill = POSBill::where('id', $id)->first();

        $store = Store::where('id', $request->session()->get('store_id'))->first();

        $html = '';
        if ($BillItem && $Bill) {
            $jumlah = 0;
            $html .= '<div class="wrapper" style="width: 55mm;height:unset;font-size: 12px;">
                    <div style="border-bottom:dashed 1px black;">
                    <center >
                    <h5><b>' . $request->session()->get('store') . '</b></h5>
                    ' . $store['alamat'] . '<br>' . $store['wa'] . '
                    </center>
                    </div>
                    <div style="padding-left: 5px; border-bottom:solid 1px black;">
                        <p style="float:right">' . $this->tanggal($Bill['tgl'], true) . '</p>
                        <br> No Bill : ' . $Bill['no_bill'] . ' 
                        <br>A/N     : ' . $Bill['nama_bill'] . ' 
                        <br>No Hp   : ' . $Bill['no_hp'] . ' 
                    </div>
                    <div style="padding-left:5px;margin-top:5px;border-bottom:solid 1px black;">
            ';
            foreach ($BillItem as $key => $value) {
                $jumlah += $value['qty'] * $value['harga'];
                $html .=
                    $value['nama'] . '<br>'  . '<font style="float:right">' . $this->rupiah($value['qty'] * $value['harga']) . '</font>' . $value['qty'] . ' x ' . $this->rupiah($value['harga']) . '<br>';
            }
            $html .= '</div>

            <div style="padding-left: 5px;margin-top:5px;border-bottom:solid 1px black;">
            <b>
            Jumlah
            <font style="float:right">' . $this->rupiah($jumlah) . '</font><br>
            </b>
            Disc
            <font style="float:right">' . 0 . '</font><br>
            Tax
            <b>
            <font style="float:right">' . 0 . '</font><br>
            Total 
            <font style="float:right">' . $this->rupiah($jumlah) . '</font>
            </b>
            </div>
            <div style="float:left;text-align: center;padding-left: 5px;">
            Pengirim<br><br><br>_________
            </div> 
            
            <div style="float:right;text-align: center;padding-left: 5px">
            Penerima<br><br><br>_________
            </div>
            <br>
            <br>
            <br>
            <br>
            <div style="padding-left: 5px">
			Note:<div style=" border: 1px solid;height: 60px;border-radius: 0px 10px;"></div>
            </div>
            </div>
            ';
        }
        echo $html;
    }
}
