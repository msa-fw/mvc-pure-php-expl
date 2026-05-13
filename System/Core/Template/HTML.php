<?php

namespace System\Core\Template;

use System\Core\Config;
use System\Core\Request;
use System\Core\Response;

class HTML implements CommonInterface
{
    protected $debug;

    protected $theme;
    protected $webDirectory;
    protected $webRootDirectory;

    protected $config;
    protected $request;
    protected $response;

    protected $scripts = [];
    protected $styles = [];

    public function __construct(Config $config, Request $request, Response $response)
    {
        $this->config = $config;
        $this->request = $request;
        $this->response = $response;

        $this->debug = $this->config->general('debug')->read(false);
        $this->theme = $this->config->template('theme')->read('');
        $this->webDirectory = $this->config->general('webDirectory')->call(function($value){
            return $value ? trim($value, '/') : null;
        })->read('web');

        $this->webRootDirectory = ROOT . "/{$this->webDirectory}";
    }

    public function render()
    {
        if(file_exists($templateFile = $this->getAbsolutePath("index.html"))){
            return render($templateFile, [
                'render' => $this,
            ]);
        }
        return '';
    }

    public function renderController()
    {
        if($error = $this->renderError()){
            return $error;
        }

        $template = $this->response->template()->read('');
        if(file_exists($templateFile = $this->getAbsolutePath("{$template}.html"))){
            return render($templateFile, [
                'render' => $this,
                'content' => $this->response->content()->read([])
            ]);
        }

        $this->response->code()->write(500);
        return $this->renderController();
    }

    protected function renderError()
    {
        $code = $this->response->code()->read(500);
        if($code > 399){
            if(file_exists($templateFile = $this->getAbsolutePath("assets/errors/response.html"))){
                return render($templateFile, [
                    'code' => $code,
                    'method' => $this->request->server('request-method')->read(''),
                    'render' => $this
                ]);
            }
        }
        return false;
    }

    public function renderWidget(array $widgets)
    {
        $result = [];
        foreach($widgets as $widget){
            if($widget['result'] && file_exists($templateFile = $this->getAbsolutePath("{$widget['template']}.html"))){
                $result[] = render($templateFile, $widget['result']);
            }
        }
        return implode("\n", $result);
    }

    public function js($file, array $attributes = [])
    {
        $file = dirname($file) . '/' . pathinfo($file, PATHINFO_FILENAME);

        $attributes['type'] = 'text/javascript';
        $attributes['src'] = $this->getScriptOrStyleFilePath("{$file}.js");

        $this->scripts[$file] = $attributes;
        return $this;
    }

    public function css($file, array $attributes = [])
    {
        $file = dirname($file) . '/' . pathinfo($file, PATHINFO_FILENAME);

        $attributes['rel'] = 'stylesheet';
        $attributes['href'] = $this->getScriptOrStyleFilePath("{$file}.css");

        $this->styles[$file] = $attributes;
        return $this;
    }

    public function renderScripts()
    {
        $result = [];
        foreach($this->scripts as $key => $attributes){
            if(!$attributes){ continue; }
            unset($this->scripts[$key]);

            $_attributes = [];
            foreach($attributes as $name => $value){
                $_attributes[] = "{$name}=\"{$value}\"";
            }
            $result[] = "<script " . implode(' ', $_attributes) . "></script>";
        }
        return implode(PHP_EOL, $result) . PHP_EOL;
    }

    public function renderStyles()
    {
        $result = [];
        foreach($this->styles as $key => $attributes){
            if(!$attributes){ continue; }
            unset($this->styles[$key]);

            $_attributes = [];
            foreach($attributes as $name => $value){
                $_attributes[] = "{$name}=\"{$value}\"";
            }
            $result[] = "<link " . implode(' ', $_attributes) . ">";
        }
        return implode(PHP_EOL, $result) . PHP_EOL;
    }

    protected function getScriptOrStyleFilePath($file)
    {
        if(!preg_match("#^http#", $file)){
            $file = trim($file, '/');

            if($this->debug){
                if(file_exists($fileAbsolutePath = $this->getAbsolutePath($file))){
                    $file .= "?" . fileatime($fileAbsolutePath);
                }
            }
            $file = $this->getRelativePath($file);
        }
        return $file;
    }

    protected function getRelativePath($file)
    {
        return "/{$this->webDirectory}/templates/{$this->theme}/" . trim($file, '/');
    }

    protected function getAbsolutePath($file)
    {
        return "{$this->webRootDirectory}/templates/{$this->theme}/" . trim($file, '/');
    }
}