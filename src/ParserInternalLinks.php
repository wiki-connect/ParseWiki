<?php

namespace WikiConnect\ParseWiki;

use WikiConnect\ParseWiki\DataModel\InternalLink;

class ParserInternalLinks
{
    private string $text;
    private array $links;
    public function __construct(string $text)
    {
        $this->text = $text;
        $this->parse();
    }
    private function find_sub_links($string)
    {
        preg_match_all("/\[{2}((?>[^\[\]]+)|(?R))*\]{2}/x", $string, $matches);
        return $matches;
    }
    public function parse(): void
    {
        $text_links = $this->find_sub_links($this->text);
        $this->links = [];
        foreach ($text_links[0] as $text_link) {
            if (preg_match("/^\[\[(.*?)(\]\])$/s", $text_link, $matches)) {
                $parts = explode("|", $matches[1], 2);
                $_InternalLink = (count($parts) == 1) ? new InternalLink($parts[0]) : new InternalLink($parts[0], $parts[1]);
                $this->links[] = $_InternalLink;
            }
        }
    }
    public function getLinks(): array
    {
        return $this->links;
    }
}
