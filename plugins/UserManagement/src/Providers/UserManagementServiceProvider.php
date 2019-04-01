<?php
/**
 * Created by Bassoumi Generation command.
 * User: Majd Bassoumi
 * Date: 01-04-2019
 * Time: 2:42 PM
 */

namespace Plugins\UserManagement\Providers;

use Illuminate\Support\ServiceProvider;

class UserManagementServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(HelperServiceProvider::class);
        $this->app->register(ConfigServiceProvider::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'user_management');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'user_management');

        /*
 * register User repository
 */
$this->app->bind(\Plugins\UserManagement\Repositories\Contracts\UserRepository::class, \Plugins\UserManagement\Repositories\Eloquent\UserRepositoryEloquent::class);

          /**$$::DONT REMOVE THIS COMMENT FOR GENERATION COMMAND::$$*/


    }
}
