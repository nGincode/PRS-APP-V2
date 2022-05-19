<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\Inventaris;
use App\Models\Pengadaan;
use App\Models\Bahan;
use App\Models\Peralatan;
use App\Models\Satuan;

use Illuminate\Http\Request;

class BelanjaController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Belanja';
        $this->data['subtitle'] = '';
    }

    public function index(Request $request)
    {
        return view('Belanja', $this->data);
    }

    public function Namabarang(Request $request)
    {
        $bhn = Bahan::all();
        $bahan = [];
        foreach ($bhn as $key => $value) {
            $dt = json_decode($value['pengguna']);
            if ($dt) {
                if (in_array($request->session()->get('store_id'), $dt)) {
                    $bahan[] = array(
                        'id' => $value['id'],
                        'nama' => $value['nama']
                    );
                }
            }
        }

        $satuan = Satuan::all();
        echo json_encode(array('satuan' => $satuan, 'bahan' => $bahan));
    }

    public function Masterbahan(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            $bhn = Bahan::where('id', $id)->first();
            echo json_encode($bhn);
        }
    }
}
