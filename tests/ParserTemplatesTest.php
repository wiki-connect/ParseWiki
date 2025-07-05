<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\ParserTemplates;
use WikiConnect\ParseWiki\DataModel\Template;
use WikiConnect\ParseWiki\DataModel\Parameters;

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
    /**
     * @test
     */
    public function testTemplateStructureWithParameters()
    {
        $text = '{{MyBox|name=Test|value=42}}';
        $parser = new ParserTemplates($text);
        $templates = $parser->getTemplates();

        $this->assertCount(1, $templates);
        $template = $templates[0];

        // تأكيد النوع
        $this->assertInstanceOf(Template::class, $template);
        $this->assertInstanceOf(Parameters::class, $template->parameters);

        // التأكد من القيم
        $this->assertTrue($template->parameters->has('name'));
        $this->assertEquals('Test', $template->parameters->get('name'));
        $this->assertEquals('42', $template->parameters->get('value'));

        // toString يعكس التعديلات
        $template->parameters->set('value', '100');
        $this->assertStringContainsString('value=100', $template->toString());
    }
    /**
     * @test
     */
    public function testUnnamedParametersInTemplate()
    {
        $text = '{{Location|12.34|56.78|type=city}}';
        $parser = new ParserTemplates($text);
        $templates = $parser->getTemplates();

        $template = $templates[0];
        $params = $template->parameters;

        $this->assertInstanceOf(Parameters::class, $params);
        $this->assertEquals('12.34', $params->get(1));
        $this->assertEquals('56.78', $params->get(2));
        $this->assertEquals('city', $params->get('type'));
    }
    /**
     * @test
     */
    public function testUpdateParameterThroughTemplateObject()
    {
        $text = '{{Info|a=1|b=2}}';
        $template = (new ParserTemplates($text))->getTemplates()[0];

        $params = $template->parameters;
        $this->assertEquals('2', $params->get('b'));

        // تعديل
        $params->set('b', 'updated');
        $this->assertEquals('updated', $params->get('b'));

        // إزالة
        $params->delete('a');
        $this->assertFalse($params->has('a'));
    }
    /**
     * @test
     */
    public function testNestedTemplatesAreTemplatesWithParameters()
    {
        $text = '{{Main|data={{Sub|x=10|y=20}}|info=ok}}';
        $templates = (new ParserTemplates($text))->getTemplates();

        $this->assertCount(2, $templates);

        foreach ($templates as $template) {
            $this->assertInstanceOf(Template::class, $template);
            $this->assertInstanceOf(Parameters::class, $template->parameters);
        }

        $main = $templates[0];
        $this->assertEquals('Main', $main->getName());
        $this->assertStringContainsString('{{Sub|x=10|y=20}}', $main->parameters->get('data'));
    }
    /**
     * @test
     */
    public function testToStringReflectsParameterChanges()
    {
        $text = '{{Test|x=1|y=2}}';
        $template = (new ParserTemplates($text))->getTemplates()[0];

        $template->parameters->set('x', '999');
        $template->parameters->delete('y');

        $output = $template->toString();

        $this->assertStringContainsString('x=999', $output);
        $this->assertStringNotContainsString('y=2', $output);
    }
    public function testChangeParameterNamesThroughTemplate()
    {
        $templateText = '{{Test|a=x|d=y|c=z}}';
        $Parser = new ParserTemplates($templateText);
        $template = $Parser->getTemplates()[0];

        $this->assertTrue($template->parameters->has('a'));
        $this->assertEquals('x', $template->parameters->get('a'));

        $template->parameters->changeParametersNames(['a' => 'd']);

        // Final result should have only one 'd' (with value of 'a'), and 'c' stays
        $this->assertEquals(['d' => 'x', 'c' => 'z'], $template->parameters->getParameters());
        $this->assertEquals('x', $template->parameters->get('d'));
        $this->assertEquals('z', $template->parameters->get('c'));
    }
}
