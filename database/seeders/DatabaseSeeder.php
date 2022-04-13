<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Store;
use App\Models\GroupsUsers;
use App\Models\Groups;
use App\Models\User;

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
            'gender' => 1,
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

        GroupsUsers::create([
            'users_id' => 1,
            'groups_id' => 1,
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


        \App\Models\User::factory(10)->create();
        \App\Models\Store::factory(10)->create();
    }
}
