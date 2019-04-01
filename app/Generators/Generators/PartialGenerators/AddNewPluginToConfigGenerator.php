<?php


namespace App\Generators\Generators\PartialGenerators;


use App\Generators\Generator;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AddNewPluginToConfigGenerator extends Generator
{
    protected $pluginName;
    protected $path;
    protected $namespace;
    protected $replaces = [];
    protected $modelName;
    protected $fileTemplateName = 'add_plugin_to_config';
    protected $fileName;

    protected $pluginAlias;
    protected $class;

    protected $replaceHint = '/**$$::DONT REMOVE THIS COMMENT FOR GENERATION COMMAND::$$*/';
    protected $configContent;

    protected $readFromPath;

    public function __construct(array $options)
    {
        parent::__construct();

        $this->pluginName = $options['pluginName'];
        $this->class = $options['pluginName'];

        $this->fileName = 'plugins';
        $this->getConfigParam($options);
        $this->readFromPath = base_path('config').'/plugins.php';
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
        $this->replaces[$this->replaceHint] = $this->configContent;

    }

    public function getConfigParam($options)
    {
        $this->replaces['class'] = $options['pluginName'];
        $this->replaces['alias'] = $options['pluginAlias'];
        $content = $this->getFileTemplate();
        $this->configContent = $content . PHP_EOL . '          ' . $this->replaceHint;
    }


    public function infoMessage()
    {
        return "the plugin has been registered in config successfully";
    }

}
