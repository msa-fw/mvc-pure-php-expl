<?php

namespace System\Core\Template;

use SimpleXMLElement;
use System\Core\Config;
use System\Core\Request;
use System\Core\Response;

class XML implements CommonInterface
{
    protected $config;
    protected $request;
    protected $response;

    public function __construct(Config $config, Request $request, Response $response)
    {
        $this->config = $config;
        $this->request = $request;
        $this->response = $response;
    }

    public function render()
    {
        $this->response->header('Content-Type', 'application/xml');
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><RootDirectory/>');

        return $this->convert($this->response->content()->read([]), $xml)->saveXML();
    }

    protected function convert($data, SimpleXMLElement $xml = null)
    {
        foreach($data as $key => $value){
            if(is_numeric($key)){$key = "Item_$key";}

            if(is_array($value)){
                if(isset($value['@attributes'])){
                    $child = $xml->addChild($key);
                    foreach($value['@attributes'] as $attrKey => $attrValue){
                        $child->addAttribute($attrKey, $attrValue);
                    }
                    if(isset($value['@value'])){
                        $child[0] = htmlspecialchars($value['@value']);
                    }
                    unset($value['@attributes'], $value['@value']);
                    $this->convert($value, $child);
                }else{
                    $child = $xml->addChild($key);
                    $this->convert($value, $child);
                }
            }else{
                $xml->addChild($key, htmlspecialchars((string)$value));
            }
        }
        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;
        return $dom;
    }
}