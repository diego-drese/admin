<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\Language;
use App\Models\Role;
use App\Models\UserAccount;

class RoleTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $role = Role::find(1);
        if(!$role) {
            DB::table('role')
                ->insert([
                    'id'=>1,
                    'name' => 'Admin',
                    'description' => 'All privileges'
                ]);
            $role       = Role::find(1);
            $account    = Account::find(1);
            $user       = User::find(2);
            UserAccount::attach($user, $account, $role);

            $user->account_id       = $account->id;
            $user->is_account_root  = $account->id;
            $user->save();

            DB::table('role')
                ->insert([
                    'id'=>2,
                    'name' => 'Root Account',
                    'root_account' => 1,
                    'user_account' => null,
                    'description' => 'All privilege to account'
                ]);

            DB::table('role')
                ->insert([
                    'id'=>3,
                    'name' => 'User Account',
                    'root_account' => null,
                    'user_account' => 1,
                    'description' => 'Some privileges to account'
                ]);
        }
    }
}
