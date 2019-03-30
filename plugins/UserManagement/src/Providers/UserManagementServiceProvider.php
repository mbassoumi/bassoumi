<?php

namespace Plugins\UserManagement\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\UserManagement\Repositories\Contracts\UserRepository;
use Plugins\UserManagement\Repositories\Eloquent\UserRepositoryEloquent;

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

        $this->app->bind(
            UserRepository::class,
            UserRepositoryEloquent::class);
        //:end-bindings:
    }
}
