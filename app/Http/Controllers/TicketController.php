<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Supplier;
use App\Models\Bahan;
use App\Models\Peralatan;
use App\Models\Pegawai;
use App\Models\Satuan;
use App\Models\Ticket;
use App\Models\Ticket_Tukar;

use App\Exports\PenjualanExport;
use App\Exports\BelanjaExport;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorHTML;


use App\Mail\Email;
use Illuminate\Support\Facades\Mail;

use nguyenary\QRCodeMonkey\QRCode;


class TicketController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Ticket';
        $this->title = $this->data['title'];
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }


    /////////////////////////////////// Scan //////////////////////////
    public function Scan(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewTicketScan', $this->permission())) {
            return redirect()->to('/');
        }
        $this->data['subtitle'] = 'Scan';

        return view('TicketScan', $this->data);
    }


    public function ManageScan(Request $request)
    {
        if (!in_array('viewTicketScan', $this->permission())) {
            return redirect()->to('/');
        }

        $result = array('data' => array());
        $Data = Ticket_Tukar::orderBy('id', 'DESC')->get();


        foreach ($Data as $value) {
            if ($value['claim']) {
                $claim = '<font color="green">' . $value['claim'] . '</font>';
            } else {
                $claim = '<font color="red"> Belum</font>';
            }



            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('updateTicketScan', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Edit(" . $value['id'] . "," . '"Scan"' . ")' data-toggle='modal' data-target='#Modal' ><i class='fas fa-pencil-alt'></i> Edit</a></li>";
            }

            $button .= '</ul></div>';


            $result['data'][] = array(
                ($value['pembayaran']),
                '<a href="Masuk?id=' . $value['kode'] . '">' . $value['nama'] . '</a>',
                '<a target="_blank" href="https://api.whatsapp.com/send?phone=+62' . $value['wa'] . '&text=' . url('Ticket/Masuk?id=' . $value['kode']) . '">' . $value['wa'] . '</a>',
                '<a href="#" onclick="EmailSend(' . $value['id'] . ', 1)">' . $value['email'] . '</a>',
                $value['jumlah'] . ' (' . $this->rupiah($value['harga']) . ')',
                $value['pembuat'],
                $claim,
                $value['berlaku'],
                $button
            );
        }

        echo json_encode($result);
    }

    public function CekScan(Request $request)
    {
        if (!in_array('viewTicketScan', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->input('id');

        $data = Ticket_Tukar::where('kode', $id)->with('Ticket')->first();

        $hasil = '';
        if ($data) {
            if (!$data['claim']) {
                if ($data['berlaku'] >= date('Y-m-d')) {
                    if ($data['ticket']->store_id == $request->session()->get('store_id') || $data['ticket']->store_id == null) {
                        $hasil .= ' Hasil :<br>
                            <b>' . $id . '</b><br><br>
                            Nama : <b>' . $data['nama'] . '</b> <br>
                            Jumlah Tiket : <b>' . $data['jumlah'] . '</b> <br>
                            Status : <b>
                                <font color="green">Belum Ditukar</font>
                            </b><br><br>
                            <a class="btn btn-success" onclick="tukarTicket(' . $data['id'] . ')">Gunakan</a>';
                    } else {
                        $store = Store::where('id', $data['ticket']->store_id)->first();
                        if ($store) {
                            $s = 'Hanya Dapat ditukar di ' . $store['nama'];
                        } else {
                            $s = 'Tidak dapat di tukar disini';
                        }
                        $hasil .= ' Hasil :<br>
                            <b>' . $data['kode'] . '</b><br><br>
                            Nama : <b>' . $data['nama'] . '</b> <br>
                            Jumlah Tiket : <b>' . $data['jumlah'] . '</b> <br>
                            Status : <b>
                                <font color="red">' . $s . '</font>
                            </b><br><br>';
                    }
                } else {
                    $hasil .= ' Hasil :<br>
                            <b>' . $data['kode'] . '</b><br><br>
                            Nama : <b>' . $data['nama'] . '</b> <br>
                            Jumlah Tiket : <b>' . $data['jumlah'] . '</b> <br>
                            Status : <b>
                                <font color="red">Kadaluarsa (' . $data['berlaku'] . ')</font>
                            </b><br><br>';
                }
            } else {
                $hasil .= ' Hasil :<br>
                            <b>' . $data['kode'] . '</b><br><br>
                            Nama : <b>' . $data['nama'] . '</b> <br>
                            Jumlah Tiket : <b>' . $data['jumlah'] . '</b> <br>
                            Status : <b>
                                <font color="blue">Telah ditukar</font>
                            </b><br><br>';
            }
        } else {
            $hasil .= ' Hasil :<br>
                            <b>' . $id . '</b><br><br>
                           <b><font color="red">Tidak ditemukan</font>
                            </b><br><br>';
        }


        echo $hasil;
    }

    public function EmailSend(Request $request)
    {

        $id = $request->input('id');
        $Ticket_Tukar = Ticket_Tukar::where('id', $id)->with('Ticket')->first();
        if ($Ticket_Tukar) {
            $subject = $Ticket_Tukar['ticket']->nama;
            if ($store = Store::where('id', $Ticket_Tukar['ticket']->store_id)->first()) {
                $from = $store['nama'];
            } else {
                $from = 'Ticket Event';
            }
            $nama = $Ticket_Tukar['nama'];
            $kode = $Ticket_Tukar['kode'];
            $jumlah = $Ticket_Tukar['jumlah'];

            if (Mail::to($Ticket_Tukar['email'])->send(new Email($subject, $from, $kode, $nama, $jumlah))) {
                $email = true;
            } else {
                $email = false;
            };
        } else {
            $email = false;
        }
        return $email;
    }

    public function TambahScan(Request $request)
    {
        if (!in_array('createTicketScan', $this->permission())) {
            return redirect()->to('/');
        }

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'wa' => 'required',
                'tipe' => 'required',
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

            if ($ticket = Ticket::where('id', $request->input('ticket'))->first()) {
                $input = [
                    'ticket_id' => $ticket['id'],
                    'kode' => 'TIC' . rand(10000, 99999) . Ticket_Tukar::count(),
                    'nama' => $request->input('nama'),
                    'wa' => $request->input('wa'),
                    'email' => $request->input('email'),
                    'jumlah' => $request->input('jumlah'),
                    'pembuat' => $request->session()->get('store'),
                    'berlaku' => $ticket['berlaku'],
                    'pembayaran' => $request->input('tipe'),
                    'harga' => round($ticket['harga'] * $request->input('jumlah')),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if ($id = Ticket_Tukar::insertGetId($input)) {

                    $data = [
                        'toast' => true,
                        'status' => 'success',
                        'pesan' => 'Berhasil dibuat',
                        'email' => $id
                    ];
                } else {
                    $data = [
                        'toast' => true,
                        'status' => 'error',
                        'pesan' =>  'Terjadi kegagalan system'
                    ];
                };
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' =>  'Ticket Tidak ditemukan'
                ];
            }
        }


        echo json_encode($data);
    }

    public function Masuk(Request $request)
    {
        $id = $request->input('id');

        $generator = new BarcodeGeneratorPNG();
        if ($data = Ticket_Tukar::where('kode', $id)->with('Ticket')->first()) {
            if ($data['ticket']->img_voc) {
                if (strlen($data['nama']) <= 18) {
                    $nama =  $data['nama'];
                } else {
                    $nama =  substr($data['nama'], 0, 18);
                }
                echo '
                <head>
                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
                    <style>
                    body {
                        font-family: "Audiowide", sans-serif;
                    }
                    </style>
                    </head>
                    <img  width="965px" src="' . url('/uploads/ticket/' . $data['ticket']->img_voc) . '"> <br>';
                echo '<div style="position: relative;margin-top: -279px;margin-left: 85px;">
                <img  width="800px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($id, $generator::TYPE_CODE_128)) . '">
                </div>';
                echo '<div style="position: relative;margin-top: -326px;font-size: 40px;width: 970px;text-align: center;font-weight: bolder;"><b>' . ucwords($nama) . '</b></div>';

                echo '<div style="position: absolute;top: 36px;font-size: 80px;left: 37px;width: 77px;text-align: center;"><b>' . $data['jumlah'] . '</b></div>';
            } else {
                echo 'Voucher Tidak ditemukan';
            }
        } else {
            echo 'Voucher Tidak ditemukan';
        }
    }

    public function Gunakan(Request $request)
    {
        $id = $request->input('id');

        if ($Ticket_Tukar = Ticket_Tukar::where('id', $id)->with('Ticket')->first()) {
            if (Ticket_Tukar::where('id', $id)->update(['di' => $request->session()->get('store'), 'claim' => date('Y-m-d H:i:s')])) {
                $data = [
                    'toast' => true,
                    'status' => 'success',
                    'pesan' => 'Berhasil ditukar',
                    'array' => $Ticket_Tukar
                ];
            } else {
                $data = [
                    'toast' => true,
                    'status' => 'error',
                    'pesan' => 'Gagal Ditukar',
                    'array' => $Ticket_Tukar
                ];
            }
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' => 'Gagal Ditukar'
            ];
        }

        echo json_encode($data);
    }
    /////////////////////////////////// Scan //////////////////////////

    /////////////////////////////////// Buat //////////////////////////
    public function Nama(Request $request)
    {
        $this->data['user_permission'] = $this->permission();
        if (!in_array('viewTicketNama', $this->permission())) {
            return redirect()->to('/');
        }
        $this->data['subtitle'] = 'Nama';
        $this->data['store'] = Store::all();
        $this->data['ticket'] = Ticket::where('berlaku', '>=', date('Y-m-d'))->get();

        return view('TicketNama', $this->data);
    }

    public function ManageNama(Request $request)
    {
        if (!in_array('viewTicketNama', $this->permission())) {
            return redirect()->to('/');
        }

        $result = array('data' => array());
        $Data = Ticket::with('Store')->latest()->get();


        foreach ($Data as $value) {
            if ($value['store_id']) {
                $store = $value['store']->nama;
            } else {
                $store = 'Semua';
            }

            $button = '<div class="btn-group dropleft">
                <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown" aria-expanded="false"> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">';

            if (in_array('updateTicketNama', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Edit(" . $value['id'] . "," . '"' . $this->title . '"' . ")' data-toggle='modal' data-target='#Modal' ><i class='fas fa-pencil-alt'></i> Edit</a></li>";
            }
            if (in_array('deleteTicketNama', $this->permission())) {
                $button .= "<li><a class='dropdown-item' onclick='Hapus(" . $value['id'] . "," . '"' . $this->title . '"' . ")'  ><i class='fas fa-trash-alt'></i> Hapus</a></li>";
            }

            $button .= '</ul></div>';

            $result['data'][] = array(
                $store,
                $value['nama'],
                $this->rupiah($value['harga']),
                '<img style="max-width: 100px;" src="' . url('uploads/ticket/' . $value['img_benner']) . '">',
                '<img style="max-width: 100px;" src="' . url('uploads/ticket/' . $value['img_voc']) . '">',
                $value['berlaku'],
                $button
            );
        }

        echo json_encode($result);
    }

    public function Harga(Request $request)
    {
        $id = $request->input('id');
        $data = Ticket::where('id', $id)->first();
        if ($data) {
            echo $data['harga'];
        } else {
            echo null;
        }
    }

    public function TambahNama(Request $request)
    {
        if (!in_array('createTicketScan', $this->permission())) {
            return redirect()->to('/');
        }

        $validator = Validator::make(
            $request->all(),
            $rules = [
                'nama' => 'required|unique:ticket',
                'harga' => 'required',
                'store' => 'required',
                'berlaku' => 'required',
                'img_benner' => 'required',
                'img_voc' => 'required',
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

            if ($request->hasFile('img_benner')) {
                $files = $request->file('img_benner');
                $imageName = 'benner_' . date('YmdHis') . '.' . $files->getClientOriginalExtension();
                $files->move(public_path('uploads/ticket'), $imageName);
                $img_benner = $imageName;
            } else {
                $img_benner = '';
            }


            if ($request->hasFile('img_voc')) {
                $files1 = $request->file('img_voc');
                $imageName1 = 'voucher_' . date('YmdHis') . '.' . $files1->getClientOriginalExtension();
                $files1->move(public_path('uploads/ticket'), $imageName1);
                $img_voc = $imageName1;
            } else {
                $img_voc = '';
            }

            if ($request->input('store') == 'semua') {
                $store = null;
            } else {
                $store = $request->input('store');
            }

            $input = [
                'nama' => $request->input('nama'),
                'harga' => $this->unrupiah($request->input('harga')),
                'store_id' => $store,
                'berlaku' => $request->input('berlaku'),
                'img_benner' =>  $img_benner,
                'img_voc' =>  $img_voc
            ];
            if (Ticket::create($input)) {
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
        if (!in_array('updateTicketNama', $this->permission())) {
            return redirect()->to('/');
        }
        $id = $request->input('id');
        $request->session()->put('IdEdit', $id);

        $this->data['TicketNama'] = Ticket::where('id', $id)->first();
        $this->data['store'] = Store::all();
        return view('Edit', $this->data);
    }

    public function TambahEdit(Request $request)
    {

        if (!in_array('updateTicketNama', $this->permission())) {
            return redirect()->to('/');
        }

        $id = $request->session()->get('IdEdit');
        if ($id) {
            $validator = Validator::make(
                $request->all(),
                $rules = [
                    'nama' => 'required',
                    'harga' => 'required',
                    'store' => 'required',
                    'berlaku' => 'required'
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

                if ($request->hasFile('img_benner')) {
                    $files = $request->file('img_benner');
                    $imageName = 'benner_' . date('YmdHis') . '.' . $files->getClientOriginalExtension();
                    $files->move(public_path('uploads/ticket'), $imageName);
                    $img_benner = $imageName;
                } else {
                    $img_benner = '';
                }


                if ($request->hasFile('img_voc')) {
                    $files1 = $request->file('img_voc');
                    $imageName1 = 'voucher_' . date('YmdHis') . '.' . $files1->getClientOriginalExtension();
                    $files1->move(public_path('uploads/ticket'), $imageName1);
                    $img_voc = $imageName1;
                } else {
                    $img_voc = '';
                }

                if ($request->input('store') == 'semua') {
                    $store = null;
                } else {
                    $store = $request->input('store');
                }

                if ($img_benner && $img_voc) {
                    $input = [
                        'nama' => $request->input('nama'),
                        'harga' => $this->unrupiah($request->input('harga')),
                        'store_id' => $store,
                        'berlaku' => $request->input('berlaku'),
                        'img_benner' =>  $img_benner,
                        'img_voc' =>  $img_voc
                    ];
                } else {
                    $input = [
                        'nama' => $request->input('nama'),
                        'harga' => $this->unrupiah($request->input('harga')),
                        'store_id' => $store,
                        'berlaku' => $request->input('berlaku')
                    ];
                }
                if (Ticket::where('id', $id)->update($input)) {
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


        echo json_encode($data);
    }

    public function Hapus(Request $request)
    {
        if (!in_array('deleteTicketNama', $this->permission())) {
            return redirect()->to('/');
        }
        $id =  $request->input('id');
        $ticket = Ticket::where('id', $id)->first();
        if ($ticket) {
            if (Ticket::where('id', $id)->delete()) {
                if (file_exists(public_path("uploads/ticket/" . $ticket['img_voc']))) {
                    unlink(public_path("uploads/ticket/" . $ticket['img_voc']));
                }
                if (file_exists(public_path("uploads/ticket/" . $ticket['img_benner']))) {
                    unlink(public_path("uploads/ticket/" . $ticket['img_benner']));
                }

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
        } else {
            $data = [
                'toast' => true,
                'status' => 'error',
                'pesan' =>  'Gagal mengambil data'
            ];
        }

        echo json_encode($data);
    }
    /////////////////////////////////// Buat //////////////////////////
}
