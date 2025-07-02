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
     * The name of the template.
     *
     * @var string
     */
    private string $name;
    /**
     * The name of the template stripped of any underscores.
     *
     * @var string
     */
    private string $nameStrip;

    /**
     * The text of the template.
     *
     * @var string
     */
    private string $originalText;

    public Parameters $parameters;

    /**
     * Template constructor.
     *
     * @param string $name The name of the template.
     * @param array $parameters The parameters of the template.
     * @param string $originalText The text of the template.
     */

    public function __construct(string $name, array $parameters = [], string $originalText = "")
    {
        $this->name = $name;
        $this->nameStrip = trim(str_replace('_', ' ', $name));
        $this->originalText = $originalText;
        $this->parameters = new Parameters($parameters);
    }

    /**
     * Get the text of the template.
     *
     * @return string The text of the template.
     */

    public function getOriginalText(): string
    {
        return $this->originalText;
    }

    /**
     * Get the name of the template.
     *
     * @return string The name of the template.
     */

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the name of the template stripped of any underscores.
     *
     * @return string The name of the template stripped of any underscores.
     */

    public function getStripName(): string
    {
        return $this->nameStrip;
    }

    /**
     * Get the parameters of the template.
     *
     * @return array The parameters of the template.
     */

    public function getParameters(): array
    {
        return $this->parameters->getParameters();
    }
    /**
     * Set the name of the template.
     *
     * @param string $name The new name of the template.
     *
     * @return void
     */

    public function setTempName(string $name): void
    {
        $this->name = $name;
    }

    public function toString(bool $newLine = false, $ljust = 0): string
    {
        $separator = $newLine ? "\n" : "";
        $templateName = $newLine ? trim($this->name) : $this->name;

        $result = "{{" . $templateName . $separator;

        $result .= $this->parameters->toString($ljust, $newLine);

        $result .= $separator . "}}";
        return $result;
    }
}
