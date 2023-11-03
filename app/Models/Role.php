<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Role extends Model {
    protected $fillable = [
        'name',
        'status',
    ];

    public function users(){

    }
    public function resources(){
        return $this->belongsToMany(Resource::class,  'role_has_resources');
    }

    public static function getById($id){
        return self::where('id', $id)->first();
    }

}
