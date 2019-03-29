<?php

namespace Plugins\PluginTemplate\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\PluginTemplate\Repositories\Contracts\PluginTemplateRepository;
use Plugins\PluginTemplate\Repositories\Eloquent\PluginTemplateRepositoryEloquent;

class PluginTemplateServiceProvider extends ServiceProvider
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
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'plugin_template');
        $this->loadViewsFrom(__DIR__.'/../../resources\views', 'plugin_template');

        $this->app->bind(
            PluginTemplateRepository::class,
            PluginTemplateRepositoryEloquent::class);
        //:end-bindings:
    }
}
