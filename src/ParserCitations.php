<?php

namespace WikiConnect\ParseWiki;

use WikiConnect\ParseWiki\DataModel\Citation;

/**
 * Class ParserCitations
 *
 * Parses text to extract citations from wikitext.
 *
 * @package WikiConnect\ParseWiki
 */
class ParserCitations
{
    /**
     * @var string The text to parse for citations.
     */
    private string $text;

    /**
     * @var Citation[] Array of extracted citations.
     */
    private array $citations;

    /**
     * ParserCitations constructor.
     *
     * Initializes the parser with the given text and starts the parsing process.
     *
     * @param string $text The text to parse.
     */
    public function __construct(string $text)
    {
        $this->text = $text;
        $this->parse();
    }

    /**
     * Find and extract citations from the given string.
     *
     * Uses a regular expression to match citations wrapped in <ref> tags.
     *
     * @param string $string The string to search for citations.
     * @return array An array of matches found in the string.
     */
    private function find_sub_citations(string $string): array
    {
        preg_match_all("/<ref([^\/>]*?)>(.+?)<\/ref>/is", $string, $matches);
        return $matches;
    }

    /**
     * Parse the text for citations and store them.
     *
     * Uses find_sub_citations to identify citations and initializes
     * Citation objects for each one found.
     *
     * @return void
     */
    public function parse(): void
    {
        $text_citations = $this->find_sub_citations($this->text);
        $this->citations = [];
        foreach ($text_citations[1] as $key => $text_citation) {
            $_Citation = new Citation($text_citations[2][$key], $text_citation, $text_citations[0][$key]);
            $this->citations[] = $_Citation;
        }
    }

    /**
     * Get all citations found in the text.
     *
     * Returns the array of Citation objects extracted from the text.
     *
     * @return Citation[] Array of Citation objects.
     */
    public function getCitations(): array
    {
        return $this->citations;
    }
}
