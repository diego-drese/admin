<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Observable;


class Account extends Model {
    use Observable;
    
    protected $table = 'account';
    protected $fillable = [
        'company',
        'company_size',
        'website',
        'email',
        'email_notify',
        'address1',
        'address2',
        'city',
        'state',
        'postcode',
        'country_id',
        'phone',
        'image',
        'api_access',
        'api_key',
        'status',
    ];

    protected $appends = ['users'];

    public function getUsersAttribute(){
        return User::join('user_account', 'user_account.user_id', 'users.id')
            ->select('users.*')
            ->where('user_account.account_id', $this->id)
            ->get()
            ->makeHidden(['accounts', 'account_id']);
    }

    public function scopeNoRoot($query, $user) {
        if($user->is_root){
            return $query;
        }
        $query->select('account.*');
        $query->join('user_account', 'user_account.account_id', 'account.id');
        $query->join('users', 'users.id', 'user_account.user_id');
        $query->where('users.id', $user->id);
        return $query;
    }

    public static function hasEmail($email, $id=null){
        $query = self::where('email', $email);
        if($id){
            $query->where('id', '!=', $id);
        }
        return $query->first();
    }

    public static function getById($id){
        return self::where('id', $id)->first();
    }
    public static function getCountry($id){
        return self::where('account.id', $id)->join('country', 'country.id', 'account.country_id')->select('country.*')->first();
    }

    public static function updateById($id, $request)
    {
        $acc = self::getById($id);
        return $acc->update($request->all());
    }

}
