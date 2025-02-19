<?php

namespace WikiConnect\ParseWiki;

use WikiConnect\ParseWiki\DataModel\Template;

class ParserTemplates
{
    private string $text;
    private array $templates;
    public function __construct(string $text)
    {
        $this->text = $text;
        $this->templates = [];
        $this->parse();
    }
    private function find_sub_templates($string)
    {
        preg_match_all("/\{{2}((?>[^\{\}]+)|(?R))*\}{2}/xm", $string, $matches);

        return $matches;
    }
    public function parse_sub($text): void
    {
        $text_templates = $this->find_sub_templates($text);
        foreach ($text_templates[0] as $text_template) {
            $_parser = new ParserTemplate($text_template);
            $this->templates[] = $_parser->getTemplate();
        }
        // echo "lenth this->templates:" . count($this->templates) . "\n";
    }
    public function parse(): void
    {
        $text_templates = $this->find_sub_templates($this->text);
        foreach ($text_templates[0] as $text_template) {
            $_parser = new ParserTemplate($text_template);
            $this->templates[] = $_parser->getTemplate();
            $text_template2 = trim($text_template);
            // remove first 2 litters and 2 last
            $text_template2 = substr($text_template2, 2, -2);
            $this->parse_sub($text_template2);
        }
        // echo "lenth this->templates:" . count($this->templates) . "\n";
    }
    public function getTemplates(string $name = null): array
    {
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
