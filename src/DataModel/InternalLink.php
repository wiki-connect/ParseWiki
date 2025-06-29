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
     * @var string The link target.
     */
    private string $link;
    /**
     * @var string The display text of the link.
     */
    private string $text;

    /**
     * InternalLink constructor.
     *
     * Creates a new InternalLink object.
     *
     * @param string $link The link target.
     * @param string $text The display text of the link. Defaults to the link target.
     */
    public function __construct(string $link, string $text = "")
    {
        $this->link = $link;
        $this->text = ($text == "") ? $link : $text;
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
     * Get the link target.
     *
     * @return string The link target.
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * Convert the internal link to a string representation.
     *
     * @return string The string representation of the link in markdown format.
     */
    public function toString(): string
    {
        if ($this->text == $this->link) {
            return "[[".$this->link."]]";
        } else {
            return "[[".$this->link."|".$this->text."]]";
        }
    }
}
