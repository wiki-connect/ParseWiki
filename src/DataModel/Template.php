<?php
namespace ParseWiki\DataModel;

class Template
{
    private string $template;
    private string $name;
    private array $parameters;
    public function __construct(string $name, array $parameters = []) {
        $this->name = $name;
        $this->parameters = $parameters;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getParameters(): array
    {
        return $this->parameters;
    }
    public function toString(bool $newLine): string
    {
        $line = $newLine ? "\n" : "";
        $this->template = "{{" . $this->name;
        foreach ($this->parameters as $key => $value) {
            $this->template .= $line."|" . $key . "=" . $value;
        }
        $this->template .= "}}";
        return $this->template;
    }
}