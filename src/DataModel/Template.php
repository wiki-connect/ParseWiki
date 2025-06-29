<?php

namespace WikiConnect\ParseWiki\DataModel;

class Template
{
    private string $template;
    private string $name;
    private string $name_strip;
    private string $templateText;
    private array $parameters;
    public function __construct(string $name, array $parameters = [], string $templateText = "")
    {
        $this->name = $name;
        $this->name_strip = trim(str_replace('_', ' ', $name));
        $this->parameters = $parameters;
        $this->templateText = $templateText;
    }
    public function getTemplateText(): string
    {
        return $this->templateText;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getStripName(): string
    {
        return $this->name_strip;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
    public function deleteParameter(string $key): void
    {
        if (array_key_exists($key, $this->parameters)) {
            unset($this->parameters[$key]);
        }
    }
    public function getParameter(string $key): string
    {
        return $this->parameters[$key] ?? "";
    }
    public function setTempName(string $name): void
    {
        $this->name = $name;
    }
    public function setParameter(string $key, string $value): void
    {
        $this->parameters[$key] = $value;
    }
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

    public function changeParametersNames(array $params_new): void
    {
        $newParameters = [];
        foreach ($this->parameters as $k => $v) {
            $k = isset($params_new[$k]) ? $params_new[$k] : $k;
            $newParameters[$k] = $v;
        }
        $this->parameters = $newParameters;
    }

    public function toString(bool $newLine = false, $ljust = 0): string
    {
        $line = $newLine ? "\n" : "";
        $this->template = $newLine ? "{{" . trim($this->name) : "{{" . $this->name;
        $i = 1;
        foreach ($this->parameters as $key => $value) {
            $value = $newLine ? trim($value) : $value;

            if ($i == $key) {
                $this->template .= "|" . $value;
            } else {
                if ($ljust > 0) {
                    $key = str_pad($key, $ljust, " ");
                }
                $this->template .= $line . "|" . $key . " = " . $value;
            }
            $i++;
        }
        $this->template .= $line . "}}";
        return $this->template;
    }
}
