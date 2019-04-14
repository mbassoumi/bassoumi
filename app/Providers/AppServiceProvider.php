<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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

        require_once(__DIR__ . '/../helpers.php');


        /*
 * register UserManagementServiceProvider
 */
        $this->app->register(\Plugins\UserManagement\Providers\UserManagementServiceProvider::class);

        /*
* register BaseServiceProvider
*/
        $this->app->register(\Plugins\Base\Providers\BaseServiceProvider::class);

        /**$$::DONT REMOVE THIS COMMENT FOR GENERATION COMMAND::$$*/

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        //
    }
}
