<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Store;
use App\Models\GroupsUsers;
use App\Models\Groups;
use App\Models\User;
use App\Models\Bahan;
use App\Models\Bahan_Olahan;
use App\Models\Olahan;
use App\Models\Satuan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        ///////////////////////////////////////////////////// SUPER ADMIN ////////////////////////
        Store::create([
            'nama' => 'SUPERADMIN',
            'active' => 1,
            'tipe' => 'SUPERADMIN',
            'alamat' => 'BENGKULU',
            'img' => null,
            'wa' => '085369957606',
            'jam_kerja' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        User::create([
            'store' => 'SUPERADMIN',
            'store_id' => 1,
            'username' => 'superadmin',
            'password' => bcrypt('superadmin'),
            'email' => 'fembinurilham@gmail.com',
            'firstname' => 'Fembi',
            'lastname' => 'Nur Ilham',
            'phone' => '085369957606',
            'gender' => 'Pria',
            'izin' => 1,
            'img' => null,
            'last_login' => date('Y-m-d H:i:s'),
            'email_verified_at' => null,
            'remember_token' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        $permession = array(
            'createUser',
            'updateUser',
            'viewUser',
            'deleteUser',
            'createGroup',
            'updateGroup',
            'viewGroup',
            'deleteGroup',
            'createStore',
            'updateStore',
            'viewStore',
            'deleteStore',
        );
        Groups::create([
            'nama' => 'SUPERADMIN',
            'permission' => serialize($permession),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        GroupsUsers::create([
            'users_id' => 1,
            'groups_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        $satuan = [
            [
                'nama' => 'Kilogram',
                'singkat' => 'Kg',
            ],
            [
                'nama' => 'Gram',
                'singkat' => 'Gr',
            ],
            [
                'nama' => 'Ons',
                'singkat' => 'Ons',
            ],
            [
                'nama' => 'Pack',
                'singkat' => 'Pck',
            ],
            [
                'nama' => 'Pieces',
                'singkat' => 'Pcs',
            ],
            [
                'nama' => 'Potong',
                'singkat' => 'Ptg',
            ],
            [
                'nama' => 'Liter',
                'singkat' => 'Ltr',
            ],
            [
                'nama' => 'Mililiter',
                'singkat' => 'Mil',
            ],
            [
                'nama' => 'Butir',
                'singkat' => 'Btr',
            ],
            [
                'nama' => 'Galon',
                'singkat' => 'Gln',
            ],
            [
                'nama' => 'Pouch',
                'singkat' => 'Poc',
            ],
            [
                'nama' => 'Lembar',
                'singkat' => 'Lbr',
            ],
            [
                'nama' => 'Roll',
                'singkat' => 'Rll',
            ],
            [
                'nama' => 'Ikat',
                'singkat' => 'Ikt',
            ],
            [
                'nama' => 'Bal',
                'singkat' => 'Bal',
            ],
            [
                'nama' => 'Karung',
                'singkat' => 'Krg',
            ],

        ];
        foreach ($satuan as $s) {
            Satuan::create($s);
        }
        ///////////////////////////////////////////////////// SUPER ADMIN ////////////////////////


        ///////////////////////////////////////////////////// DUMMY /////////////////////////////
        // Store::create([
        //     'nama' => 'CV Prima Rasa Selaras',
        //     'active' => 1,
        //     'tipe' => 'Outlet',
        //     'alamat' => 'BENGKULU',
        //     'img' => null,
        //     'wa' => '085369957606',
        //     'jam_kerja' => '[{"No":0,"Nama":"Shift 1","Masuk":"15:16","Pulang":"15:16"}]',
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s')
        // ]);
        // User::create([
        //     'store' => 'CV Prima Rasa Selaras',
        //     'store_id' => 2,
        //     'username' => 'prsprs',
        //     'password' => bcrypt('prsprs'),
        //     'email' => 'primarasaselaras@gmail.com',
        //     'firstname' => 'PRS',
        //     'lastname' => 'Prima Rasa Selaras',
        //     'phone' => '085369952606',
        //     'gender' => 1,
        //     'izin' => 1,
        //     'img' => null,
        //     'last_login' => date('Y-m-d H:i:s'),
        //     'email_verified_at' => null,
        //     'remember_token' => null,
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s')

        // ]);
        // $permessionall = 'a:80:{i:0;s:10:"createUser";i:1;s:10:"updateUser";i:2;s:8:"viewUser";i:3;s:10:"deleteUser";i:4;s:11:"createStore";i:5;s:11:"updateStore";i:6;s:9:"viewStore";i:7;s:11:"deleteStore";i:8;s:11:"createGroup";i:9;s:11:"updateGroup";i:10;s:9:"viewGroup";i:11;s:11:"deleteGroup";i:12;s:21:"createReportPenjualan";i:13;s:21:"updateReportPenjualan";i:14;s:19:"viewReportPenjualan";i:15;s:21:"deleteReportPenjualan";i:16;s:19:"createReportBelanja";i:17;s:19:"updateReportBelanja";i:18;s:17:"viewReportBelanja";i:19;s:19:"deleteReportBelanja";i:20;s:21:"createReportInventory";i:21;s:21:"updateReportInventory";i:22;s:19:"viewReportInventory";i:23;s:21:"deleteReportInventory";i:24;s:20:"createReportFoodcost";i:25;s:20:"updateReportFoodcost";i:26;s:18:"viewReportFoodcost";i:27;s:20:"deleteReportFoodcost";i:28;s:14:"createSupplier";i:29;s:14:"updateSupplier";i:30;s:12:"viewSupplier";i:31;s:14:"deleteSupplier";i:32;s:12:"createSatuan";i:33;s:12:"updateSatuan";i:34;s:10:"viewSatuan";i:35;s:12:"deleteSatuan";i:36;s:11:"createBahan";i:37;s:11:"updateBahan";i:38;s:9:"viewBahan";i:39;s:11:"deleteBahan";i:40;s:15:"createPeralatan";i:41;s:15:"updatePeralatan";i:42;s:13:"viewPeralatan";i:43;s:15:"deletePeralatan";i:44;s:13:"createPegawai";i:45;s:13:"updatePegawai";i:46;s:11:"viewPegawai";i:47;s:13:"deletePegawai";i:48;s:25:"createFoodcostBahanOlahan";i:49;s:25:"updateFoodcostBahanOlahan";i:50;s:23:"viewFoodcostBahanOlahan";i:51;s:25:"deleteFoodcostBahanOlahan";i:52;s:20:"createFoodcostVarian";i:53;s:20:"updateFoodcostVarian";i:54;s:18:"viewFoodcostVarian";i:55;s:20:"deleteFoodcostVarian";i:56;s:19:"createFoodcostResep";i:57;s:19:"updateFoodcostResep";i:58;s:17:"viewFoodcostResep";i:59;s:19:"deleteFoodcostResep";i:60;s:9:"createPOS";i:61;s:9:"updatePOS";i:62;s:7:"viewPOS";i:63;s:9:"deletePOS";i:64;s:13:"createBelanja";i:65;s:13:"updateBelanja";i:66;s:11:"viewBelanja";i:67;s:13:"deleteBelanja";i:68;s:20:"createInventoryStock";i:69;s:20:"updateInventoryStock";i:70;s:18:"viewInventoryStock";i:71;s:20:"deleteInventoryStock";i:72;s:21:"createInventoryOpname";i:73;s:21:"updateInventoryOpname";i:74;s:19:"viewInventoryOpname";i:75;s:21:"deleteInventoryOpname";i:76;s:11:"createOrder";i:77;s:11:"updateOrder";i:78;s:9:"viewOrder";i:79;s:11:"deleteOrder";}';
        // Groups::create([
        //     'nama' => 'Office',
        //     'permission' => $permessionall,
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s')

        // ]);
        // GroupsUsers::create([
        //     'users_id' => 2,
        //     'groups_id' => 2,
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s')

        // ]);
        // Bahan::create([
        //     'nama' => 'Ayam',
        //     'kode' => 'FD22161',
        //     'satuan_pembelian' => 'Pcs',
        //     'satuan_pengeluaran' => 'Pcs',
        //     'konversi_pengeluaran' => 100,
        //     'satuan_pemakaian' => 'Gram',
        //     'konversi_pemakaian' => 50,
        //     'harga' => 10000,
        //     'kategori' => 1

        // ]);
        // Bahan::create([
        //     'nama' => 'Gula',
        //     'kode' => 'FD22121',
        //     'satuan_pembelian' => 'Pcs',
        //     'satuan_pengeluaran' => 'Pcs',
        //     'konversi_pengeluaran' => 100,
        //     'satuan_pemakaian' => 'Gram',
        //     'konversi_pemakaian' => 50,
        //     'harga' => 10000,
        //     'kategori' => 1
        // ]);
        // \App\Models\User::factory(10)->create();
        // \App\Models\Store::factory(10)->create();
    }
}
