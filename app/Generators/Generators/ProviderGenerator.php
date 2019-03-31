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

class ProviderGenerator extends Generator
{
    protected $pluginName;
    protected $path;
    protected $namespace;
    protected $replaces = [];
    protected $modelName;
    protected $fileTemplateName;
    protected $fileName;

    protected $class;


    public function __construct(array $options)
    {
        parent::__construct();

        $this->pluginName = $options['pluginName'];
        $fileTemplateName = Str::lower($options['class']);
        if (!in_array($fileTemplateName, ['config', 'route', 'helper'])){
            $fileTemplateName = 'service_provider';
        }else{
            $fileTemplateName = $fileTemplateName.'_service_provider';
        }
        $this->fileTemplateName = $fileTemplateName;
        $this->fileName = $options['class'] . "ServiceProvider";
        $this->namespace = "Plugins\\$this->pluginName\\Providers";
        $this->class = $options['class'];
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

        $this->replaces['class'] = $options['class'];
        $this->replaces['namespace'] = $this->namespace;
        $this->replaces['controller_namespace'] = "Plugins\\$this->pluginName\\Http\Controllers";
        $this->replaces['alias'] = $options['alias'];
    }

    public function infoMessage()
    {
        return "$this->fileName has been generated successfully";
    }
}
