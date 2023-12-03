<?php
namespace WikiConnect\ParseWiki\DataModel;

class ExternalLink
{
    private string $link;
    private string $text;
    public function __construct(string $link, string $text = "") {
        $this->link = $link;
        $this->text = $text;
    }
    public function getText(): string {
        return $this->text;
    }
    public function getLink(): string {
        return $this->link;
    }
    public function toString(): string {
        if ($this->text == $this->link) {
            return "[".$this->link."]";
        } else {
            return "[".$this->link." ".$this->text."]";
        }
    }
}