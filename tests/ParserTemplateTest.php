<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\ParserTemplate;
use WikiConnect\ParseWiki\DataModel\Template;

class ParserTemplateTest extends TestCase
{
    public function testSimpleTemplate()
    {
        $templateText = '{{Infobox person|name=John Doe|birth_date=1990-01-01}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();

        $this->assertInstanceOf(Template::class, $template);
        $this->assertEquals('Infobox person', $template->getName());
        $params = $template->getParameters();
        $this->assertEquals('John Doe', $params['name']);
        $this->assertEquals('1990-01-01', $params['birth_date']);
    }

    public function testTemplateWithUnnamedParameter()
    {
        $templateText = '{{Coord|12.34|56.78|type=city}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();

        $params = $template->getParameters();
        $this->assertEquals('12.34', $params[1]);
        $this->assertEquals('56.78', $params[2]);
        $this->assertEquals('city', $params['type']);
    }

    public function testTemplateWithNestedTemplate()
    {
        $templateText = '{{Infobox|data={{Nested|a=1|b=2}}|other=val}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();

        $params = $template->getParameters();
        $this->assertStringContainsString('{{Nested|a=1|b=2}}', $params['data']);
        $this->assertEquals('val', $params['other']);
    }
}