<?php

namespace App\Console;

use App\Models\Resource;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class ResourceCommand extends Command {
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
    protected $description = 'Refresh Routes by ResourcesCommand';

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
                    $res                = new Resource;
                }
                $res->type              = Resource::TYPE_ROUTE;
                $res->name              = ucfirst(str_replace('.', ' ', $routeLaravel->getName()));
                $res->description       = isset($routeLaravel->wheres['description']) ? $routeLaravel->wheres['description'] : '';
                $res->route             = $routeLaravel->getName();
                $res->controller        = $action['controller'];
                $res->order             = isset($routeLaravel->wheres['order']) ? $routeLaravel->wheres['order'] : 0;
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
