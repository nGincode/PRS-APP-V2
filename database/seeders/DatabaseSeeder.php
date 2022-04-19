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

        User::create([
            'store' => 'CV Prima Rasa Selaras',
            'store_id' => 2,
            'username' => 'prsprs',
            'password' => bcrypt('prsprs'),
            'email' => 'primarasaselaras@gmail.com',
            'firstname' => 'PRS',
            'lastname' => 'Prima Rasa Selaras',
            'phone' => '085369957606',
            'gender' => 1,
            'izin' => 1,
            'img' => null,
            'last_login' => date('Y-m-d H:i:s'),
            'email_verified_at' => null,
            'remember_token' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);

        Groups::create([
            'nama' => 'SUPERADMIN',
            'permission' => serialize($permession),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        $v2 = 'a:4:{i:0;s:12:"createMaster";i:1;s:12:"updateMaster";i:2;s:10:"viewMaster";i:3;s:12:"deleteMaster";}';
        Groups::create([
            'nama' => 'Office',
            'permission' => $v2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);

        GroupsUsers::create([
            'users_id' => 1,
            'groups_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
        GroupsUsers::create([
            'users_id' => 2,
            'groups_id' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);

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
        Store::create([
            'nama' => 'CV Prima Rasa Selaras',
            'active' => 1,
            'tipe' => 'Nusa Indah',
            'alamat' => 'BENGKULU',
            'img' => null,
            'wa' => '085369957606',
            'jam_kerja' => '[{"No":0,"Nama":"Shift 1","Masuk":"15:16","Pulang":"15:16"}]',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);


        Bahan::create([
            'nama' => 'Ayam',
            'kode' => 'FD22121',
            'satuan_pembelian' => 'Pcs',
            'satuan_pengeluaran' => 'Pcs',
            'konversi_pengeluaran' => 100,
            'satuan_pemakaian' => 'Gram',
            'konversi_pemakaian' => 50,
            'harga' => 10000,
            'kategori' => 1

        ]);

        Bahan::create([
            'nama' => 'Gula',
            'kode' => 'FD22121',
            'satuan_pembelian' => 'Pcs',
            'satuan_pengeluaran' => 'Pcs',
            'konversi_pengeluaran' => 100,
            'satuan_pemakaian' => 'Gram',
            'konversi_pemakaian' => 50,
            'harga' => 10000,
            'kategori' => 1
        ]);

        Olahan::create([
            'nama' => 'AYam Bakar',
            'kode' => 'FD22121',
            'satuan_pengeluaran' => 'Pcs',
            'satuan_penyajian' => 'Gram',
            'konversi_penyajian' => 50

        ]);

        Bahan_Olahan::create([
            'olahan_id' => 1,
            'bahan_id' => 1,
            'pemakaian' => 100

        ]);
        Bahan_Olahan::create([
            'olahan_id' => 1,
            'bahan_id' => 2,
            'pemakaian' => 10000

        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Store::factory(10)->create();
    }
}
