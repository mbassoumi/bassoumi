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

        require_once(__DIR__ .'/../helpers.php');

        //
//        $this->app->register(PluginTemplateServiceProvider::class);
        /*
         * register MyNewPluginServiceProvider
         */
        $this->app->register(UserManagementServiceProvider::class);


        /**$$::DONT REMOVE THIS COMMENT FOR GENERATION COMMAND::$$*/

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
