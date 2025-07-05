<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\DataModel\Template;

class TemplateTest extends TestCase
{
    public function testTemplateCreation()
    {
        $params = ['1' => 'val1', 'x' => 'val2'];
        $text = '{{Example|1=val1|x=val2}}';
        $template = new Template('Example_Name', $params, $text);

        $this->assertEquals('Example_Name', $template->getName());
        $this->assertEquals('Example Name', $template->getStripName());
        $this->assertEquals($text, $template->getOriginalText());
        $this->assertEquals($params, $template->getParameters());
    }

    public function testsetName()
    {
        $template = new Template('OldName');
        $template->setName('NewName');
        $this->assertEquals('NewName', $template->getName());
    }

    public function testToStringDefault()
    {
        $template = new Template('T', ['1' => 'A', 'k' => 'B']);
        $expected = '{{T|A|k=B}}';
        $this->assertEquals($expected, $template->toString());
    }

    public function testToStringMultiline()
    {
        $template = new Template('Test', ['1' => 'A', 'x' => 'B']);
        $expected = "{{Test\n|A\n|x=B\n}}";
        $this->assertEquals($expected, $template->toString(true));
    }
}
