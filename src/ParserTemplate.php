<?php

namespace WikiConnect\ParseWiki;

use WikiConnect\ParseWiki\DataModel\Template;

class ParserTemplate
{
    private string $templateText;
    private string $name;
    private array $parameters;
    private string $pipe = "|";
    private string $pipeR = "-_-";
    public function __construct(string $templateText)
    {
        $this->templateText = trim($templateText);
        $this->parameters = array();
        $this->parse();
    }
    public function parse(): void
    {
        if (preg_match("/^\{\{(.*?)(\}\})$/s", $this->templateText, $matchesR)) {
            $DTemplate = $matchesR[1];
            $matches = [];
            preg_match_all("/\{\{(.*?)\}\}/", $DTemplate, $matches);
            foreach ($matches[1] as $matche) {
                $DTemplate = str_replace($matche, str_replace($this->pipe, $this->pipeR, $matche), $DTemplate);
            }
            $matches = [];
            preg_match_all("/\[\[(.*?)\]\]/", $DTemplate, $matches);
            foreach ($matches[1] as $matche) {
                $DTemplate = str_replace($matche, str_replace($this->pipe, $this->pipeR, $matche), $DTemplate);
            }

            $params = explode("|", $DTemplate);
            $pipeR = $this->pipeR;
            $pipe = $this->pipe;
            $params = array_map(function ($string) use ($pipeR, $pipe) {
                return str_replace($pipeR, $pipe, $string);
            }, $params);
            $data = [];
            $this->name = $params[0];
            for ($i = 1; $i < count($params); $i++) {
                $param = $params[$i];
                if (strpos($param, "=") !== false) {
                    $parts = explode("=", $param, 2);
                    $key = trim($parts[0]);
                    $value = trim($parts[1]);
                    $data[$key] = $value;
                } else {
                    $data[$i] = $param;
                }
            }
            $this->parameters = $data;
        }
    }
    public function getTemplate(): Template
    {
        return new Template($this->name, $this->parameters, $this->templateText);
    }
}
