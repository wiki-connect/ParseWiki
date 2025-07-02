<?php

namespace WikiConnect\ParseWiki\DataModel;

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
    private string $name_strip;

    /**
     * The text of the template.
     *
     * @var string
     */
    private string $templateText;

    /**
     * The parameters of the template.
     *
     * @var array
     */
    private array $parameters;

    /**
     * Template constructor.
     *
     * @param string $name The name of the template.
     * @param array $parameters The parameters of the template.
     * @param string $templateText The text of the template.
     */

    public function __construct(string $name, array $parameters = [], string $templateText = "")
    {
        $this->name = $name;
        $this->name_strip = trim(str_replace('_', ' ', $name));
        $this->parameters = $parameters;
        $this->templateText = $templateText;
    }

    /**
     * Get the text of the template.
     *
     * @return string The text of the template.
     */

    public function getTemplateText(): string
    {
        return $this->templateText;
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
        return $this->name_strip;
    }

    /**
     * Get the parameters of the template.
     *
     * @return array The parameters of the template.
     */

    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Delete a parameter of the template.
     *
     * @param string $key The key of the parameter to delete.
     *
     * @return void
     */

    public function deleteParameter(string $key): void
    {
        if (array_key_exists($key, $this->parameters)) {
            unset($this->parameters[$key]);
        }
    }

    /**
     * Get a parameter of the template.
     *
     * @param string $key The key of the parameter to get.
     *
     * @return string The value of the parameter.
     */

    public function getParameter(string $key, string $default = null): string
    {
        return $this->parameters[$key] ?? $default;
    }

    /**
     * Check if a parameter of the template exists.
     *
     * @param string $key The key of the parameter to check.
     *
     * @return bool True if the parameter exists, false otherwise.
     */
    public function hasParameter(string $key): bool
    {
        return array_key_exists($key, $this->parameters);
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

    /**
     * Set a parameter of the template.
     *
     * @param string $key The key of the parameter to set.
     * @param string $value The value of the parameter.
     *
     * @return void
     */

    public function setParameter(string $key, string $value): void
    {
        $this->parameters[$key] = $value;
    }

    /**
     * Change the name of a parameter of the template.
     *
     * @param string $old The old name of the parameter.
     * @param string $new The new name of the parameter.
     *
     * @return void
     */

    public function changeParameterName(string $old, string $new): void
    {
        $newParameters = [];
        foreach ($this->parameters as $k => $v) {
            if ($k === $old) {
                $k = $new;
            };
            $newParameters[$k] = $v;
        }
        $this->parameters = $newParameters;
    }

    /**
     * Change the names of multiple parameters of the template.
     *
     * @param array $params_new The new names of the parameters.
     *
     * @return void
     */

    public function changeParametersNames(array $params_new): void
    {
        $newParameters = [];
        foreach ($this->parameters as $k => $v) {
            $k = isset($params_new[$k]) ? $params_new[$k] : $k;
            $newParameters[$k] = $v;
        }
        $this->parameters = $newParameters;
    }

    /**
     * Convert the template to a string.
     *
     * @param bool $newLine If true, a new line is added after the template.
     * @param int $ljust The number of spaces to left-justify the parameter names.
     *
     * @return string The string representation of the template.
     */
    private function formatParameters(string $separator, int $ljust, bool $newLine): string
    {
        $result = "";
        $index = 1;
        foreach ($this->parameters as $key => $value) {
            $formattedValue = $newLine ? trim($value) : $value;

            if ($index == $key) {
                $result .= "|" . $formattedValue;
            } else {
                $formattedKey = $ljust > 0 ? str_pad($key, $ljust, " ") : $key;
                // $result .= $separator . "|" . $formattedKey . " = " . $formattedValue;
                $result .= $separator . "|" . $formattedKey . "=" . $formattedValue;
            }
            $index++;
        }

        return $result;
    }

    public function toString(bool $newLine = false, $ljust = 0): string
    {
        $separator = $newLine ? "\n" : "";
        $templateName = $newLine ? trim($this->name) : $this->name;

        $result = "{{" . $templateName;

        $result .= $this->formatParameters($separator, $ljust, $newLine);

        $result .= $separator . "}}";
        return $result;
    }
}
