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

class RequestGenerator extends Generator
{
    protected $pluginName;
    protected $path;
    protected $namespace;
    protected $replaces = [];
    protected $modelName;
    protected $fileTemplateName = 'request';
    protected $fileName;


    public function __construct(array $options)
    {
        parent::__construct();

        $this->pluginName = $options['pluginName'];
        $this->namespace = "Plugins\\$this->pluginName\\Http\\Requests";
        $this->modelName = $options['class'];
        $this->fileName = $this->modelName.'Request';
        $this->setReplaces($options);
    }

    public function getPath()
    {
        return "{$this->getBaseBath($this->pluginName)}/src/Http/Requests";
    }

    public function setReplaces($options)
    {
        $this->replaces['date'] = Carbon::now()->format('d-m-Y');
        $this->replaces['time'] = Carbon::now()->format('g:i A');
        $this->replaces['class'] = $options['class'];
        $this->replaces['namespace'] = $this->namespace;
        $this->replaces['route'] = Str::lower(Str::singular($options['class']));
        $this->replaces['model_namespace'] = $options['model_namespace'];
    }

    public function infoMessage()
    {
        return "$this->fileName has been generated successfully";
    }
}
