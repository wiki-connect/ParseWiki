<?php
namespace ParseWiki\DataModel;

class Citation
{
    private string $template;
    private string $options;
    public function __construct(string $template, string $options = "") {
        $this->template = $template;
        $this->options = $options;
    }
    public function getTemplate(): string {
        return $this->template;
    }
    public function getOptions(): string {
        return $this->options;
    }
    public function toString(): string {
        return "<ref ".trim($this->options).">".$this->template."</ref>";
    }
}