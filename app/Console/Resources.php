<?php

namespace App\Console;

use App\Models\Resource;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class Resources extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:resources {roleAttach?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Routes by Resources';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $routeCollection= Route::getRoutes();
        $bar            = $this->output->createProgressBar(count($routeCollection));
        $role           = $this->argument('roleAttach') ? Role::getById($this->argument('roleAttach')) : null;
        foreach ($routeCollection as $routeLaravel) {
            $action     = $routeLaravel->getAction();
            $middleware = $action['middleware'] ?? null;

            if (null != $middleware && !is_array($middleware)) {
                $middleware = [$middleware];
            }
            if (array_key_exists('controller', $action) && !is_null($middleware) && in_array('admin.acl', $middleware)) {
                $res = Resource::getResourcesByRouteName($routeLaravel->getName());
                if (!$res) {
                    $res                    = new Resource;
                }
                $res->name              = isset($routeLaravel->wheres['name']) ? $routeLaravel->wheres['name'] : ucfirst(str_replace('.', ' ', $routeLaravel->getName()));;
                $res->is_menu           = isset($routeLaravel->wheres['isMenu']) && $routeLaravel->wheres['isMenu'] ? 1 : 0;
                $res->route_name        = $routeLaravel->getName();
                $res->controller_method = $action['controller'];
                $res->can_be_default    = isset($routeLaravel->wheres['default']) && $routeLaravel->wheres['default'] ? 1 : 0;
                $res->order             = 0;
                $res->save();

                /** Find parent resource */
                if (isset($routeLaravel->wheres['parent']) && $routeLaravel->wheres['parent']) {
                    $resParent = Resource::getResourcesByRouteName($routeLaravel->wheres['parent']);
                    if ($resParent) {
                        $res->parent_id = $resParent->id;
                    }
                }
                if($role){
                    $role->resources()->attach($res);
                }
                $bar->advance();
            }
        }

        Cache::tags(Config::get('app.cache_tag'))->flush();
        $bar->finish();
    }

}
