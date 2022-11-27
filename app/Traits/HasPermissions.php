<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Models\Permission;

trait HasPermissions {
    /**
     * @return BelongsToMany
     */
    public function permission(): BelongsToMany {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @return BelongsToMany
     */
    public function permissionsActive(): BelongsToMany {
        return $this->belongsToMany(Permission::class)->where('status', 1);
    }

    /**
     * @param  Permission $permission
     * @return bool
     */
    public function hasPermission(Permission $permission): bool{
        $cacheName = __CLASS__ . __FUNCTION__.'-role-'.$this->id. '-permission-'.$permission->id;
        return  Cache::tags([Config::get('aerd.cache_tag')])->remember($cacheName,  Config::get('aerd.cache_ttl'), function () use($permission){
            return $this->permissions->contains($permission);
        });
    }


}