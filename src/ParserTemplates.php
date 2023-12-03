<?php
namespace WikiConnect\ParseWiki;
use WikiConnect\ParseWiki\DataModel\Template;
class ParserTemplates
{
    private string $text;
    private array $templates;
    public function __construct(string $text) {
        $this->text = $text;
        $this->parse();
    }
    private function find_sub_templates($string) {
        preg_match_all("/\{{2}((?>[^\{\}]+)|(?R))*\}{2}/x", $string, $matches);
        return $matches;
    }
    private function parse() : void
    {
        $text_templates = $this->find_sub_templates($this->text);
        $this->templates = [];
        foreach ($text_templates[0] as $text_template) {
            $_parser = new ParserTemplate($text_template);
            $this->templates[] = $_parser->getTemplate();
        }
    }
    public function getTemplates(string $name = null) : array {
        $outtemplates = [];
        if (isset($name)) {
            foreach ($this->templates as $template) {
                if ($template->getName() == $name) {
                    $outtemplates[] = $template;
                }
            }
        } else {
            $outtemplates = $this->templates;
        }
        return $outtemplates;
    }
}