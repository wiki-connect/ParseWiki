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
    public function getParameter(string $key): string 
    {
        return $this->parameters[$key];
    }
    public function setParameter(string $key, string $value): void 
    {
        $this->parameters[$key] = $value;
    }
    public function toString(bool $newLine = false): string
    {
        $line = $newLine ? "\n" : "";
        $this->template = "{{" . $this->name;
        $i = 1;
        foreach ($this->parameters as $key => $value) {
            if($i == $key){
            $this->template .= $line."|" . $value;
            } else {
            $this->template .= $line."|" . $key . "=" . $value;
            }
            $i++;
        }
        $this->template .= "}}";
        return $this->template;
    }
}