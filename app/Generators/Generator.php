<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 2019-03-30
 * Time: 15:41
 */

namespace App\Generators;


use Illuminate\Filesystem\Filesystem;
use Prettus\Repository\Generators\FileAlreadyExistsException;

class Generator
{


    protected $filesystem;
    protected $fileTemplateName;
    protected $replaces;
    protected $pluginName;
    protected $path;
    protected $namespace;
    protected $modelName;
    protected $fileName;


    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }


    public function run()
    {
        $path = $this->getPath(). "/".$this->fileName.".php";
        if ($this->filesystem->exists($path)) {
            $error_message = "$this->fileName.php is already exist in $path";
            throw new FileAlreadyExistsException($error_message);
        }

        if (!$this->filesystem->isDirectory($dir = dirname($path))) {
            $this->filesystem->makeDirectory($dir, 0777, true, true);
        }
        $content = $this->getFileTemplate();

        return $this->filesystem->put($path, $content);
    }

    public function getPath()
    {
        return base_path('Plugins');
    }


    public function getBaseBath($pluginName){
        return base_path("Plugins/{$pluginName}");
    }

    public function getFileTemplate()
    {

        $fileTemplatePath = base_path(config("plugins.templates_path.{$this->fileTemplateName}"));

        if(!file_exists( "{$fileTemplatePath}.file_template")){
            $path = __DIR__;
        }
        return $this->getContents("{$fileTemplatePath}.file_template");
    }

    /**
     * get template contents and replace its variable
     *
     * @param $file
     * @return false|mixed|string
     */
    public function getContents($file)
    {
        $contents = file_get_contents($file);
        foreach ($this->replaces as $search => $replace) {
            $contents = str_replace('$' . strtoupper($search) . '$', $replace, $contents);
        }

        return $contents;
    }
}
