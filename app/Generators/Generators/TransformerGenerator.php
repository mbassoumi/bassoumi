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

class TransformerGenerator extends Generator
{
    protected $pluginName;
    protected $path;
    protected $namespace;
    protected $replaces = [];
    protected $modelName;
    protected $fileTemplateName = 'transformer';
    protected $fileName;


    public function __construct(array $options)
    {
        parent::__construct();

        $this->pluginName = $options['pluginName'];
        $this->namespace = "Plugins\\$this->pluginName\\Presenters\Transformers";
        $this->modelName = $options['class'];
        $this->fileName = $this->modelName.'Transformer';
        $this->setReplaces($options);
    }

    public function getPath()
    {
        return "{$this->getBaseBath($this->pluginName)}/src/Presenters/Transformers";
    }

    public function setReplaces($options)
    {
        $this->replaces['date'] = Carbon::now()->format('d-m-Y');
        $this->replaces['time'] = Carbon::now()->format('g:i A');
        $this->replaces['class'] = $options['class'];
        $this->replaces['class_object'] = lcfirst($options['class']);
        $this->replaces['namespace'] = $this->namespace;
        $this->replaces['model_namespace'] = "Plugins\\$this->pluginName\\Models\\".$options['class'];
        $this->replaces['transformer'] = "Plugins\\$this->pluginName\\Presenters\\Transformers\\".$this->modelName."Transformer";
    }

    public function infoMessage()
    {
        return "$this->fileName has been generated successfully";
    }
}
