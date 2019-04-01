<?php

namespace App\Console\Commands;

use App\Generators\Generators\ClassGenerator;
use App\Generators\Generators\ContractGenerator;
use App\Generators\Generators\ControllerGenerator;
use App\Generators\Generators\EloquentGenerator;
use App\Generators\Generators\ModelGenerator;
use App\Generators\Generators\PartialGenerators\RegisterBindingsGenerator;
use App\Generators\Generators\PartialGenerators\RouteGenerator;
use App\Generators\Generators\PolicyGenerator;
use App\Generators\Generators\PresenterGenerator;
use App\Generators\Generators\RequestGenerator;
use App\Generators\Generators\TransformerGenerator;
use App\Generators\Generators\TranslationFileGenerator;
use App\Generators\Generators\ViewGenerator;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

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
    protected $description = 'create a new model with its crud';


    /**
     * plugin name
     *
     * @var string
     */
    protected $pluginName;

    /**
     * model name
     *
     * @var
     */
    protected $modelName;

    /**
     * model name
     *
     * @var
     */
    protected $tableName;


    /**
     * list of all plugins name in system
     *
     * @var array
     */
    protected $allPluginsNames;

    /**
     * list of all plugins aliases in the system
     *
     * @var array
     */
    protected $allPluginsAliases;


    /**
     * plugin generators
     *
     * @var array
     */
    protected $generators;


    protected $filesystem;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();


        $plugins = config('plugins.plugins_list');
        $this->allPluginsNames = array_keys($plugins);
        $this->allPluginsAliases = array_values($plugins);

        $this->filesystem = new Filesystem();
        $this->generators = [];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->commandQuestions();

//        $this->pluginName = 'DummyPlugin';
//        $this->modelName = 'SecondDummyPost';
//        $this->tableName = 'second_dummy_posts';

        /*
         * translations generator
         */
        $this->generators[] = new TranslationFileGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName,
            'locale' => 'en',
        ]);

        /*
         * views generators
         */
        $this->viewsGenerator();


        $this->generators[] = new ClassGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName,
        ]);

        $this->generators[] = new ContractGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName,
        ]);

        $this->generators[] = new ControllerGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName,
        ]);

        $this->generators[] = new EloquentGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName,
        ]);

        $this->generators[] = new ModelGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName,
            'table_name' => $this->tableName
        ]);

        $this->generators[] = new PolicyGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName,
        ]);

        $this->generators[] = new PresenterGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName,
        ]);

        $this->generators[] = new RequestGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName,
        ]);

        $this->generators[] = new TransformerGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName,
        ]);

        $this->generators[] = new RouteGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName
        ]);

        $this->generators[] = new RegisterBindingsGenerator([
            'pluginName' => $this->pluginName,
            'class' => $this->modelName
        ]);


        $barCount = count($this->generators) + 1;

        $bar = $this->output->createProgressBar($barCount);

        $bar->start();

        try {
            $this->migrationGenerator();
            $bar->advance();
            $this->info('migration file has been generated successfully');
        } catch (\Exception $exception) {
            $bar->advance();
            $this->error($exception->getMessage());
        }

        foreach ($this->generators as $generator) {
            try {
                $generator->run();
                $bar->advance();
                $this->info($generator->infoMessage());
            } catch (\Exception $exception) {
                $bar->advance();
                $this->error($exception->getMessage());
            }

        }
        $bar->finish();

        $this->line('');
        $this->question('Plugin has been generated Successfully');
    }


    /**
     * command questions
     *
     * fill $this->pluginName
     * fill $this->modelName
     * fill $this->tableName
     */
    private function commandQuestions()
    {
        $this->question('Answer The following questions please');

        $this->pluginName = $this->choice('What is your plugin name?', $this->allPluginsNames);

        $this->modelName = null;
        while (true) {
            $this->modelName = $this->ask('What is your model name?');
            if ($this->isValidModelName($this->modelName)) {
                break;
            }
            $this->error('Invalid Model Name');
        }

        $this->tableName = null;
        while (true) {
            $this->tableName = $this->ask('What is your database table name?');
            if ($this->isValidTableName($this->tableName)) {
                break;
            }
            $this->error('Invalid Table Name');
        }

    }


    /**
     * check if model name is valid
     *
     * @param $modelName
     * @return bool
     */
    private function isValidModelName($modelName)
    {
        if (is_null($modelName)
            or !preg_match('/^[A-Z][a-zA-Z]+$/', $modelName)) {
            return false;
        }
        return true;
    }

    /**
     * check if database table name is valid
     *
     * @param $tableName
     * @return bool
     */
    private function isValidTableName($tableName)
    {
        if (is_null($tableName)
            or !preg_match('/^[a-z_]+$/', $tableName)) {
            return false;
        }
        return true;
    }


    /**
     * get model views generator objects
     */
    public function viewsGenerator()
    {
        $views = [
            'index',
            'create',
            'edit',
            'show',
            'entry',
        ];

        foreach ($views as $view) {
            $this->generators[] = new ViewGenerator([
                'pluginName' => $this->pluginName,
                'class' => $this->modelName,
                'view' => $view,
            ]);
        }
    }


    public function migrationGenerator()
    {
        $path = "Plugins/$this->pluginName/database/migrations";

        if (!$this->filesystem->isDirectory($path)) {
            $this->filesystem->makeDirectory($path, 0777, true, true);
        }

        Artisan::call('make:migration', [
            'name' => 'create_' . $this->tableName . '_table',
            '--create' => $this->tableName,
            '--path' => $path,
        ]);
    }

}
