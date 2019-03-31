<?php

namespace App\Console\Commands;

use App\Generators\Generators\ConfigGenerator;
use App\Generators\Generators\HelperGenerator;
use App\Generators\Generators\ProviderGenerator;
use App\Generators\Generators\RouteFileGenerator;
use Illuminate\Console\Command;

class CreateNewPlugin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * plugin name
     *
     * @var string
     */
    protected $pluginName;

    /**
     * plugin alias
     *
     * @var
     */
    protected $pluginAlias;


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

        $this->generators = [];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

//        $this->commandQuestions();

        $this->pluginName = 'DummyPlugin';
        $this->pluginAlias = 'dummy_plugin';
        /*
         * plugin Routes Generators
         */
        $this->routesGenerator();

        /*
         * plugin Providers Generators
         */
        $this->providersGenerator();

        /*
         * plugin config generator
         */
        $this->generators[] = new ConfigGenerator([
            'pluginName' => $this->pluginName,
            'pluginAlias' => $this->pluginAlias,
        ]);

        /*
         * plugin helper generator
         */
        $this->generators[] = new HelperGenerator([
            'pluginName' => $this->pluginName,
        ]);


        $bar = $this->output->createProgressBar(count($this->generators));

        $bar->start();

        foreach ($this->generators as $generator) {
            try {
                $generator->run();
                $bar->advance();
                $this->info($generator->infoMessage());
            }catch (\Exception $exception){
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
     * fill $this->>pluginName
     * fill $this->>pluginAlias
     */
    private function commandQuestions()
    {
        $this->question('Answer The following questions please');

        $this->pluginName = null;
        while (true) {
            $this->pluginName = $this->ask('What is your new plugin name?');
            if ($this->isValidPluginName($this->pluginName)) {
                break;
            }
            $this->error('Invalid Plugin Name');
        }

        $this->pluginAlias = null;
        while (true) {
            $this->pluginAlias = $this->ask('What is your new plugin alias?');
            if ($this->isValidPluginAlias($this->pluginAlias)) {
                break;
            }
            $this->error('Invalid Plugin Alias');
        }

    }


    /**
     * check if plugin name is valid
     *
     * @param $pluginName
     * @return bool
     */
    private function isValidPluginName($pluginName)
    {
        if (is_null($pluginName)
            or in_array($pluginName, $this->allPluginsNames)
            or !preg_match('/^[A-Z][a-zA-Z]+$/', $pluginName)) {
            return false;
        }
        return true;
    }

    /**
     * check if plugin alias is valid
     *
     * @param $pluginName
     * @return bool
     */
    private function isValidPluginAlias($pluginAlias)
    {
        if (is_null($pluginAlias)
            or in_array($pluginAlias, $this->allPluginsAliases)
            or !preg_match('/^[a-z_]+$/', $pluginAlias)) {
            return false;
        }
        return true;
    }


    /**
     * get routes generator objects
     */
    private function routesGenerator()
    {
        $routes = [
            'api',
            'web',
            'console',
            'channel',
        ];

        foreach ($routes as $route) {
            $this->generators[] = new RouteFileGenerator([
                'pluginName' => $this->pluginName,
                'route_file' => $route
            ]);
        }
    }


    /**
     * get providers generator objects
     */
    public function providersGenerator()
    {
        $providers = [
            'Config',
            'Helper',
            'Route',
            $this->pluginName
        ];

        foreach ($providers as $provider) {
            $this->generators[] = new ProviderGenerator([
                'pluginName' => $this->pluginName,
                'class' => $provider,
                'alias' => $this->pluginAlias,
            ]);
        }

    }


}
