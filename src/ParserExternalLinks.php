<?php
namespace WikiConnect\ParseWiki;
use WikiConnect\ParseWiki\DataModel\ExternalLink;

/**
 * Class ParserExternalLinks
 * @package WikiConnect\ParseWiki
 */
class ParserExternalLinks
{
    /**
     * Text to parse
     * @var string
     */
    private string $text;

    /**
     * Array of ExternalLink objects
     * @var array
     */
    private array $links;

    /**
     * ParserExternalLinks constructor.
     * @param string $text
     */
    public function __construct(string $text) {
        $this->text = $text;
        $this->parse();
    }

    /**
     * Find all external links in the given text
     * @param string $string
     * @return array
     */
    private function find_sub_links(string $string): array
    {
        preg_match_all("/\[(https?:\/\/\S+)(.*?)\]/s", $string, $matches);
        return $matches;
    }

    /**
     * Parse the text for external links
     */
    public function parse(): void
    {
        $text_links = $this->find_sub_links($this->text);
        $this->links = [];
        foreach ($text_links[1] as $key => $text_link) {
            $_ExternalLinks = new ExternalLink($text_link, trim($text_links[2][$key]));
            $this->links[] = $_ExternalLinks;
        }
    }

    /**
     * Get all external links found in the text
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}
