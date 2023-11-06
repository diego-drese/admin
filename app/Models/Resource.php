<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Resource extends Model {
    const TYPE_ROUTE='route';
    const TYPE_CONTROL='control';

    protected $fillable = [
        'type',
        'name',
        'description',
        'parent_id',
        'order',
    ];

    public static function checkUser($routeName){
        $user 			= Auth::user();
        $resource       = self::getResourcesByRouteName($routeName);
        if($resource == null){
            return false;
        }
        if($user->is_root==User::IS_ROOT){
            return $resource;
        }
        return $user->hasPermissionCached($resource);
    }

    public static function getResourcesByControllerMethod($Controller)  {
        $cacheName = __CLASS__ . __FUNCTION__ . '-controller-' . $Controller;
        return  Cache::tags([Config::get('app.cache_tag')])->remember($cacheName, Config::get('cache_ttl_86400'), function () use ($Controller) {
            return self::where('controller', $Controller)->first();
        });
    }

    public static function getResourcesByRouteName($route)  {
        $cacheName = __CLASS__ . __FUNCTION__ . '-route-' . $route;
        return  Cache::tags([Config::get('app.cache_tag')])->remember($cacheName, Config::get('cache_ttl_86400'), function () use ($route) {
            return self::where('route', $route)->first();
        });
    }


}
