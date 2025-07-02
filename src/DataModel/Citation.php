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
     * @var string The name of the tag.
     */
    private string $tagname;
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
    private string $originalText;

    private Attribute $attrs;

    private bool $selfClosing = false;
    /**
     * Citation constructor.
     *
     * @param string $content The content of the citation.
     * @param string $attributes The attributes of the citation.
     */
    public function __construct(string $content, string $attributes = "", string $originalText = "", bool $selfClosing = false)
    {
        $this->tagname = "ref";
        $this->content = $content;
        $this->attributes = $attributes;
        $this->originalText = $originalText;
        $this->selfClosing = $selfClosing;
        $this->attrs = new Attribute($this->attributes);
    }

    public function getName(): string
    {
        return $this->tagname;
    }
    /**
     * Get the original, unprocessed text of the citation.
     * Example: <ref name="name">{{cite web|...}}</ref>
     * @return string The original text of the citation.
     */
    public function getOriginalText(): string
    {
        return $this->originalText;
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
    public function setContent(string $content): void
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
    public function setAttributes(string $attributes): void
    {
        $this->attributes = $attributes;
        $this->attrs = new Attribute($this->attributes);
    }

    public function Attrs(): Attribute
    {
        return $this->attrs;
    }

    /**
     * Convert the citation to a string using the Attribute object for attribute formatting.
     *
     * @return string The citation as a string.
     */
    public function toString(): string
    {
        $attrs = $this->attrs->toString();
        if ($this->selfClosing && $this->content === "") {
            return "<ref " . trim($attrs) . "/>";
        }
        $space = (trim($attrs) != "") ? " " : "";
        return "<ref" . $space . trim($attrs) . ">" . $this->content . "</ref>";
    }
}
