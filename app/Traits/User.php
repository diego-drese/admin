<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Models\Country;
use App\Models\Permission;
use App\Models\Role;
use App\Models\UserAccount;

trait User {
    use Observable;
    public function initializeUser() {
        $this->fillable = [
            'name',
            'email',
            'password',
            'account_id',
            'is_account_root',
            'image',
            'language_id'
        ];
    }
    /**
     * @return array
     */
    protected function getArrayableAppends() : array {
        $this->appends = array_unique(array_merge($this->appends, ['accounts', 'country']));
        $this->hidden = array_unique(array_merge($this->hidden, ['is_root']));
        return parent::getArrayableAppends();
    }
    /**
     * @return Collection
     */
    public function getAccountsAttribute() : Collection {
        $cacheName = __CLASS__ . __FUNCTION__.'-user-'.$this->id;
        return  Cache::tags([Config::get('aerd.cache_tag')])->remember($cacheName,  Config::get('aerd.cache_ttl'), function () {
            $accounts = UserAccount::where('user_id', $this->id)
                ->select('account.*')
                ->join('account', 'account.id', 'user_account.account_id')
                ->get();

            foreach ($accounts as &$account) {
                $account->roles = Role::where('user_id', $this->id)
                    ->where('account_id', $account->id)
                    ->select('role.*')
                    ->join('user_account', 'role.id', 'user_account.role_id')
                    ->get();
            }
            return $accounts;
        });
    }

    public function getCountryAttribute() {
        $accountId = $this->account_id;
        $cacheName = __CLASS__ . __FUNCTION__.'-user-'.$this->id;
        return Cache::tags([Config::get('aerd.cache_tag')])->remember($cacheName,  Config::get('aerd.cache_ttl'), function () use($accountId) {
            return Country::getByAccountId($accountId);
        });
    }

    /**
     * @param int $accountId
     * @return Collection
     */
    public function getAccountRoles(int $accountId) : Collection {
        $cacheName = __CLASS__ . __FUNCTION__.'-user-'.$this->id.'-account-'.$accountId;
        return  Cache::tags([Config::get('aerd.cache_tag')])->remember($cacheName,  Config::get('aerd.cache_ttl'), function () use($accountId){
            return $this->accountRoles($accountId)->get();
        });
    }

    /**
     * @param int
     * @return HasMany
     */
    public function accountRoles(int $accountId) : HasMany {
        return $this->hasMany(UserAccount::class)->where('account_id', $accountId);
    }
    /**
     * @param  Role $role
     * @return bool
     */
    public function hasRole(Role $role): bool {
        return $this->roles()->contains($role);
    }

    /**
     * @param  Permission $permission
     * @return bool
     */
    public function hasPermission(Permission $permissionRequest): bool {
        if($this->is_root){
            return true;
        }
        if(!$this->account_id){
            return false;
        }
        /** Parse All accounts */
        foreach ($this->accounts as $account){
            if($account->id==$this->account_id){
                /** Test all roles from account*/
                foreach ($account->roles as $roles){
                    /** Testif exist permission in role from account*/
                    foreach ($roles->permissions as $permission){
                        if((int)$permission->permission_id===(int)$permissionRequest->id){
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * @param array $attributes
     * @return Builder|Model
     */
    public static function create(array $attributes = []) {
        $roles = $attributes['roles'] ?? null;
        if ($roles) {
            unset($attributes['roles']);
        }
        $model = static::query()->create($attributes);
        if ($roles) {
            $model->roles()->attach($roles);
        }
        return $model;
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = []) {
        $roles = $attributes['roles'] ?? null;
        if ($roles) {
            unset($attributes['roles']);
        }
        $updated = parent::update($attributes, $options);
        if ($updated && $roles) {
            $this->roles()->sync($roles);
        }

        return $updated;
    }

    public static function checkEmailExist($email, $id=null){
        $user = self::where('email', $email);
        if($id){
            $user->where('id', '!=' ,$id);
        }
        return $user->first();
    }
    public function setPasswordAttribute($password) {
        return $this->attributes['password'] = bcrypt($password);
    }
}
