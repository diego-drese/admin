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
                    'id'            => 1,
                    'name'          => 'Adminstrador da conta',
                    'user_account'  => null,
                    'root_account'  => 1,
                    'description'   => 'Todos os privilégios para conta',
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
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
                    'id'            => 2,
                    'name'          => 'Adminstrador',
                    'description'   => 'Perfil para Adminstrador da plataforma',
                    'root_account'  => null,
                    'user_account'  => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ]);

            DB::table('role')
                ->insert([
                    'id'            => 3,
                    'name'          => 'Jurídico',
                    'description'   => 'Perfil para advogados para acesso juridico da plataforma',
                    'root_account'  => null,
                    'user_account'  => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ]);
            DB::table('role')
                ->insert([
                    'id'            => 4,
                    'name'          => 'Engenharia',
                    'description'   => 'Perfil para Engenheiros para acesso técnico da plataforma',
                    'root_account'  => null,
                    'user_account'  => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ]);

            DB::table('role')
                ->insert([
                    'id'            => 5,
                    'name'          => 'Administrativo',
                    'description'   => 'Perfil administrativo para acesso da plataforma',
                    'root_account'  => null,
                    'user_account'  => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ]);

            DB::table('role')
                ->insert([
                    'id'            => 6,
                    'name'          => 'Usuário',
                    'description'   => 'Perfil com permisão de apenas leitura em todas as áreas do sistema',
                    'root_account'  => null,
                    'user_account'  => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ]);

        }
    }
}
