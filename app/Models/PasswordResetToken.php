<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class PasswordResetToken extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'token',
        'created_at',
        'used_at',
    ];


    static function getByToken($token){
        return self::where('token', $token)->where('created_at', '>=', Carbon::now()->subMinutes(60))->first();
    }
}
