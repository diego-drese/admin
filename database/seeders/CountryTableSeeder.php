<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\Country;

class CountryTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $account = Country::find(1);
        if(!$account) {
            DB::table('country')
                ->insert([
                    'id' => 1,
                    'name' => 'Italy',
                    'iso' => 'IT',
                    'time_zone' => 'Europe/Rome',
                    'minimum_size_phone' => 9,
                    'maximum_size_phone' => 11,
                    'ddi' => '39',
                    'currency' => 'EUR',
                    'currency_symbol' => '€',
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            DB::table('country')
                ->insert([
                    'id' => 2,
                    'name' => 'Brazil',
                    'iso' => 'BR',
                    'time_zone' => 'America/Sao_Paulo',
                    'minimum_size_phone' => 11,
                    'maximum_size_phone' => 11,
                    'ddi' => '55',
                    'currency' => 'BRL',
                    'currency_symbol' => 'R$',
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
        }
    }
}
