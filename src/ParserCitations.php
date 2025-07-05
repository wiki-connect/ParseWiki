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
        $matches = [];

        // full tags: <ref>...</ref>
        preg_match_all(
            '/<ref([^\/>]*)>(.+?)<\/ref>/is',
            $string,
            $standardMatches,
            PREG_SET_ORDER
        );

        foreach ($standardMatches as $match) {
            $matches[] = [
                'original'    => $match[0],
                'name'        => "ref",
                'attributes'  => $match[1],
                'content'     => $match[2],
                'selfClosing' => false,
            ];
        }

        // Self-closing tags like <ref ... />
        preg_match_all(
            '/<ref\s+([^>\/]*?)\s*\/>/is',
            $string,
            $selfClosingMatches,
            PREG_SET_ORDER
        );

        foreach ($selfClosingMatches as $match) {
            $matches[] = [
                'original'    => $match[0],
                'name'        => "ref",
                'attributes'  => $match[1],
                'content'     => '',
                'selfClosing' => true,
            ];
        }

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

        foreach ($text_citations as $citationData) {
            $_Citation = new Citation(
                $citationData['content'],
                $citationData['attributes'],
                $citationData['original'],
                $citationData['selfClosing']
            );
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
