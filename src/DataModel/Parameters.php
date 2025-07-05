<?php

namespace WikiConnect\ParseWiki\DataModel;

/**
 * Class Parameters
 *
 * Represents a template in a wikitext document.
 *
 * @package WikiConnect\ParseWiki\DataModel
 */
class Parameters
{
    /**
     * The parameters of the template.
     *
     * @var array
     */
    private array $parameters;

    /**
     * Parameters constructor.
     *
     * @param array $parameters The parameters of the template.
     */

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
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

    public function delete(string $key): void
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

    public function get(string $key, string $default = ""): string
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
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->parameters);
    }
    /**
     * Set a parameter of the template.
     *
     * @param string $key The key of the parameter to set.
     * @param string $value The value of the parameter.
     *
     * @return void
     */

    public function set(string $key, string $value): void
    {
        $this->parameters[$key] = $value;
    }

    /**
     * Change the names of multiple parameters of the template.
     *
     * @param array $map The new names of the parameters.
     *
     * @return void
     */

    public function changeParametersNames(array $map): void
    {
        $newParameters = [];

        // use foreach to keep the order
        foreach ($this->parameters as $k => $v) {
            if (array_key_exists($k, $map)) {
                $newKey = $map[$k];
                // new key has priority in case of name duplication
                $newParameters[$newKey] = $v;
            } elseif (!in_array($k, $map)) {
                // ignore keys that will be replaced later
                $newParameters[$k] = $v;
            }
            // the key that exists as value in the map will be skipped if it's not in the original keys
        }

        $this->parameters = $newParameters;
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
        $this->changeParametersNames([$old => $new]);
    }

    public function toString(int $ljust = 0, bool $newLine = false): string
    {
        $separator = $newLine ? "\n" : "";
        $result = "";
        $index = 1;
        foreach ($this->parameters as $key => $value) {
            $formattedValue = $newLine ? trim($value) : $value;

            if ($index == $key) {
                $result .= "|" . $formattedValue;
            } else {
                $formattedKey = $ljust > 0 ? str_pad($key, $ljust, " ") : $key;
                $result .= $separator . "|" . $formattedKey . "=" . $formattedValue;
            }
            $index++;
        }

        return trim($result);
    }
    public function __toString(): string
    {
        return $this->toString();
    }
}
