<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use App\Traits\Observable;

class Language extends Model {
    use Observable;
    
    protected $table = 'language';
    protected $fillable = [
        'name',
        'status',
        'code',
        'icon',
        'default',
    ];

    public static function existCode($code) {
        $query = self::where('code', $code)->first();
        return $query ? true : false;
    }

    public static function getDefault() {
        $default = self::where('default', 1)->first();
        if($default){
            self::first();
        }
        return $default;
    }
    /**
     * @param array $attributes
     * @return Builder|Model
     */
    public static function create(array $attributes = []) {
        if ($attributes['default']) {
            static::query()->where('default', '1')->update(['default'=>0]);
        }
        return static::query()->create($attributes);
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = []) {
        if ($attributes['default']) {
            static::query()->where('default', '1')->update(['default'=>0]);
        }
        return  parent::update($attributes, $options);

    }

}

