<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\PluginTemplate\Providers\PluginTemplateServiceProvider;
use Plugins\UserManagement\Providers\UserManagementServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
//        $this->app->register(PluginTemplateServiceProvider::class);
        $this->app->register(UserManagementServiceProvider::class);
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
