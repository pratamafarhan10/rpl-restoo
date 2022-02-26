<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manajer = User::create([
            'name' => 'manajer',
            'email' => 'manajer@gmail.com',
            'password' => bcrypt('password'),
            'category' => 'manajer',
        ]);

        $manajer->assignRole('manajer');

        $tempatDuduk = User::create([
            'name' => 'tempat duduk 1',
            'email' => 'seat1@gmail.com',
            'password' => bcrypt('password'),
            'category' => 'tempat duduk',
            'table_number' => '1',
        ]);

        $tempatDuduk->assignRole('tempat duduk');

        $waiter = User::create([
            'name' => 'waiter',
            'email' => 'waiter@gmail.com',
            'password' => bcrypt('password'),
            'category' => 'waiter',
            'table_number' => null,
        ]);

        $waiter->assignRole('waiter');

        $kasir = User::create([
            'name' => 'kasir',
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('password'),
            'category' => 'kasir',
            'table_number' => null,
        ]);

        $kasir->assignRole('kasir');

        $timDapur = User::create([
            'name' => 'tim dapur',
            'email' => 'dapur@gmail.com',
            'password' => bcrypt('password'),
            'category' => 'dapur',
            'table_number' => null,
        ]);

        $timDapur->assignRole('dapur');
    }
}
