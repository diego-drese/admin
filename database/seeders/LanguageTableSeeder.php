<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if (!Language::existCode('us')) {
            Language::create(['code' => 'us', 'name' => 'English', 'status' => 1, 'icon' => 'us.png', 'default'=>1]);
        }
        
        if (!Language::existCode('it')) {
            Language::create(['code' => 'it', 'name' => 'Italian', 'status' => 1, 'icon' => 'it.png', 'default'=>0]);
        }

        if (!Language::existCode('br')) {
            Language::create(['code' => 'br', 'name' => 'Português', 'status' => 1, 'icon' => 'pt.png', 'default'=>0]);
        }
    }
}
