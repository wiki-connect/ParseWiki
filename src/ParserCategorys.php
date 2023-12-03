<?php
namespace WikiConnect\ParseWiki;

class ParserCategorys
{
    private array $categorys;
    private string $namespace;
    private string $text;
    public function __construct(string $text, string $namespace = "") {
        $this->text = $text;
        $this->namespace = $namespace == "" ? "Category" : $namespace;
        $this->categorys = array();
        $this->parse();
    }
    private function parse() : void
    {
        if (preg_match_all("\[\[\s*".$this->namespace."\s*\:([^\]\]]+?)\]\]", $this->text, $matches)) {
            foreach ($matches[1] as $nil => $mvalue) {
                $bleh = explode("|", $mvalue);
                $category = trim(array_shift($bleh));
                $bleh = null;
                $categories[md5($category)] = $category;
            }
        }

        if (!empty($categories)) {
            $this->categorys = $categories;
        }
    }
    public function getCategorys() : array {
       return $this->categorys;
    }
}