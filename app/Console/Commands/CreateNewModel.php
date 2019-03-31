<?php

namespace App\Console\Commands;

use App\Generators\Generators\ClassGenerator;
use App\Generators\Generators\ConfigGenerator;
use App\Generators\Generators\ContractGenerator;
use App\Generators\Generators\ControllerGenerator;
use App\Generators\Generators\EloquentGenerator;
use App\Generators\Generators\HelperGenerator;
use App\Generators\Generators\ModelGenerator;
use App\Generators\Generators\PolicyGenerator;
use App\Generators\Generators\PresenterGenerator;
use App\Generators\Generators\RequestGenerator;
use App\Generators\Generators\RouteFileGenerator;
use App\Generators\Generators\TransformerGenerator;
use App\Generators\Generators\TranslationFileGenerator;
use App\Generators\Generators\ViewGenerator;
use App\User;
use Illuminate\Console\Command;
use Plugins\PluginTemplate\Models\PluginTemplate;

class CreateNewModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

        $barCount = 0;

        $users = User::query()->limit(5)->select(['name', 'email'])->get();

        $this->question('a7aaa');
        $this->comment('a7aaa');
        $this->line('a7aaa');
        $this->info('a7aaa');
        $this->error('a7aaa');

        $plugins = config('plugins.plugins_list');
        $pluginsNames = array_keys($plugins);
        $pluginsAliases = array_values($plugins);


        $pluginName = 'UserManagement';
        $class = 'DummyUser';
        $model_namespace = "\Plugins\UserManagement\Models\DummyUser";
        $modelName = 'majd';
//        $plauginPath = $this->getBaseBath($pluginName);


        /*

        php artisan make:migration create_majd_table --create=majds --path="Plugins/UserManagement/database/migrations"
        php artisan make:seeder UsersTableSeeder --path="Plugins/UserManagement/database/migrations"
         */

        $viewGenerator = new ViewGenerator([
            'pluginName' => $pluginName,
            'class' => $class,
            'view' => 'index',
        ]);

        $viewGenerator->run();
        dd('fuck you');


        $translationFileGenerator = new TranslationFileGenerator([
            'pluginName' => $pluginName,
            'locale' => 'majd',
            'class' => $class
        ]);

        $translationFileGenerator->run();


        $routeFileGenerator = new RouteFileGenerator([
            'pluginName' => $pluginName,
            'route_file' => 'api'
        ]);
        $routeFileGenerator->run();

        $controllerGenerator = new ControllerGenerator([
            'pluginName' => $pluginName,
            'class' => $class,
        ]);

        $controllerGenerator->run();

        dd('a7aaaa');
        $requestGenerator = new RequestGenerator([
            'pluginName' => $pluginName,
            'class' => $class,
            'model_namespace' => $model_namespace,
        ]);

        $requestGenerator->run();

        dd('fuck');

        $classGenerator = new ClassGenerator([
            'pluginName' => $pluginName,
            'class' => $class,
        ]);

        $helperGenerator = new HelperGenerator([
            'pluginName' => $pluginName,
            'class' => $class,
        ]);

        $classGenerator->run();
        $helperGenerator->run();

        dd('fuck');


        $contractGenerator = new ContractGenerator([
            'pluginName' => $pluginName,
            'class' => $class,
        ]);

        $contractGenerator->run();


        $eloquentGenerator = new EloquentGenerator([
            'pluginName' => $pluginName,
            'class' => $class,
            'model_namespace' => $model_namespace,
        ]);

        $eloquentGenerator->run();


        $transformerGenerator = new TransformerGenerator([
            'pluginName' => $pluginName,
            'class' => $class,
            'model_namespace' => $model_namespace,
        ]);


        $presenterGenerator = new PresenterGenerator([
            'pluginName' => $pluginName,
            'class' => $class,
        ]);

        $policyGenerator = new PolicyGenerator([
            'pluginName' => $pluginName,
            'class' => 'User',
            'model' => \Plugins\UserManagement\Models\User::class,
            'class_object' => 'user2',
        ]);

        $modelGenerator = new ModelGenerator([
            'pluginName' => $pluginName,
            'class' => 'MajdModel',
            'table_name' => 'majd_table',
        ]);


        $configGenerator = new ConfigGenerator([
            'pluginName' => $pluginName,
            'modelName' => 'MajdModel',
            'tableName' => 'majd_table',
            'modelPath' => \Plugins\UserManagement\Models\User::class,
        ]);


        dd('aaa');

        list($pluginName, $modelName, $tableName, $withSeeder, $withPresenterAndTransformer) = $this->commandQuestions($pluginsNames);

        $baseBath = $this->getBaseBath($pluginName);


        $bar = $this->output->createProgressBar(count($users));

        $bar->start();

        foreach ($users as $user) {
            $this->performTask($user);

            $bar->advance();
        }

        $bar->finish();

    }


    public function performTask($user)
    {
        $this->error($user->name);
    }


    private function commandQuestions($pluginsNames)
    {
        $this->question('Answer The following questions please');

        $modelName = null;
        while (is_null($modelName)) {
            $modelName = $this->ask('What is your model name?');
            if (is_null($modelName)) {
                $this->error('Model name can\'t be null');
            }
        }

        $pluginName = $this->choice('What is your package name?', $pluginsNames);

        $tableName = null;
        while (is_null($tableName)) {
            $tableName = $this->ask('What is your table name?');
            if (is_null($tableName)) {
                $this->error('Table name can\'t be null');
            }
        }

        $withSeeder = $this->choice('do you want to create seeder file?', ['yes', 'no'], 'yes');

        $withPresenterAndTransformer = $this->choice('do you want to create presenter and transformer files?', ['yes', 'no'], 'yes');

        return [$pluginName, $modelName, $tableName, $withSeeder, $withPresenterAndTransformer];
    }

}
