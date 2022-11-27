<?php

namespace App\Providers;

use App\Console\CreateResource;
use App\Console\ProcessRotesPermission;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([CreateResource::class, ProcessRotesPermission::class]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
