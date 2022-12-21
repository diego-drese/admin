<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model {
    
    protected $table = 'user_account';
    protected $fillable = [
        'user_id',
        'account_id',
        'role_id',
        'is_admin',
        'all_radio_station',
        'radio_station',
    ];

    public static function attach(User $user, Account $account, Role $role, array $RadioStation=[]) : UserAccount {
        return self::create([
           'user_id'            => $user->id,
           'account_id'         => $account->id,
           'role_id'            => $role->id,
           'is_admin'           => $role->root_account,
           'all_radio_station'  => count($RadioStation) ? 0 : 1,
           'radio_station'      => json_encode($RadioStation),
        ]);
    }

    public static function getByUserAndAccount($userId, $accountId){
        return self::where('user_id', $userId)
            ->where('account_id', $accountId)
            ->first();
    }
}
