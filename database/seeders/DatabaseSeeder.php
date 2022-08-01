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

        // User::create([
        //     'store' => 'CV Prima Rasa Selaras',
        //     'store_id' => 2,
        //     'username' => 'prsprs',
        //     'password' => bcrypt('prsprs'),
        //     'email' => 'primarasaselaras@gmail.com',
        //     'firstname' => 'PRS',
        //     'lastname' => 'Prima Rasa Selaras',
        //     'phone' => '085369957606',
        //     'gender' => 1,
        //     'izin' => 1,
        //     'img' => null,
        //     'last_login' => date('Y-m-d H:i:s'),
        //     'email_verified_at' => null,
        //     'remember_token' => null,
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s')

        // ]);

        Groups::create([
            'nama' => 'SUPERADMIN',
            'permission' => serialize($permession),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        $v2 = 'a:48:{i:0;s:14:"createSupplier";i:1;s:14:"updateSupplier";i:2;s:12:"viewSupplier";i:3;s:14:"deleteSupplier";i:4;s:12:"createSatuan";i:5;s:12:"updateSatuan";i:6;s:10:"viewSatuan";i:7;s:12:"deleteSatuan";i:8;s:11:"createBahan";i:9;s:11:"updateBahan";i:10;s:9:"viewBahan";i:11;s:11:"deleteBahan";i:12;s:15:"createPeralatan";i:13;s:15:"updatePeralatan";i:14;s:13:"viewPeralatan";i:15;s:15:"deletePeralatan";i:16;s:13:"createPegawai";i:17;s:13:"updatePegawai";i:18;s:11:"viewPegawai";i:19;s:13:"deletePegawai";i:20;s:25:"createFoodcostBahanOlahan";i:21;s:25:"updateFoodcostBahanOlahan";i:22;s:23:"viewFoodcostBahanOlahan";i:23;s:25:"deleteFoodcostBahanOlahan";i:24;s:20:"createFoodcostVarian";i:25;s:20:"updateFoodcostVarian";i:26;s:18:"viewFoodcostVarian";i:27;s:20:"deleteFoodcostVarian";i:28;s:19:"createFoodcostResep";i:29;s:19:"updateFoodcostResep";i:30;s:17:"viewFoodcostResep";i:31;s:19:"deleteFoodcostResep";i:32;s:9:"createPOS";i:33;s:9:"updatePOS";i:34;s:7:"viewPOS";i:35;s:9:"deletePOS";i:36;s:13:"createBelanja";i:37;s:13:"updateBelanja";i:38;s:11:"viewBelanja";i:39;s:13:"deleteBelanja";i:40;s:20:"createInventoryStock";i:41;s:20:"updateInventoryStock";i:42;s:18:"viewInventoryStock";i:43;s:20:"deleteInventoryStock";i:44;s:21:"createInventoryOpname";i:45;s:21:"updateInventoryOpname";i:46;s:19:"viewInventoryOpname";i:47;s:21:"deleteInventoryOpname";}';
        // Groups::create([
        //     'nama' => 'Office',
        //     'permission' => $v2,
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s')

        // ]);

        GroupsUsers::create([
            'users_id' => 1,
            'groups_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        // GroupsUsers::create([
        //     'users_id' => 2,
        //     'groups_id' => 2,
        //     'created_at' => date('Y-m-d H:i:s'),
        //     'updated_at' => date('Y-m-d H:i:s')

        // ]);



        // Bahan::create([
        //     'nama' => 'Ayam',
        //     'kode' => 'FD22121',
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

        // Olahan::create([
        //     'nama' => 'AYam Bakar',
        //     'kode' => 'FD22121',
        //     'satuan_pengeluaran' => 'Pcs',
        //     'satuan_penyajian' => 'Gram',
        //     'konversi_penyajian' => 50

        // ]);

        // Bahan_Olahan::create([
        //     'olahan_id' => 1,
        //     'bahan_id' => 1,
        //     'pemakaian' => 100

        // ]);
        // Bahan_Olahan::create([
        //     'olahan_id' => 1,
        //     'bahan_id' => 2,
        //     'pemakaian' => 10000

        // ]);

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

        // \App\Models\User::factory(10)->create();
        // \App\Models\Store::factory(10)->create();
    }
}
