<?php

namespace WikiConnect\ParseWiki\DataModel;

use WikiConnect\ParseWiki\DataModel\Attribute;

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

    private Attribute $attrs;

    private bool $selfClosing = false;
    /**
     * Citation constructor.
     *
     * @param string $content The content of the citation.
     * @param string $attributes The attributes of the citation.
     */
    public function __construct(string $content, string $attributes = "", string $original_text = "", bool $selfClosing = false)
    {
        $this->selfClosing = $selfClosing;
        $this->content = $content;
        $this->attributes = $attributes;
        $this->original_text = $original_text;
        $this->attrs = new Attribute($this->attributes);
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
     * Set the content of the citation.
     *
     * @param string $content The content of the citation.
     *
     * @return void
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }
    /**
     * Set the attributes of the citation.
     *
     * @param string $attributes The attributes of the citation.
     *
     * @return void
     */
    public function setAttributes($attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * Convert the citation to a string.
     *
     * @return string The citation as a string.
     */
    public function toString(): string
    {
        if ($this->selfClosing && $this->content == "") {
            return "<ref " . trim($this->attributes) . "/>";
        }
        return "<ref " . trim($this->attributes) . ">" . $this->content . "</ref>";
    }

    public function Attrs(): Attribute
    {
        return $this->attrs;
    }

    /**
     * Convert the citation to a string. include Convert Attributes to a string
     *
     * @return string The citation as a string.
     */
    public function toStringNew(): string
    {
        $attrs = $this->attrs->toString();
        if ($this->selfClosing && $this->content == "") {
            return "<ref " . trim($attrs) . "/>";
        }
        return "<ref " . trim($attrs) . ">" . $this->content . "</ref>";
    }
}
