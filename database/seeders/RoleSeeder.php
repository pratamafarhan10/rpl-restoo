<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'manajer',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'tempat duduk',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'waiter',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'dapur',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'kasir',
            'guard_name' => 'web'
        ]);
    }
}
