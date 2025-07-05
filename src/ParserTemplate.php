<?php

namespace WikiConnect\ParseWiki;

use WikiConnect\ParseWiki\DataModel\Template;

/**
 * Class ParserTemplate
 * Parses a template text into its components: name and parameters.
 *
 * @package WikiConnect\ParseWiki
 */
class ParserTemplate
{
    private string $templateText;
    private string $name;
    private array $parameters;
    private string $pipe = "|";
    private string $pipeR = "-_-";

    /**
     * ParserTemplate constructor.
     *
     * @param string $templateText The template text to parse.
     */
    public function __construct(string $templateText)
    {
        $this->templateText = trim($templateText);
        $this->parameters = array();
        $this->parse();
    }

    /**
     * Parses the template text to extract the template name and parameters.
     *
     * This method does not return any value. It sets the internal state of the
     * object by populating the $name and $parameters properties.
     */
    private function clear_pipes(string $DTemplate): string
    {
        $matches = [];
        // preg_match_all("/\{\{(.*?)\}\}/s", $DTemplate, $matches);
        preg_match_all("/\{\{((?:[^{}]++|(?R))*)\}\}/s", $DTemplate, $matches);

        foreach ($matches[1] as $matche) {
            $DTemplate = str_replace($matche, str_replace($this->pipe, $this->pipeR, $matche), $DTemplate);
        }
        $matches2 = [];

        preg_match_all("/\[\[(.*?)\]\]/", $DTemplate, $matches2);
        foreach ($matches2[1] as $matche) {
            $DTemplate = str_replace($matche, str_replace($this->pipe, $this->pipeR, $matche), $DTemplate);
        }

        return $DTemplate;
    }
    public function parse(): void
    {
        if (preg_match("/^\{\{(.*?)(\}\})$/s", $this->templateText, $matchesR)) {

            $DTemplate = $this->clear_pipes($matchesR[1]);

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

    /**
     * Creates a Template object from the parsed template name and parameters.
     *
     * @return Template The Template object representing the parsed template data.
     */
    public function getTemplate(): Template
    {
        return new Template($this->name, $this->parameters, $this->templateText);
    }
}
