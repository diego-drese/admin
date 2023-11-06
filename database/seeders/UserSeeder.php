<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        if (!User::first()) {
            User::create([
                'id' => 1,
                'name' => 'root',
                'is_root' => 1,
                'email' => 'root@root.com',
                'password' => bcrypt('passMasterRoot'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
           $admin = User::create([
                'id' => 2,
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);


           $admin->roles()->attach(Role::ROLE_ID_ADMIN);
        }

    }
}
