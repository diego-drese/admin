<?php
namespace App\Console;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route as RouteFacade;
use Illuminate\Routing\Route;
use App\Models\Permission;
use App\Models\Role;


class ProcessRotesPermission extends Command {
    public $signature    = 'Aerd:PRP';
    protected $description = 'Core process rote permission, insert the api routes in the Permission table, and relate it to the admin profile';
    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        $role = Role::find(1);
        if(!$role){
            $this->error('Role Admin not found, run seed first');
            return true;
        }
        $this->createPermissions($role);
    }


    /**
     * @param Role $role
     */
    protected function createPermissions(Role $role): void {
        foreach (RouteFacade::getRoutes() as $route) {
            if ($this->shouldIgnore($route)) {
                continue;
            }
            $permission = $this->persistPermission($route);
            $role->permission()->sync($permission, false);
        }
    }
    /**
     * @param Route $route
     * @return bool
     */
    private function shouldIgnore(Route $route): bool {
        return !in_array('aerd.acl', $route->gatherMiddleware()) ||
            !$route->uri ||
            !Permission::whereIn('verb', $route->methods)->where(
                'uri',
                $route->uri
            );
    }

    /**
     * @param $route
     * @return array
     */
    private function persistPermission($route) {
        $permission = [];
        foreach ($route->methods as $verb) {
            if (in_array($verb, ['HEAD', 'PATCH'])) {
                continue;
            }
            $permissionQuery = Permission::where('verb',$verb )->where('uri',$route->uri)->first();
            if($permissionQuery){
                return $permissionQuery;
            }

            $permission = Permission::create([
                'verb' => $verb,
                'uri' => $route->uri,
            ]);

        }
        return $permission;
    }
}