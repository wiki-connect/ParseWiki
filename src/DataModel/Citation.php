<?php

namespace WikiConnect\ParseWiki\DataModel;

/**
 * Class Citation
 *
 * Represents a citation in a wikitext document.
 *
 * @package WikiConnect\ParseWiki\DataModel
 */
class Citation
{
    /**
     * @var string The content of the citation.
     */
    private string $content;

    /**
     * @var string The attributes of the citation.
     */
    private string $attributes;
    /**
     * @var string The original, unprocessed text of the citation.
     */
    private string $original_text;

    /**
     * Citation constructor.
     *
     * @param string $content The content of the citation.
     * @param string $attributes The attributes of the citation.
     */
    public function __construct(string $content, string $attributes = "", string $original_text = "")
    {
        $this->content = $content;
        $this->attributes = $attributes;
        $this->original_text = $original_text;
    }
    /**
     * Get the original, unprocessed text of the citation.
     * Example: <ref name="name">{{cite web|...}}</ref>
     * @return string The original text of the citation.
     */
    public function getOriginalCiteText(): string
    {
        return $this->original_text;
    }
    /**
     * Get the content of the citation.
     * Example: {{cite web|...}}
     * @return string The content of the citation.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Get the attributes of the citation.
     *
     * @return string The attributes of the citation.
     */
    public function getAttributes(): string
    {
        return $this->attributes;
    }

    /**
     * Convert the citation to a string.
     *
     * @return string The citation as a string.
     */
    public function toString(): string
    {
        return "<ref " . trim($this->attributes) . ">" . $this->content . "</ref>";
    }
}
