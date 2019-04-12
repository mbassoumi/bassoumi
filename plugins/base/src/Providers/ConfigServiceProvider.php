<?php
/**
 * Created by Bassoumi Generation command.
 * User: Majd Bassoumi
 * Date: 12-04-2019
 * Time: 8:03 PM
 */

namespace Plugins\Base\Providers;

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
