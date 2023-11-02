<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        if(!Role::first()){
            $admin          = Role::create(['name' => 'admin', 'status'=>1]);
            $user           = Role::create(['name' => 'user', 'status'=>1]);
        }

    }
}
