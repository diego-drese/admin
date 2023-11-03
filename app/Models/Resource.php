<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Resource extends Model {
    protected $fillable = [
        'name',
        'is_menu',
        'parent_id',
        'order',
    ];
    public static function verifyUser($controllerAction){
        $user 			= Auth::user();
        $controller 	= $controllerAction;
        $resource       = self::getResourcesByControllerMethod($controller);
        if($resource == null){
            return false;
        }
        if($user->is_root){
            return $resource;
        }
        return $user->hasPermissionCached($resource);

    }

    public static function getResourcesByControllerMethod($ControllerMethod)  {
        $cacheName = __CLASS__ . __FUNCTION__ . '-controller-method-' . $ControllerMethod;
        return  Cache::tags([Config::get('app.cache_tag')])->remember($cacheName, Config::get('cache_ttl_86400'), function () use ($ControllerMethod) {
            return self::where('controller_method', $ControllerMethod)->first();
        });
    }


    public static function getResourcesByRouteName($routeName)  {
        $cacheName = __CLASS__ . __FUNCTION__ . '-route-name-' . $routeName;
        return  Cache::tags([Config::get('app.cache_tag')])->remember($cacheName, Config::get('cache_ttl_86400'), function () use ($routeName) {
            return self::where('route_name', $routeName)->first();
        });
    }

    public static function getResourceIdByRouteName($routeName)  {
        $cacheName = __CLASS__ . __FUNCTION__ . '-route-name-' . $routeName;
        return  Cache::tags([Config::get('app.cache_tag')])->remember($cacheName, Config::get('cache_ttl_86400'), function () use ($routeName) {
            return self::where('name', $routeName)->first();
        });
    }
}
