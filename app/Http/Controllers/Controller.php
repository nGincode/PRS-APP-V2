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
}
