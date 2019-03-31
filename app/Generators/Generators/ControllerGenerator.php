<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 2019-03-30
 * Time: 15:58
 */

namespace App\Generators\Generators;


use App\Generators\Generator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ControllerGenerator extends Generator
{
    protected $pluginName;
    protected $path;
    protected $namespace;
    protected $replaces = [];
    protected $modelName;
    protected $fileTemplateName = 'controller';
    protected $fileName;


    public function __construct(array $options)
    {
        parent::__construct();

        $this->pluginName = $options['pluginName'];
        $this->namespace = "Plugins\\$this->pluginName\\Http\\Controllers";
        $this->modelName = $options['class'];
        $this->fileName = $this->modelName.'Controller';
        $this->setReplaces($options);
    }

    public function getPath()
    {
        return "{$this->getBaseBath($this->pluginName)}/src/Http/Controllers";
    }

    public function setReplaces($options)
    {
        $this->replaces['date'] = Carbon::now()->format('d-m-Y');
        $this->replaces['time'] = Carbon::now()->format('g:i A');
        $this->replaces['class'] = $options['class'];
        $this->replaces['controller'] = $options['class'];
        $this->replaces['namespace'] = $this->namespace;
        $this->replaces['repository_namespace'] = "Plugins\\$this->pluginName\\Repositories\\Contracts\\".$options['class']."Repository";
        $this->replaces['request_namespace'] = "Plugins\\$this->pluginName\\Http\\Requests\\".$options['class']."Request";
        $this->replaces['plural'] = Str::lower(Str::plural($options['class']));
        $this->replaces['singular'] = Str::lower(Str::singular($options['class']));
        $this->replaces['model_namespace'] = "Plugins\\$this->pluginName\\Models\\".$options['class'];

    }

    public function infoMessage()
    {
        return "$this->fileName has been generated successfully";
    }
}
