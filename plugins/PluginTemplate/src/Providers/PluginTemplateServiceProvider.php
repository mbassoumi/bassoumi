<?php
/**
 * Created by PhpStorm.
 * User: mbbas
 * Date: 3/28/2019
 * Time: 4:17 PM
 */

namespace BassoumiPlugins\PluginTemplate\providers;

use Illuminate\Support\ServiceProvider;

class PluginTemplateServiceProvider  extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php', 'plugin_template'
//            'C:\wamp64\www\bassoumi\plugins\PluginTemplate\config\config.php', 'plugin_template'
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //

        $this->loadViewsFrom(__DIR__."/../../resources/views", 'plugin_template');
        $this->loadTranslationsFrom(__DIR__."/../../resources/lang", 'plugin_template');
        $this->loadRoutesFrom(__DIR__."/../../routes");
        $this->loadMigrationsFrom(__DIR__."/../../database/migrations");
    }
}
