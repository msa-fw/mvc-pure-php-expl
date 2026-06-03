<?php

namespace Controllers\Home\Cron;

use System\Core;
use function console\text;
use function console\success;
use function language\translate;
use function filesystem\scan_callback;

class UpdateCronTask
{
    protected $archives;
    protected $extracted;

    protected $config;

    public function __construct()
    {
        $this->config = Core::Config();
        $this->archives = ROOT . "/../tmp/updater";
        $this->extracted = "{$this->archives}/extracted";

        if(!is_dir($this->archives)){ mkdir($this->archives, 0777, true); }
        if(!is_dir($this->extracted)){ mkdir($this->extracted, 0777, true); }
    }

    public function exec()
    {
        if($filepath = $this->downloadLatestScriptVersion()){
            if($this->extractFiles($filepath)){
                $this->copyFiles();
            }
        }
        return true;
    }

    protected function downloadLatestScriptVersion()
    {
        if($link = $this->config->controller('Home', 'updater', 'targetLink')->read()){
            if($content = file_get_contents($link)){
                $filename = md5($content);
                $filepath = "{$this->archives}/{$filename}.zip";

                if(file_put_contents($filepath, $content)){
                    print translate('cli.updater.fileSaved', [
                        '%file%' => trim(success($filepath))
                    ]);
                    return $filepath;
                }
            }
        }
        return false;
    }

    protected function extractFiles($filepath)
    {
        $zip = new \ZipArchive();
        if($zip->open($filepath) === true){
            $zip->extractTo($this->extracted);
            $zip->close();
            return true;
        }
        return false;
    }

    protected function copyFiles()
    {
        $ignore = [
            '_.htaccess',
            'install',
            '.gitignore',
            'composer.json',
        ];

        foreach(scandir($this->extracted) as $root){
            if(in_array($root, ['.', '..'])){ continue; }

            scan_callback("{$this->extracted}/{$root}", function($directory, $file, $isDirectory)use($root, $ignore){
                if(!$isDirectory){
                    $target = "{$directory}/{$file}";

                    $relative = str_replace("{$this->extracted}/{$root}", '', $target);
                    $relative = trim($relative, '/');

                    if(strpos($relative, '.Controllers') !== false){
                        if(!$this->config->controller('Home', 'updater', 'rewriteControllerDirectory')->read()){ return; }
                        $relative = str_replace('.Controllers', 'Controllers', $relative);
                    }

                    if(in_array($relative, $ignore)){ return; }

                    $destination = ROOT . "/$relative";
                    $destinationDirectory = dirname($destination);

                    if(!is_dir($destinationDirectory)){ mkdir($destinationDirectory, 0777, true); }

                    if(rename($target, $destination)){
                        print translate('cli.make.fileSavedToPath', [
                                '%target%' => trim(text($target, 46)),
                                '%destination%' => trim(success($destination)),
                            ]) . PHP_EOL;
                    }
                }
            });

            scan_callback("{$this->extracted}/{$root}", function($directory, $file, $isDirectory)use($root, $ignore){
                $path = $directory;
                if($file){ $path .= "/{$file}"; }

                if(file_exists($path)){
                    if($isDirectory){
                        return rmdir($path);
                    }
                    return unlink($path);
                }
                return null;
            });
        }
    }
}