<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class,  'user_has_roles');
    }

    static function getByEmail($email){
        return self::where('email', $email)->first();
    }

    public function hasPermissionCached($resource){
        $cacheName = __CLASS__ . __FUNCTION__ . '-user-'.$this->id;
        $resources =  Cache::tags([Config::get('app.cache_tag')])->remember($cacheName, Config::get('cache_ttl_86400'), function ()  {
            $this->load('roles');
            $roles= $this->roles->pluck('id')->toArray();
            return RoleHasResource::select('resources.*')
                ->distinct()
                ->join('resources', 'resources.id', 'role_has_resources.resource_id')
                ->whereIn('role_id', $roles)
                ->get();

        });

        foreach ($resources as $resourceDb){
            if($resource->id == $resourceDb->id){
                return [$resourceDb];
            }
        }
        return [];
    }
}
