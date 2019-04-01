<?php


namespace App\Generators\Generators\PartialGenerators;


use App\Generators\Generator;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class RegisterBindingsGenerator extends Generator
{
    protected $pluginName;
    protected $path;
    protected $namespace;
    protected $replaces = [];
    protected $modelName;
    protected $fileTemplateName = 'bindings';
    protected $fileName;

    protected $pluginAlias;
    protected $class;

    protected $replaceHint = '/**$$::DONT REMOVE THIS COMMENT FOR GENERATION COMMAND::$$*/';
    protected $bindingContent;

    protected $readFromPath;

    public function __construct(array $options)
    {
        parent::__construct();

        $this->pluginName = $options['pluginName'];
        $this->class = $options['class'];

        $this->fileName = $options['pluginName'].'ServiceProvider';
        $this->getBindings($options);
        $this->readFromPath = $this->getPath().'/'.$options['pluginName'].'ServiceProvider.php';
        $this->setReplaces($options);
    }

    public function getPath()
    {
        return "{$this->getBaseBath($this->pluginName)}/src/Providers";
    }

    public function setReplaces($options)
    {
        $this->replaces['date'] = Carbon::now()->format('d-m-Y');
        $this->replaces['time'] = Carbon::now()->format('g:i A');
        $this->replaces[$this->replaceHint] = $this->bindingContent;

    }

    public function getBindings($options)
    {
        $this->replaces['class'] = $options['class'];
        $this->replaces['repository'] = "\\Plugins\\{$this->pluginName}\\Repositories\\Contracts\\{$options['class']}Repository";
        $this->replaces['eloquent'] = "\\Plugins\\{$this->pluginName}\\Repositories\\Eloquent\\{$options['class']}RepositoryEloquent";

        $content = $this->getFileTemplate();
        $this->bindingContent = $content . PHP_EOL . '          ' . $this->replaceHint;
    }

    public function infoMessage()
    {
        return "binding has been done successfully";
    }
}
