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

class TranslationFileGenerator extends Generator
{
    protected $pluginName;
    protected $path;
    protected $namespace;
    protected $replaces = [];
    protected $modelName;
    protected $fileTemplateName = 'lang';
    protected $fileName;

    protected $locale;

    public function __construct(array $options)
    {
        parent::__construct();

        $this->pluginName = $options['pluginName'];
        $this->fileName = Str::lower($options['class']);
        $this->locale = $options['locale'];
        $this->setReplaces($options);
    }

    public function getPath()
    {
        return "{$this->getBaseBath($this->pluginName)}/resources/lang/{$this->locale}";
    }

    public function setReplaces($options)
    {
        $this->replaces['date'] = Carbon::now()->format('d-m-Y');
        $this->replaces['time'] = Carbon::now()->format('g:i A');
    }
}
