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
     * @var string The template name of the citation.
     */
    private string $template;

    /**
     * @var string The options of the citation.
     */
    private string $options;

    /**
     * @var string The cite text of the citation.
     */
    private string $cite_text;

    /**
     * Citation constructor.
     *
     * @param string $template The template name of the citation.
     * @param string $options The options of the citation.
     * @param string $cite_text The cite text of the citation.
     */
    public function __construct(string $template, string $options = "", string $cite_text = "")
    {
        $this->template = $template;
        $this->options = $options;
        $this->cite_text = $cite_text;
    }

    /**
     * Get the cite text of the citation.
     *
     * @return string The cite text of the citation.
     */
    public function getCiteText(): string
    {
        return $this->cite_text;
    }

    /**
     * Get the template name of the citation.
     *
     * @return string The template name of the citation.
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Get the options of the citation.
     *
     * @return string The options of the citation.
     */
    public function getOptions(): string
    {
        return $this->options;
    }

    /**
     * Convert the citation to a string.
     *
     * @return string The citation as a string.
     */
    public function toString(): string
    {
        return "<ref " . trim($this->options) . ">" . $this->template . "</ref>";
    }
}

