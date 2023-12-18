<?php
namespace WikiConnect\ParseWiki;
use WikiConnect\ParseWiki\DataModel\ExternalLink;
class ParserExternalLinks
{
    private string $text;
    private array $links;
    public function __construct(string $text) {
        $this->text = $text;
        $this->parse();
    }
    private function find_sub_links($string) {
        preg_match_all("/\[(https?:\/\/\S+)(.*?)\]/s", $string, $matches);
        return $matches;
    }
    public function parse() : void
    {
        $text_links = $this->find_sub_links($this->text);
        $this->links = [];
         foreach ($text_links[1] as $key => $text_link) {
            $_ExternalLinks =new ExternalLink($text_link,trim($text_links[2][$key]));
            $this->links[] = $_ExternalLinks;
            
        }
    }
    public function getLinks() : array {
        return $this->links;
    }
}