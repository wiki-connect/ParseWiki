<?php

namespace WikiConnect\ParseWiki\DataModel;

use WikiConnect\ParseWiki\DataModel\Parameters;


/**
 * Class Template
 *
 * Represents a template in a wikitext document.
 *
 * @package WikiConnect\ParseWiki\DataModel
 */
class Template
{
    /**
     * The name.
     *
     * @var string The name.
     */
    private string $name;
    /**
     * The name stripped of any underscores.
     *
     * @var string
     */
    private string $nameStrip;

    /**
     * The text.
     *
     * @var string The original, unprocessed text.
     */
    private string $originalText;

    public Parameters $parameters;

    /**
     * Template constructor.
     *
     * @param string $name The name.
     * @param array $parameters The parameters.
     * @param string $originalText The text.
     */

    public function __construct(string $name, array $parameters = [], string $originalText = "")
    {
        $this->name = $name;
        $this->nameStrip = trim(str_replace('_', ' ', $name));
        $this->originalText = $originalText;
        $this->parameters = new Parameters($parameters);
    }

    /**
     * Get the name stripped of any underscores.
     *
     * @return string The name stripped of any underscores.
     */

    public function getStripName(): string
    {
        return $this->nameStrip;
    }

    /**
     * Get the name.
     *
     * @return string The name.
     */

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the original, unprocessed text.
     * Example: {{cite web|...}}
     * @return string The original text.
     */

    public function getOriginalText(): string
    {
        return $this->originalText;
    }

    /**
     * Get the parameters.
     *
     * @return array The parameters.
     */

    public function getParameters(): array
    {
        return $this->parameters->getParameters();
    }
    /**
     * Set the name.
     *
     * @param string $name The new name.
     *
     * @return void
     */

    public function setName(string $name): void
    {
        $this->name = $name;
        $this->nameStrip = trim(str_replace('_', ' ', $name));
    }

    /**
     * Convert the content to a string.
     *
     * @return string The tag as a string.
     */
    public function toString(bool $newLine = false, $ljust = 0): string
    {
        $separator = $newLine ? "\n" : "";
        $templateName = $newLine ? trim($this->name) : $this->name;

        $result = "{{" . $templateName . $separator;

        $result .= $this->parameters->toString($ljust, $newLine);

        $result .= $separator . "}}";
        return $result;
    }
    public function __toString(): string
    {
        return $this->toString();
    }
}
