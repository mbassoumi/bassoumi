<?php


namespace App\Generators\Generators\PartialGenerators;


use App\Generators\Generator;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class RouteGenerator extends Generator
{
    protected $pluginName;
    protected $path;
    protected $namespace;
    protected $replaces = [];
    protected $modelName;
    protected $fileTemplateName = 'model_routes';
    protected $fileName;

    protected $pluginAlias;
    protected $class;

    protected $replaceHint = '/**$$::DONT REMOVE THIS COMMENT FOR GENERATION COMMAND::$$*/';
    protected $routeContent;

    protected $readFromPath;

    public function __construct(array $options)
    {
        parent::__construct();

        $this->pluginName = $options['pluginName'];
        $this->class = $options['class'];

        $this->fileName = 'web';
        $this->getModelRoutes($options);
        $this->readFromPath = $this->getPath().'/web.php';
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
        $this->replaces[$this->replaceHint] = $this->routeContent;

    }

    public function getModelRoutes($options)
    {
        $this->replaces['class'] = $options['class'];
        $this->replaces['group_prefix'] = $this->getRouteGroupPrefix();
        $this->replaces['group_prefix_name'] = $this->getRouteGroupName();
        $content = $this->getFileTemplate();
        $this->routeContent = $content . PHP_EOL . '          ' . PHP_EOL . $this->replaceHint;
    }

    public function getRouteGroupPrefix()
    {
        $pluginNameDashSeparated = $this->transferCamelCaseToDashSeparator($this->pluginName);
        $classNameDashSeparated = $this->transferCamelCaseToDashSeparator(Str::plural($this->class));
        $groupRoute = Str::lower($pluginNameDashSeparated) . '/' . Str::lower($classNameDashSeparated);
        return $groupRoute;
    }

    public function getRouteGroupName()
    {
        $pluginNameDashSeparated = $this->transferCamelCaseToDashSeparator($this->pluginName);
        $classNameDashSeparated = $this->transferCamelCaseToDashSeparator($this->class);
        $groupName = Str::lower($pluginNameDashSeparated) . '.' . Str::lower($classNameDashSeparated);
        return $groupName;
    }

    public function infoMessage()
    {
        return "crud routes have been generated successfully successfully";
    }
}
