<?php

namespace WikiConnect\ParseWiki\DataModel;

/**
 * Class Table
 *
 * @package WikiConnect\ParseWiki\DataModel
 */
class Table
{
    /**
     * @var array $data The data of the table.
     */
    private array $data;
    /**
     * @var array $header The header of the table.
     */
    private array $header;
    /**
     * @var string $classes The classes of the table.
     */
    private string $classes;

    /**
     * Table constructor.
     *
     * @param array $header The header of the table.
     * @param array $data The data of the table.
     * @param string $classes The classes of the table.
     */
    public function __construct(array $header, array $data, string $classes = "")
    {
        $this->data = $data;
        $this->header = $header;
        $this->classes = ($classes == "") ? "wikitable" : $classes;
    }

    /**
     * Get the headers of the table.
     *
     * @return array The headers of the table.
     */
    public function getHeaders(): array
    {
        return $this->header;
    }

    /**
     * Get the data of the table.
     *
     * @return array The data of the table.
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get a value from the table.
     *
     * @param string $key The key to search for.
     * @param int $position The position of the value to retrieve.
     *
     * @return string The value at the given position.
     *
     * @throws \InvalidArgumentException If the key does not exist in the header.
     */
    public function get(string $key, int $position): string
    {
        if (!in_array($key, $this->header)) {
            throw new \InvalidArgumentException("The key \"$key\" does not exist in the header.");
        }
        return $this->data[$position][array_search($key, $this->header)];
    }

    /**
     * Set a value in the table.
     *
     * @param string $key The key to search for.
     * @param int $position The position of the value to set.
     * @param string $value The new value.
     *
     * @return void
     *
     * @throws \InvalidArgumentException If the key does not exist in the header.
     */
    public function setData(string $key, int $position, string $value): void
    {
        if (!in_array($key, $this->header)) {
            throw new \InvalidArgumentException("The key \"$key\" does not exist in the header.");
        }
        $this->data[$position][array_search($key, $this->header)] = $value;
    }

    /**
     * Convert the table to a string.
     *
     * @return string The table as a string.
     */
    public function toString(): string
    {
        $tableMarkup = "{| class=\"" . $this->classes . "\"" . PHP_EOL;
        $tableMarkup .= "|-" . PHP_EOL;

        for ($i = 0; $i < count($this->header); $i++) {
            if ($i + 1 == count($this->header)) {
                $tableMarkup .= "!" . $this->header[$i] . PHP_EOL;
            } else {
                $tableMarkup .= "!" . $this->header[$i] . PHP_EOL;
            }
        }
        $tableMarkup .= "|-" . PHP_EOL;
        for ($ii = 0; $ii < count($this->data); $ii++) {
            for ($i = 0; $i < count($this->header); $i++) {
                if ($i + 1 == count($this->header)) {
                    $tableMarkup .= "|" . $this->data[$ii][$i] . PHP_EOL;
                } else {
                    $tableMarkup .= "|" . $this->data[$ii][$i] . "|";
                }
            }
            if ($ii + 1 != count($this->data)) {
                $tableMarkup .= "|-" . PHP_EOL;
            }
        }
        $tableMarkup .= "|}";
        return $tableMarkup;
    }
    public function __toString(): string
    {
        return $this->toString();
    }
}
