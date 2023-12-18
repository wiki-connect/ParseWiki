<?php
namespace WikiConnect\ParseWiki\DataModel;

class Table
{
    private array $data;
    private array $header;
    private string $classes;
    public function __construct(array $header, array $data, string $classes = "") {
        $this->data = $data;
        $this->header = $header;
        $this->classes = ($classes == "") ? "wikitable" : $classes;
    }
    public function getHeaders(): array
    {
        return $this->header;
    }
    public function getData(): array
    {
        return $this->data;
    }
    public function get(string $key, int $position): string 
    {
        return $this->data[$position][array_search($key, $this->data)];
    }
    public function setData(string $key, int $position, string $value): void 
    {
        $this->data[$position][array_search($key, $this->data)] = $value;
    }
    public function toString(): string
    {
        $tableMarkup = "{| class=\"".$this->classes."\"" . PHP_EOL;
        $tableMarkup .= "|-" . PHP_EOL;
        
        for ($i = 0; $i < count($this->header); $i++) {
            if ($i + 1 == count($this->header)) {
                $tableMarkup .= "!" . $this->header[$i] .PHP_EOL;
            } else {
                $tableMarkup .= "!" . $this->header[$i] .PHP_EOL;
            }
        }
        $tableMarkup .= "|-" . PHP_EOL;
        for ($ii = 0; $ii < count($this->data); $ii++) {
            for ($i = 0; $i < count($this->header); $i++) {
                if ($i + 1 == count($this->header)) {
                    $tableMarkup .= "|" . $this->data[$ii][$i] . PHP_EOL;
                } else {
                    $tableMarkup .= "|" . $this->data[$ii][$i]. "|";
                }
            }
            if ($ii + 1 != count($this->data)) {
                $tableMarkup .= "|-" . PHP_EOL;
            }
        }
        $tableMarkup .= "|}";
        return $tableMarkup;
    }
}