<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use App\Traits\HasPermissions;
use App\Traits\Observable;


class Role extends Model {
    use HasPermissions, Observable;
    
    protected $table = 'role';
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'status',
        'description',
        'root_account',
        'user_account',
    ];
    protected $appends = [
      'permissions'
    ];
    /**
     * @param int
     * @return Role
     */
    public static function findCached(int $roleId) : Role{
        return self::find($roleId);
    }

    /**
     * @param array $attributes
     * @return Builder|Model
     */
    public static function create(array $attributes = []) {
        $permission = $attributes['permission'] ?? null;
        if ($permission) {
            unset($attributes['permission']);
        }
        $model = static::query()->create($attributes);
        if ($permission) {
            $model->permission()->attach($permission);
        }

        return $model;
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = []) {
        $permission = $attributes['permission'] ?? null;
        if ($permission) {
            unset($attributes['permission']);
        }
        $updated = parent::update($attributes, $options);
        if ($updated && $permission) {
            $this->permission()->sync($permission);
        }
        return $updated;
    }

    public function getPermissionsAttribute(){
        $permissionsFormat = [];
        $permissions = Role::join('permission_role', 'permission_role.role_id', 'role.id')
            ->select('permission_role.*')
            ->where('role.id', $this->id)
            ->get();
        foreach ($permissions as $permission){
            $permissionsFormat[] = (object)[
                "permission_id"=>$permission->permission_id,
                "role_id"=> $permission->role_id,
            ];
        }
        return $permissionsFormat;
    }
    public  static function getDefaultRootAccount(){
        return self::where('root_account', 1)->where('status', 1)->first();
    }
}
