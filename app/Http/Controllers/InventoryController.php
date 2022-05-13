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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class InventoryController extends Controller
{
    public function __construct()
    {
        $this->data['title'] = 'Inventory';
        $this->data['subtitle'] = '';
        $this->title = $this->data['title'];
        $this->data['manage'] = 'Data ' . $this->data['title'] . ' Manage ' . date('Y-m-d');
    }


    /////////////////////////////////// SUPLIER //////////////////////////
    public function Stock(Request $request)
    {
        $this->data['subtitle'] = 'Stock';
        return view('Stock', $this->data);
    }
    /////////////////////////////////// SUPLIER //////////////////////////
    

    // 
    // 
    // bill
    // tgl

}
