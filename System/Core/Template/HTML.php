<?php

namespace System\Core\Template;

use System\Core\Config;
use System\Core\Response;

class HTML implements CommonInterface
{
    protected $theme;

    protected $config;
    protected $response;

    public function __construct(Config $config, Response $response)
    {
        $this->config = $config;
        $this->response = $response;

        $this->theme = $this->config->template('theme')->read('');
    }

    public function render()
    {
        $templateFile = WEB . "/templates/{$this->theme}/index.html";

        if(file_exists($templateFile)){
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
        $templateFile = WEB . "/templates/{$this->theme}/{$template}.html";

        if(file_exists($templateFile)){
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
            $templateFile = WEB . "/templates/{$this->theme}/assets/errors/response.html";

            if(file_exists($templateFile)){
                return render($templateFile, [
                    'code' => $code,
                    'render' => $this
                ]);
            }
        }
        return false;
    }
}