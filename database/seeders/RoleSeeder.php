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
            Role::create(['id'=>Role::ROLE_ID_ADMIN, 'name' => 'admin', 'status'=>1]);
            Role::create(['id'=>Role::ROLE_ID_USER, 'name' => 'user', 'status'=>1]);
        }

    }
}
