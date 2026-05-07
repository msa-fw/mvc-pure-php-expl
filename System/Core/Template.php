<?php

namespace System\Core;

use System\Core;

class Template
{
    protected $config;
    protected $response;

    public function __construct()
    {
        $this->config = Core::Config();
        $this->response = Core::Response();
    }

    public function render()
    {
        Core::Events()->beforeTemplateRender()->run();

        $result = $this->renderContent();
        $this->sendHeaders();

        Core::Events()->afterTemplateRender()->run();

        return $result;
    }

    public function sendHeaders()
    {
        $code = $this->response->code()->read(500);

        http_response_code($code);

        foreach($this->response->headers()->read([]) as $key => $value){
            header("{$key}: {$value}", true, $code);
        }
        return $this;
    }

    public function renderContent()
    {
        /** @var Core\Template\CommonInterface $renderObject */

        $renderClass = $this->config->template('renderClass')->read();
        if(method_exists($renderClass, 'render')){
            $renderObject = new $renderClass($this->config, $this->response);
            return $renderObject->render();
        }
        return '';
    }
}