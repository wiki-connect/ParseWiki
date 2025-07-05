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
     * The name.
     *
     * @var string The name.
     */
    private string $tagname;
    /**
     * @var string The content.
     */
    private string $content;

    /**
     * @var string The attributes.
     */
    private string $attributes;
    /**
     * @var string The original, unprocessed text.
     */
    private string $originalText;

    public Attribute $attrs;

    private bool $selfClosing = false;
    /**
     * Citation constructor.
     *
     * @param string $content The content.
     * @param string $attributes The attributes.
     * @param string $originalText The original, unprocessed text.
     * @param bool $selfClosing Whether the citation is self-closing.
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

    /**
     * Get the name.
     *
     * @return string The name.
     */

    public function getName(): string
    {
        return $this->tagname;
    }
    /**
     * Get the original, unprocessed text.
     * Example: <ref name="name">{{cite web|...}}</ref>
     * @return string The original text.
     */
    public function getOriginalText(): string
    {
        return $this->originalText;
    }
    /**
     * Get the content.
     * Example: {{cite web|...}}
     * @return string The content.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the content.
     *
     * @param string $content The content.
     *
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Get the attributes.
     *
     * @return string The attributes.
     */
    public function getAttributes(): string
    {
        return $this->attributes;
    }
    /**
     * Set the attributes.
     *
     * @param string $attributes The attributes.
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
     * Convert the content to a string.
     *
     * @return string The citation as a string.
     */
    public function toString(): string
    {
        $attrs = $this->attrs->toString();
        $attrsStr = trim($attrs);
        $space = ($attrsStr != "") ? " " : "";
        if ($this->selfClosing && trim($this->content) === "") {
            return "<" . $this->tagname . "" . $attrsStr . "/>";
        }
        return "<" . $this->tagname . $space . $attrsStr . ">" . $this->content . "</" . trim($this->tagname) . ">";
    }
    public function __toString(): string
    {
        return $this->toString();
    }
}
