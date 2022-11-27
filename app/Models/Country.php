<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Traits\HasPermissions;
use App\Traits\HasRoles;
use App\Traits\Observable;

class Country extends Model {
    use HasRoles, HasPermissions,  Observable;
    
    protected $table = 'country';
    protected $fillable = [
        'name',
        'iso',
        'time_zone',
        'minimum_size_phone',
        'maximum_size_phone',
        'ddi',
        'status',
    ];
    protected $appends = [
        'now'
    ];

    public function getNowAttribute(){
        $now = Carbon::now()->setTimezone($this->time_zone);
        return $now;
    }

    public static function findCached(int $id) : Country{
        $cacheName = __CLASS__ . __FUNCTION__.'-country-'.$id;
        return  Cache::tags([Config::get('aerd.cache_tag')])->remember($cacheName,  Config::get('aerd.cache_ttl'), function () use($id){
            return self::find($id);
        });
    }

    public static function getByAccountId($accountId){
        $cacheName = __CLASS__ . __FUNCTION__.'-account-'.$accountId;
        return  Cache::tags([Config::get('aerd.cache_tag')])->remember($cacheName,  Config::get('aerd.cache_ttl'), function () use($accountId){
            return self::select('country.*')->join('account', 'account.country_id', 'country.id')->where('account.id', $accountId)->first();
        });
    }

}

