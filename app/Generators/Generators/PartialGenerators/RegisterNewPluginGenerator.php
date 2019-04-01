<?php


namespace App\Generators\Generators\PartialGenerators;


use App\Generators\Generator;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class RegisterNewPluginGenerator extends Generator
{
    protected $pluginName;
    protected $path;
    protected $namespace;
    protected $replaces = [];
    protected $modelName;
    protected $fileTemplateName = 'add_plugin_to_app_service_provider';
    protected $fileName;

    protected $pluginAlias;
    protected $class;

    protected $replaceHint = '/**$$::DONT REMOVE THIS COMMENT FOR GENERATION COMMAND::$$*/';
    protected $registerContent;

    protected $readFromPath;

    public function __construct(array $options)
    {
        parent::__construct();

        $this->pluginName = $options['pluginName'];
        $this->class = $options['pluginName'];

        $this->fileName = 'web';
        $this->getRefisterMethod($options);
        $this->readFromPath =  base_path('app').'/Providers/AppServiceProvider.php';
        $this->setReplaces($options);
    }

    public function getPath()
    {
        return "{$this->getBaseBath($this->pluginName)}/routes";
    }

    public function setReplaces($options)
    {
        $this->replaces['date'] = Carbon::now()->format('d-m-Y');
        $this->replaces['time'] = Carbon::now()->format('g:i A');
        $this->replaces[$this->replaceHint] = $this->registerContent;

    }

    public function getRefisterMethod($options)
    {
        $this->replaces['class'] = $options['pluginName'];
        $this->replaces['class_namespace'] = "\\Plugins\\{$this->pluginName}\\Providers\\{$options['pluginName']}ServiceProvider";
        $content = $this->getFileTemplate();
        $this->registerContent = $content . PHP_EOL . '          ' . PHP_EOL . $this->replaceHint;
    }

    public function infoMessage()
    {
        return "the plugin has been registered in AppServiceProvider successfully";
    }

}
