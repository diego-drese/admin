<?php
namespace App\Console;

use Illuminate\Console\Command;


class CreateResource extends Command {
    public $signature    = 'Aerd:CR';
    protected $description = 'Core create resource, create the files needed for a task';
    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        $model = $this->ask('What is your model name?');
        $table = $this->ask('What is your table name?');
        $route = strtolower($this->ask('What is your route name?'));

        $path = str_replace('Console"', 'Stubs', __DIR__);
        $pathModel = $path.'/Models/'.$model.'.php';
        $pathController = $path.'/Http/Controllers/'.$model.'Controller.php';
        $pathRequest = $path.'/Http/Requests/'.$model.'Request.php';
        $pathResourcesCollection = $path.'/Http/Resources/'.$model.'Collection.php';
        $pathResourcesResource = $path.'/Http/Resources/'.$model.'Resource.php';

        if(file_exists($pathModel)){
            $this->error('Your Model already exists path:'.$pathModel);
            return false;
        }
        if(file_exists($pathController)){
            $this->error('Your Controller already exists path:'.$pathController);
            return false;
        }
        if(file_exists($pathRequest)){
            $this->error('Your Request already exists path:'.$pathRequest);
            return false;
        }
        if(file_exists($pathResourcesCollection)){
            $this->error('Your ResourceCollection already exists path:'.$pathResourcesCollection);
            return false;
        }
        if(file_exists($pathResourcesResource)){
            $this->error('Your Resource already exists path:'.$pathResourcesResource);
            return false;
        }

        $this->info('Your Model:'.$pathModel);
        $this->info('Your Controller:'.$pathController);
        $this->info('Your Request:'.$pathRequest);
        $this->info('Your pathResourcesCollection:'.$pathResourcesCollection);
        $this->info('Your pathResourcesResource:'.$pathResourcesResource);

        if ($this->confirm('Do you wish to continue?', true)) {
            $newModel = file_get_contents($path.'/Stubs/Model.php');
            $newModel = str_replace('MODEL_NAME', $model, $newModel);
            $newModel = str_replace('TABLE_NAME', $table, $newModel);
            file_put_contents($pathModel, $newModel, FILE_APPEND);

            $newController  = file_get_contents($path.'/Stubs/Controller.php');
            $newController  = str_replace('MODEL_NAME', $model, $newController);
            file_put_contents($pathController, $newController);

            $newResourceCollection  = file_get_contents($path.'/Stubs/Collection.php');
            $newResourceCollection  = str_replace('MODEL_NAME', $model, $newResourceCollection);
            file_put_contents($pathResourcesCollection, $newResourceCollection);

            $newResource  = file_get_contents($path.'/Stubs/Resource.php');
            $newResource  = str_replace('MODEL_NAME', $model, $newResource);
            file_put_contents($pathResourcesResource, $newResource);

            $newRequest  = file_get_contents($path.'/Stubs/Request.php');
            $newRequest  = str_replace('MODEL_NAME', $model, $newRequest);

            file_put_contents($pathRequest, $newRequest);

            $newRoute = "Route::get('".str_replace('.', '-', $route)."', '".$model."Controller@index')->name('".$route.".index');
    Route::post('".str_replace('.', '-', $route)."', '".$model."Controller@store')->name('".$route.".store');
    Route::get('".str_replace('.', '-', $route)."/{id}', '".$model."Controller@show')->name('".$route.".show');
    Route::put('".str_replace('.', '-', $route)."/{id}', '".$model."Controller@update')->name('".$route.".update');
    
    /** Stubs insert HERE */
    ";
            $newRoutesApi  = file_get_contents($path.'/Routes/api.php');
            $newRoutesApi  = str_replace('/** Stubs insert HERE */', $newRoute, $newRoutesApi);

            file_put_contents($path.'/Routes/api.php', $newRoutesApi);
        }

        $this->info('Files and routes added successfully');
    }

}