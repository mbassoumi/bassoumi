<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 2019-03-30
 * Time: 15:14
 */

return [

    /*
     * list of plugins
     * key      =>      plugin name
     * value    =>      plugin alias
     */

    'plugins_list' => [
        'PluginTemplate' => 'plugin_template',
        'UserManagement' => 'user_management',
    ],

    'templates_path' => [
        'model' => 'app/Generators/Templates/src/Models/model',
        'policy' => 'app/Generators/Templates/src/Policies/policy',
        'config' => 'app/Generators/Templates/config/config',
        'presenter' => 'app/Generators/Templates/src/Presenters/Presenters/presenter',
        'transformer' => 'app/Generators/Templates/src/Presenters/Transformers/transformer',
        'contract' => 'app/Generators/Templates/src/Repositories/Contracts/interface',
        'eloquent' => 'app/Generators/Templates/src/Repositories/Eloquent/eloquent',
        'class' => 'app/Generators/Templates/src/Classes/class',
        'helper' => 'app/Generators/Templates/helpers/helpers',
        'migrations' => 'app/Generators/Templates/database/migrations/create',      //not used
        'seeds' => 'app/Generators/Templates/database/seeds/seed',                  //not used
        'request' => 'app/Generators/Templates/src/Http/Requests/request',
        'controller' => 'app/Generators/Templates/src/Http/Controllers/controller',

        /*
         * routes
         */
        'api' => 'app/Generators/Templates/routes/api',
        'channel' => 'app/Generators/Templates/routes/channels',
        'console' => 'app/Generators/Templates/routes/console',
        'web' => 'app/Generators/Templates/routes/web',

        /*
         * language file
         */
        'lang' => 'app/Generators/Templates/resources/lang/langfile',


        /*
         * model views
         */
        'index' => 'app/Generators/Templates/resources/views/index',
        'create' => 'app/Generators/Templates/resources/views/create',
        'edit' => 'app/Generators/Templates/resources/views/edit',
        'show' => 'app/Generators/Templates/resources/views/show',
        'entry' => 'app/Generators/Templates/resources/views/entry',



        /*
         * providers
         */



    ],
];
