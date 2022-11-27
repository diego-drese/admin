<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasRoles;
use App\Traits\Observable;

class Permission extends Model {
    use HasRoles, Observable;
    
    protected $table = 'permission';
    protected $guarded = ['id'];

    public static function getPermission($verb, $uri) {
        return self::where('verb', $verb)->where('uri', $uri)->first();
    }
}