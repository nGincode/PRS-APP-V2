<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\GroupsUsers;
use App\Models\Inventory;
use App\Models\Belanja;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function permission()
    {
        $Id = request()->session()->get('id');
        $DataGroup = GroupsUsers::join('groups', 'groups.id', '=', 'groups_users.groups_id')
            ->where('groups_users.users_id', $Id)
            ->first();
        if ($DataGroup) {
            return unserialize($DataGroup['permission']);
        } else {
            return false;
        }
    }


    function rupiah($angka)
    {

        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }

    function unrupiah($val)
    {
        return str_replace(',', '', $val);
    }

    function tanggal($tanggal, $hanyatgl = null)
    {
        $ambiltgl = date('Y-m-d', strtotime($tanggal));

        $ambiljam = date('H:i:s', strtotime($tanggal));

        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $ambiltgl);

        if ($hanyatgl) {
            return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
        } else {
            return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0] . ' (' . $ambiljam . ')';
        }
    }

    function uang($uang)
    {
        $ratusan = substr($uang, -3);
        if ($ratusan < 500)
            $akhir = $uang - $ratusan;
        else
            $akhir = $uang + (1000 - $ratusan);
        return number_format($akhir, 0, ',', '');;
    }


    function AutoHarga()
    {
        $tgl_awal =  date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d'))));
        $tgl_akhir =  date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));


        foreach (Inventory::where('store_id', request()->session()->get('store_id'))->where('auto_harga', 1)->get() as $value) {

            $harga = 0;
            $row = 0;
            foreach (Belanja::where('store_id', request()->session()->get('store_id'))->where('bahan_id', $value['bahan_id'])->where('up', 1)->whereBetween('tgl', [$tgl_awal, $tgl_akhir])->get() as $v) {
                $harga += $v['stock_harga'];
                $row += 1;
            }
            if ($row) {
                $RataRata = round($harga / $row);

                $hargaskrang = $value['harga_last'];
                if ($RataRata != $hargaskrang) {
                    $upharga = $this->uang($RataRata);
                    Inventory::where('id', $value['id'])->update(['harga_last' => $upharga]);
                }
            }
        }
    }
}
