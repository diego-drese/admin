<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Account;

class AccountTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $account = Account::find(1);
        if(!$account) {
            DB::table('account')
                ->insert([
                    'id' => 1,
                    'company' => 'Admin',
                    'website' => 'Admin',
                    'email' => 'admin@octaflow.com',
                    'email_notify' => 1,
                    'address1' => 'Street XYZ, 455',
                    'address2' => 'Complement 885',
                    'state' => 'Rio Grande do sul',
                    'city' => 'Porto Alegre',
                    'postcode' => '90500-055',
                    'country_id' => 1,
                    'phone' => '5551993158844',
                    'status' => 1
                ]);
        }
    }
}
