<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 2019-03-29
 * Time: 23:12
 */

namespace Plugins\UserManagement\Providers;

use Illuminate\Support\ServiceProvider;


class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(__DIR__.'/../../config/*.php') as $file) {
            $file_name = pathinfo($file)['filename'];
            $this->mergeConfigFrom($file, $file_name);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}