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
     * Citation constructor.
     *
     * @param string $content The content of the citation.
     * @param string $attributes The attributes of the citation.
     */
    public function __construct(string $content, string $attributes = "")
    {
        $this->content = $content;
        $this->attributes = $attributes;
    }


    /**
     * Get the template name of the citation.
     *
     * @return string The template name of the citation.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Get the options of the citation.
     *
     * @return string The options of the citation.
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

