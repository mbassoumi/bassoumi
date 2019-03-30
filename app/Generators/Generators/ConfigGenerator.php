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

class ConfigGenerator extends Generator
{
    protected $pluginName;
    protected $path;
    protected $namespace;
    protected $replaces = [];
    protected $modelName;
    protected $fileTemplateName = 'config';
    protected $fileName;


    public function __construct(array $options)
    {
        parent::__construct();
        $this->pluginName = $options['pluginName'];
        $this->modelName = strtolower($options['modelName']);
        $this->fileName = strtolower($options['modelName']);
        $this->setReplaces($options);
    }

    public function getPath()
    {
        return "{$this->getBaseBath($this->pluginName)}/config";
    }

    public function setReplaces($options)
    {
        $this->replaces['date'] = Carbon::now()->format('d-m-Y');
        $this->replaces['time'] = Carbon::now()->format('g:i A');
        $this->replaces['model'] = $options['modelName'];
        $this->replaces['table'] = $options['tableName'];
        $this->replaces['modelPath'] = $options['modelPath'];
    }
}