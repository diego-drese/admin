<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Language;

class UserTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user   = User::find(1);
        $env    = Config::get('app.env');
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $pass   = $env=='local' ? '123456' : uniqid('prod-');
        if($user){
            return $user;
        }
        /** Create root user */
        DB::table('users')
            ->insert([
                'id'=>1,
                'name' => 'root',
                'email' => 'root@root.com',
                'password' => bcrypt($pass),
                'is_root' => 1,
                'language_id' => Language::getDefault()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        /** Create admin user */
        DB::table('users')
            ->insert([
                'id'=>2,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt($pass),
                'is_root' => 0,
                'language_id' =>Language::getDefault()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),

            ]);

        $output->writeln('   The password users is ['.$pass.']');
    }
}
