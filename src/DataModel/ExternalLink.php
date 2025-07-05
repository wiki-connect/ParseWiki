<?php

namespace WikiConnect\ParseWiki\DataModel;

/**
 * Class ExternalLink
 * Represents an external link with optional display text.
 */
class ExternalLink
{
    private string $link;
    private string $text;

    /**
     * ExternalLink constructor.
     *
     * @param string $link The URL of the external link.
     * @param string $text The display text for the link. Defaults to an empty string.
     */
    public function __construct(string $link, string $text = "")
    {
        $this->link = $link;
        $this->text = $text;
    }

    /**
     * Get the display text of the link.
     *
     * @return string The display text of the link.
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Get the URL of the link.
     *
     * @return string The URL of the link.
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * Convert the external link to a string representation.
     *
     * @return string The string representation of the link in markdown format.
     */
    public function toString(): string
    {
        if ($this->text == $this->link) {
            return "[" . $this->link . "]";
        } else {
            return "[" . $this->link . " " . $this->text . "]";
        }
    }
    public function __toString(): string
    {
        return $this->toString();
    }
}
