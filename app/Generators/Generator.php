<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 2019-03-30
 * Time: 15:41
 */

namespace App\Generators;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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

    protected $replaceHint;


    protected $readFromPath = null;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }


    public function run()
    {
        if (is_null($this->readFromPath)) {
            $path = $this->getPath() . "/" . $this->fileName . ".php";
            if ($this->filesystem->exists($path)) {
                $error_message = "$this->fileName.php is already exist in $path";
                throw new FileAlreadyExistsException($error_message);
            }
            if (!$this->filesystem->isDirectory($dir = dirname($path))) {
                $this->filesystem->makeDirectory($dir, 0777, true, true);
            }
        }else{
            $path = $this->readFromPath;
        }

        $content = $this->getFileTemplate();
//        dd($content);
//        dd($content);
//        if ($this->fileExist){
//            \File::put($this->getPath(), str_replace($this->bindPlaceholder, "\$this->app->bind({$repositoryInterface}, $repositoryEloquent);" . PHP_EOL . '        ' . $this->bindPlaceholder, $provider));
//
//        }else{
        return $this->filesystem->put($path, $content);
//        }
    }

    public function getPath()
    {
        return base_path('Plugins');
    }


    public function getBaseBath($pluginName)
    {
        return base_path("Plugins/{$pluginName}");
    }

    public function getFileTemplate()
    {

        if (is_null($this->readFromPath)) {
            $fileTemplatePath = base_path(config("plugins.templates_path.{$this->fileTemplateName}")) . ".file_template";
        } else {
            $fileTemplatePath = $this->readFromPath;
        }

        if (!file_exists($fileTemplatePath)) {
            $path = __DIR__;
        }
        return $this->getContents($fileTemplatePath);
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
            if ($this->replaceHint == $search){
                $contents = str_replace($search, $replace, $contents);
            }else{
                $contents = str_replace('$' . strtoupper($search) . '$', $replace, $contents);
            }
        }

        return $contents;
    }

    public function transferCamelCaseToDashSeparator($string)
    {
        preg_match_all('/((?:^|[A-Z])[a-z]+)/', $string, $matches);
        $matches = Arr::flatten($matches);
        $arr = array_keys(array_flip($matches));
        $newString = implode('-', $arr);
        return $newString;
    }
}
