<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\ParserTemplates;
use WikiConnect\ParseWiki\DataModel\Template;

class ParserTemplatesTest extends TestCase
{

    /**
     * @test
     */
    public function testFindSubTemplates()
    {
        $text = '{{Template|param1=value1|param2=value2}}';
        $parser = new ParserTemplates($text);
        $templates = $parser->getTemplates();
        $this->assertIsArray($templates);
        $this->assertCount(1, $templates);
        $this->assertInstanceOf(Template::class, $templates[0]);
    }

    /**
     * @test
     */
    public function testParse()
    {
        $text = '{{Template|param1=value1|param2=value2}}';
        $parser = new ParserTemplates($text);
        $templates = $parser->getTemplates();
        $this->assertIsArray($templates);
        $this->assertCount(1, $templates);
        $this->assertInstanceOf(Template::class, $templates[0]);
    }

    /**
     * @test
     */
    public function testParseSub()
    {
        $text = '{{Template|param1=value1|param2={{Nested|a=1|b=2}}}}';
        $parser = new ParserTemplates($text);
        $templates = $parser->getTemplates();
        $this->assertIsArray($templates);
        $this->assertCount(2, $templates);
        $this->assertInstanceOf(Template::class, $templates[0]);
        $this->assertInstanceOf(Template::class, $templates[1]);
    }

    /**
     * @test
     */
    public function testGetTemplates()
    {
        $text = '{{Template|param1=value1|param2=value2}}';
        $parser = new ParserTemplates($text);
        $templates = $parser->getTemplates();
        $this->assertIsArray($templates);
        $this->assertCount(1, $templates);
        $this->assertInstanceOf(Template::class, $templates[0]);
    }

    /**
     * @test
     */
    public function testGetTemplatesWithName()
    {
        $text = '{{Template|param1=value1|param2=value2}}{{OtherTemplate|param1=value111|param2=value2}}';
        $parser = new ParserTemplates($text);
        $templates = $parser->getTemplates('Template');
        $this->assertIsArray($templates);
        $this->assertCount(1, $templates);
        $this->assertInstanceOf(Template::class, $templates[0]);
    }

    /**
     * @test
     */
    public function testGetTemplatesWithInvalidName()
    {
        $text = '{{Template|param1=value1|param2=value2}}';
        $parser = new ParserTemplates($text);
        $templates = $parser->getTemplates('InvalidTemplate');
        $this->assertIsArray($templates);
        $this->assertCount(0, $templates);
    }
}