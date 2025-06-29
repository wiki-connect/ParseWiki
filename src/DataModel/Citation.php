<?php

namespace WikiConnect\ParseWiki\DataModel;

class Citation
{
    private string $template;
    private string $options;
    private string $cite_text;
    public function __construct(string $template, string $options = "", string $cite_text = "")
    {
        $this->template = $template;
        $this->options = $options;
        $this->cite_text = $cite_text;
    }
    public function getCiteText(): string
    {
        return $this->cite_text;
    }
    public function getTemplate(): string
    {
        return $this->template;
    }
    public function getOptions(): string
    {
        return $this->options;
    }
    public function toString(): string
    {
        return "<ref " . trim($this->options) . ">" . $this->template . "</ref>";
    }
}
