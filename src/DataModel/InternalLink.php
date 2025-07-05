<?php
namespace WikiConnect\ParseWiki\DataModel;

/**
 * Class InternalLink
 *
 * Represents an internal link with optional display text.
 *
 * @package WikiConnect\ParseWiki\DataModel
 */
class InternalLink
{
    /**
     * @var string The page target.
     */
    private string $target;
    /**
     * @var string The display text of the page.
     */
    private string $text;

    /**
     * InternalLink constructor.
     *
     * Creates a new InternalLink object.
     *
     * @param string $target The page target.
     * @param string $text The display text of the page. Defaults to the page target.
     */
    public function __construct(string $target, string $text = "")
    {
        $this->target = $target;
        $this->text = ($text == "") ? $target : $text;
    }

    /**
     * Get the display text of the page.
     *
     * @return string The display text of the page.
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Get the page target.
     *
     * @return string The page target.
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * Convert the internal link to a string representation.
     *
     * @return string The string representation of the link in markdown format.
     */
    public function toString(): string
    {
        if ($this->text == $this->target) {
            return "[[".$this->target."]]";
        } else {
            return "[[".$this->target."|".$this->text."]]";
        }
    }
    public function __toString(): string
    {
        return $this->toString();
    }
}

