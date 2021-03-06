<?php
/**
 * Created by Bassoumi Generation command.
 * User: Majd Bassoumi
 * Date: 01-04-2019
 * Time: 2:42 PM
 */

namespace Plugins\UserManagement\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(__DIR__ .'/../../helpers/*.php') as $file) {
            require_once($file);
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
