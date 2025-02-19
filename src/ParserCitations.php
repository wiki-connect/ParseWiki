<?php

namespace WikiConnect\ParseWiki;

use WikiConnect\ParseWiki\DataModel\Citation;

class ParserCitations
{
    private string $text;
    private array $citations;
    public function __construct(string $text)
    {
        $this->text = $text;
        $this->parse();
    }
    private function find_sub_citations($string)
    {
        preg_match_all("/<ref([^\/>]*?)>(.+?)<\/ref>/is", $string, $matches);
        return $matches;
    }
    public function parse(): void
    {
        $text_citations = $this->find_sub_citations($this->text);
        $this->citations = [];
        foreach ($text_citations[1] as $key => $text_citation) {
            $_Citation = new Citation($text_citations[2][$key], $text_citation, $text_citations[0][$key]);
            $this->citations[] = $_Citation;
        }
    }

    public function getCitations(): array
    {
        return $this->citations;
    }
}
