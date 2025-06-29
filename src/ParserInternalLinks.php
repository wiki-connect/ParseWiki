<?php

namespace WikiConnect\ParseWiki;

use WikiConnect\ParseWiki\DataModel\InternalLink;

/**
 * Class ParserInternalLinks
 * @package WikiConnect\ParseWiki
 */
class ParserInternalLinks
{
    /**
     * @var string The text to parse
     */
    private string $text;
    /**
     * @var array The parsed pages
     */
    private array $targets = [];

    /**
     * ParserInternalLinks constructor.
     * @param string $text The text to parse
     */
    public function __construct(string $text)
    {
        $this->text = $text;
        $this->parse();
    }

    /**
     * Find all internal links in the given string
     * @param string $string The string to search for internal links
     * @return array An array with two elements. The first element is an array of all matches, the second element is an array of the matches with the first two and last two characters removed.
     */
    private function find_sub_links(string $string): array
    {
        preg_match_all("/\[{2}((?>[^\[\]]+)|(?R))*\]{2}/x", $string, $matches);
        return $matches;
    }

    /**
     * Parse the text for internal links
     */
    public function parse(): void
    {
        $text_links = $this->find_sub_links($this->text);
        foreach ($text_links[0] as $text_link) {
            if (preg_match("/^\[\[(.*?)(\]\])$/s", $text_link, $matches)) {
                $parts = explode("|", $matches[1], 2);
                $_InternalLink = (count($parts) == 1) ? new InternalLink($parts[0]) : new InternalLink($parts[0], $parts[1]);
                $this->targets[] = $_InternalLink;
            }
        }
    }

    /**
     * Get all internal links found in the text
     * @return array An array of InternalLink objects
     */
    public function getTargets(): array
    {
        return $this->targets;
    }
}


